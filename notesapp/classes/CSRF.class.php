<?php
/**
 * CSRF.class.php -- CSRF Checker Class
 */

//session_start();
ini_set( 'display_errors', 1 );

Class CSRF
{
    private $db;

	// database connection & constants
	public function __construct( Database $db )
	{
		ob_start();
		//include '../system/config.sys.php'; // Configurations
		//include '../system/constants.sys.php'; // Constants Defined

		$this->db = $db;
	}

	// close database connection
	function __destruct()
	{
		$this->db = null;
        unset($this->db);
		ob_end_flush();
	}


	// CSRF Protection Check for Non-Logged In Users
	public function csrf_init( array $data )
	{
		$output = array();

		// CSRF Token Validation
		if ( $data['token'] === $data['csrf_token'] ){
			// CSRF Token Time Validation
			$max_time = 60*60*24; // in seconds but it is 24hours
	
			if ( ($data['csrf_token_time'] + $max_time) >= time() ){
				$output['error'] = false;
			} else {
				$output['error'] = true;
				$output['message'] = CSRF_EXPIRED; // Message
			}
			
		} else {
			$output['error'] = true;
			$output['message'] = CSRF_PROBLEM; // Message
		}
		
		return $output;
	}


    // CSRF Protection Check for Logged In Users
	function csrf_loggedin( $table, $column, $user_id, $token )
	{
		$output = array();

		//$check = "SELECT ". $column .", token FROM ". $table ." WHERE ". $column ."='$user_id' AND token='$token'";
		$check = "SELECT ". $column .", token FROM ". $table ." WHERE ". $column ."=? AND token=?";
		// Login Token Validation
		//if ( $this->db->query($check) ){
		if ( $this->db->query($check, [$user_id, $token]) ){
			$output['error'] = false;
		} else {
			$output['error'] = true;
			$output['message'] = CSRF_NOACCESS; // Message
		}
		unset($check);

		return $output;
	}

}
