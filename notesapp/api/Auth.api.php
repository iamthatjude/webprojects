<?php 
/**
 * Auth.api.php - Processes Register, Log In, Reset Password
 * 
 * API requests sent here from respective pages
 * 
 **/

// Set Header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../system/functions.sys.php'; // Functions

require_once '../classes/Database.class.php'; // Database Class
$database = new Database();

require_once '../classes/CSRF.class.php'; // CSRF Class
$csrf_security = new CSRF( $database );

require_once '../classes/Auth.class.php'; // Auth Class
//$auth = new Auth();
$auth = new Auth( $database );

$out = array('error' => false);
/**
 * This will enable you receive data from VueJS as Objects instead of FormData
 * whether through POST or GET
 * If you're to use this, delete Lines 34 through 40 as they're not needed
 * 
 * Display the next line to receive object(s)
 * $data = json_decode(file_get_contents("php://input"));
 * 
 * Access the objects by "$data->form_name"
*/
$action = '';
if ( $_SERVER['REQUEST_METHOD'] === 'GET' ){
    $action = $_GET['action'];
}
elseif ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    $action = $_POST['action'];
}


// 1. Login
if ( $action == 'login' ){
    $user_type = strip_tags(stripslashes($_POST['user_type'])); // User Type: User | Admin
    $auth_name = strip_tags(stripslashes($_POST['auth_name'])); // Username
    $password = strip_tags($_POST['password']); // Password

    $Payload = array(
        'token' => $_POST['token'],
        'csrf_token' => $_POST['csrf_token'],
        'csrf_token_time' => $_POST['csrf_token_time']
    );
    $csrf = $csrf_security->csrf_init( $Payload );

    if ( $csrf['error'] == false ){
        if ( $user_type == 'user' ){ // USER
            $login = $auth->login( $user_type, $auth_name, $password );   

            if ( $login ){
                if ( @$login['auth'] == 'nonexistent' ){ // Account Does Not Exist
                    $out['error'] = true;
                    $out['notice'] = 'nonexistent'; // Notice
                    $out['message'] = LOGIN_NONEXISTENT; // Message
                }
                elseif ( @$login['auth'] == 'deleted' || @$login['auth'] == 'suspended' ){ // Account Deleted/Suspended
                    $out['error'] = true;
                    $out['notice'] = 'cannotlogin'; // Notice
                    $out['message'] = LOGIN_CANNOTLOGIN . ucfirst($login['auth']) .'!'; // Message
                }
                elseif ( @$login['auth'] == 'wrong' ){ // Username/Password Is Wrong
                    $out['error'] = true;
                    $out['notice'] = 'wrong'; // Notice
                    $out['message'] = $login['wrong_message']; // Message
                }
                elseif ( (@$login['auth'] == 'success') && (!empty($login['uid']) && !empty($login['username'])) ){ // Log In Successful
                    session_start(); // Start Session
                    session_regenerate_id(); // regenerate session id

                    unset($_SESSION['csrf_token']); // Unset CSRF Token
                    unset($_SESSION['csrf_token_time']); // Unset CSRF Token Time

                    $_SESSION['loggedin'] = true;
                    $_SESSION['uid'] = $login['uid']; // User ID
                    $_SESSION['username'] = $login['username']; // Username
                    $_SESSION['fullname'] = $login['fullname']; // Full Name
                    $_SESSION['picture'] = $login['picture']; // Profile Picture
                    $_SESSION['token'] = $login['token']; // Login Token
                    $_SESSION['last_login_time'] = time(); // Last Login Time

                    $out['error'] = false;
                    $out['notice'] = 'success'; // Notice
                    $out['message'] = LOGIN_SUCCESS; // Message
                    $out['url'] = USER_HOME; // URL Redirection
                } 
            } else {
                $out['error'] = true;
                $out['message'] = json_encode($login); // Message
            }
        }
        elseif ( $user_type == 'admin' ){}// ADMIN
    } else {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_time']);

        $out['error'] = true;
        $out['notice'] = 'wrong'; // Notice
        $out['message'] = $csrf['message']; // Message
    }
    
    echo json_encode($out);
}


// 2. Register
if ( $action == 'register' ){
    $email = strip_tags(stripslashes($_POST['email']));

    // Validate Email Again
    if ( filter_var($email, FILTER_VALIDATE_EMAIL) ){
        $password = strip_tags($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);

        $token = md5( uniqid(rand(), TRUE) . time() );

        $Data = array(
            'username' => strip_tags(stripslashes($_POST['username'])),
            'email' => $email,
            'password' => $password,
            'token' => $token
        );

        $register = $auth->register( $Data );

        if ( $register ){
            if ( @$register['email'] == 'exists' ){ // Email Exists
                $out['error'] = true;
                $out['notice'] = 'exists'; // Notice
                $out['message'] = REGISTER_EMAIL_EXISTS; // Message
            }
            elseif ( ($register['auth'] == 'success') && ($register['mail'] == 'mail_sent') ){ // Account Created
                $out['error'] = false;
                $out['notice'] = 'success'; // Notice
                $out['message'] = REGISTER_SUCCESS_CODESENT; // Message
                $out['url'] = USER_LOGIN; // URL Redirection
            }
            elseif ( ($register['auth'] == 'success') && ($register['mail'] == 'mail_not_sent') ){ // Account Created
                $out['error'] = false;
                $out['notice'] = 'success'; // Notice
                $out['message'] = REGISTER_SUCCESS_CODENOTSENT . $register['token']; // Message
                $out['url'] = USER_LOGIN; // URL Redirection
            }
            else { // Account Not Created
                $out['error'] = true;
                $out['notice'] = 'fail'; // Notice
                $out['message'] = REGISTER_FAILED . json_encode($register); // Message
            }
        } else {
            $out['error'] = true;
            $out['message'] = json_encode($register);
        }
    } else {
        $out['error'] = true;
        $out['notice'] = 'fail'; // Notice
        $out['message'] = REGISTER_EMAIL_INVALID; // Message
    }

    echo json_encode($out);
}

header("Content-type: application/json");
die();
