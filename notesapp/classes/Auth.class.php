<?php
/**
 * Auth.class.php -- Authentication Class
 */

ini_set( 'display_errors', 1 );

class Auth
{
    private $db;

    // database connection & constants
    public function __construct( Database $db )
    {
        ob_start();
        include '../system/config.sys.php'; // Configurations
        include '../system/constants.sys.php'; // Defined Constants
		//include '../inc/send_mails.inc.php'; // Mailer Sender
		//include '../inc/email_templates.inc.php'; // Email Templates

		$this->db = $db;
    }

    // close database connection
    function __destruct()
    {
        $this->db = null;
        unset($this->db);
        ob_end_flush();
    }


	// An example from ChatGPT
	public function authenticate($username, $password) {
        // Example authentication logic using $this->db
        // For instance: $this->db->query("SELECT * FROM users WHERE username = ? AND password = ?", [$username, $password]);
    }

    // 1. Login
    public function login( $user_type, $auth_name, $password )
    {
        $output = array();

        switch ( $user_type ){
            case "user":
				$query = $this->db->query( "SELECT uid, username, password, fullname, picture, login_error_count, status FROM ". TBL_USR . " WHERE username=?", [$auth_name] );
            	break;
            case "admin":
                $query = $this->db->query( "SELECT aid, username, password FROM ". TBL_ADM . " WHERE username=?", [$auth_name] );
            	break;
        }

        try {
            if ( $query->rowCount() > 0 ){
                $row = $query->fetch(PDO::FETCH_OBJ);

                if ( $row->status == 'deleted' || $row->status == 'suspended' ){ // Account Deleted/Suspended
					$output['auth'] = $row->status;
				}
                elseif( password_verify($password, $row->password) ){ // see..password is good :)
					$token = md5( uniqid(rand(), TRUE) . time() ); // Login Token

					if ( $user_type == 'user' ){ // USER
						// Log In Successful
						$params = [
							$token,
							'Yes',
							$row->uid,
							$row->username
						];
						$this->db->query( "UPDATE ". TBL_USR ." SET token=?, online=?, last_login_time=NOW() WHERE uid=? AND username=?", $params );
						
						// Log Report
						$this->db->query( "INSERT INTO ". TBL_ULOG ." (uid, log_detail, created_at) VALUES (?, ?, NOW())", [$row->uid, USERLOG_LOGIN_SUCCESS] );

                        $output['auth'] = 'success';

                        $output['uid'] = $row->uid;
                        $output['username'] = $row->username;
                        $output['fullname'] = $row->fullname;
                        $output['picture'] = $row->picture;
                        $output['token'] = $token;
                    }
                    elseif ( $user_type == 'admin' ){ // ADMIN
                        // Log In Successful
                    }
                } else { // Username/Password Is Wrong
					if ( $row->login_error_count == LOGIN_ERRMIN_COUNT ){
						// Increase Login Error Count and Log Report
						$this->login_error_processesor( $row->uid, $row->username, "", USERLOG_LOGIN_UP_FAILED );

                    	$output['auth'] = 'wrong';
						$output['wrong_message'] = LOGIN_WRONG;
					}
					elseif ( $row->login_error_count == LOGIN_ERRMAX_WARN ){
						// Increase Login Error Count and Log Report
						$this->login_error_processesor( $row->uid, $row->username, "", USERLOG_LOGIN_UP_FAILED );

						$output['auth'] = 'wrong';
						$output['wrong_message'] = LOGIN_ERRMSG_WARN;
					}
					elseif ( $row->login_error_count == LOGIN_ERRMAX_COUNT ){
						// Suspend Account and Log Report
						$this->login_error_processesor( $row->uid, $row->username, "suspend", USERLOG_LOGIN_SUSPENDED );

						$output['auth'] = 'wrong';
						$output['wrong_message'] = LOGIN_ERRMSG_COUNT;
					}
                }
            } else { // Account Does Not Exist
                $output['auth'] = 'nonexistent';
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        unset($query);
        return $output;
    }
	// 1.1. Login Error Account Processor
	public function login_error_processesor( $user_id, $username="", $status="", $log_msg )
	{
		if ( $status == "suspend" ){
			// Suspend Account
			$this->db->query( "UPDATE ". TBL_USR ." SET status=? WHERE uid=? AND username=?", ["suspended", $user_id, $username] );
		} else {
			// Increase Login Error Count
			$this->db->query( "UPDATE ". TBL_USR ." SET login_error_count=login_error_count+1 WHERE uid=? AND username=?", [$user_id, $username] );
		}

		// Log Error Report
		$this->db->query( "INSERT INTO ". TBL_ULOG ." (uid, log_detail, created_at) VALUES (?, ?, NOW())", [$user_id, $log_msg] );
	}


    // 2. Register
    public function register( array $data )
    {
        $output = array();

		$check = $this->db->query( "SELECT email FROM ". TBL_USR ." WHERE email=?", [$data['email']] );

        try {
			if ( $check->rowCount() > 0 ){ // Email Exists
				$output['email'] = 'exists';
			}
			else {
				$insert_data = " username=?";
				$insert_data .= ", password=?";
				$insert_data .= ", email=?";
				$insert_data .= ", created_at=NOW()";

				$params = [
					strtolower($data['username']),
					$data['password'],
					$data['email']
				];
				$insert = $this->db->query( "INSERT INTO ". TBL_USR. " SET ". $insert_data, $params );

				if ( $insert ){ // Account Created
					$user_id = $this->db->getConnection()->lastInsertId();

					$auth = $this->db->query( "INSERT INTO ". TBL_UTOKEN ." (uid, token, reason) VALUES (?, ?, ?)", [$user_id, $data['token'], "register"] );
					if ( $auth ){
						$output['auth'] = 'success';

						// send verification email
						//$send_mail = SendMail( 'Verification Code', $data['email'], NoReplyEmail, VerficationAuthToken( CompanyName, $data['token'], CompanyTeamName ) );
						
						//if ( $send_mail == 'sent' ){
							//$output['mail'] = 'mail_sent';
						//} else {
							//$output['mail'] = 'mail_not_sent';
							//$output['token'] = $data['token'];
						//}
						$output['mail'] = 'mail_not_sent';
						$output['token'] = $data['token'];
					}
				} else { // Account Not Created
					$output = $this->db->getConnection()->errorInfo();
				}
			}

        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

		unset($check);
        return $output;
    }


    // 4. Update Password
	/*public function update_password( $user_type, $user_id, $current_password, $new_password )
	{
		$output = array();

		switch ( $user_type ){
			case "member":
				$check = $this->db->prepare("SELECT mid, password FROM ". MEM ." WHERE mid=:user_id");
				break;
			case "admin":
				$check = $this->db->prepare("SELECT aid, password FROM ". ADM ." WHERE aid=:user_id");
				break;
		}
		$check->bindParam(':user_id', $user_id);
		$check->execute();

		try {
			$row = $check->fetch(PDO::FETCH_OBJ); // $var->colName and NOT $var['colName']

			if ( password_verify($current_password, $row->password) ){ // see..password is good :)

				// Update Password
				switch ( $user_type ){
					case "member":
						$this->db->exec("UPDATE ". MEM ." SET password='$new_password' WHERE mid='".$row->mid."'");
						$output['auth'] = 'success';
						break;
					case "admin":
						$this->db->exec("UPDATE ". ADM ." SET password='$new_password' WHERE aid='".$row->aid."'");
						$output['auth'] = 'success';
						break;
				}
			}
			else { // Password Is Wrong
				$output['auth'] = 'wrong';
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		unset($check);
		return $output;
	}*/


	// 5. Reset Password
	/*public function reset( $reset_type, $email, $token, $new_password='', $reset_time='' )
	{
		$output = array();

		if ( $reset_type == 'send_mail' ){
			$check = $this->db->prepare("SELECT mid, email FROM ". MEM ." WHERE email=:email");
			$check->bindParam(':email', $email);
			$check->execute();

			try {
				if ( $check->rowCount() > 0 ){ // Account Exists
					$row = $check->fetch(PDO::FETCH_OBJ);

					$checkPD = $this->db->query("SELECT first_name, surname FROM ". PD ." WHERE mid='".$row->mid."'");
					$rowPD = $checkPD->fetch(PDO::FETCH_OBJ);

					$auth = $this->db->exec("INSERT INTO ". MTOKEN ." (mid, token, reason) VALUES ('".$row->mid."', '$token', 'resetpass')");
					if ( $auth ){
						$output['auth'] = 'success';

						// send reset password email
						$send_mail = SendMail( 'Reset Password Token', $row->email, NoReplyEmail, ResetPassword( $rowPD->first_name, $rowPD->surname, $token ) );
						
						if ( $send_mail == 'sent' ){
							$output['mail'] = 'mail_sent';
						} else {
							$output['mail'] = 'mail_not_sent';
							$output['token'] = $token;
						}
					}

					unset($checkPD);
				}
				else { // Account Does Not Exist
					$output['auth'] = 'nonexistent';
				}
			}
			catch(PDOException $e){
				echo $e->getMessage();
			}
			
			unset($check);
		}
		elseif ( $reset_type == 'update_pass' ){
			try {
				$max_time = 60*5; // in seconds but it is 5minutes

				// Check if 5minutes Has Expired
				if ( ($reset_time + $max_time) < time() ){ // expired
					$this->db->exec("DELETE FROM ". MTOKEN ." WHERE token='$token' AND reason='resetpass'"); // delete token

					$output['auth'] = 'fail';
					$output['message'] = 'This Token Has Expired.<br>Kindly Generate A New Request.';
				} else {
					$check = $this->db->prepare("SELECT token FROM ". MTOKEN ." WHERE token=:token AND reason='resetpass'");
					$check->bindParam(':token', $token);
					$check->execute();

					if ( $check->rowCount() > 0 ){ // Token Exists
						$update_auth = $this->db->exec("UPDATE ". MTOKEN ." SET used='Yes' WHERE token='$token' AND reason='resetpass'");
						$update_member = $this->db->exec("UPDATE ". MEM ." SET password='$new_password' WHERE email='$email'");

						if ( $update_auth == TRUE && $update_member == TRUE ){
							$output['auth'] = 'success';
						}
					}
					else { // Token Does Not Exist
						$output['auth'] = 'fail';
						$output['message'] = 'This Token Is Incorrect!';
					}
				}
			}
			catch(PDOException $e){
				echo $e->getMessage();
			}
			
			unset($check);
		}

		return $output;
	}*/

}
