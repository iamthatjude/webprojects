<?php
/**
 * index.php -- Page Redirection
 */

date_default_timezone_set('Africa/Lagos');

include '../../system/config.sys.php'; // Configurations
include '../../system/constants.sys.php'; // Defined Constants

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ( isset($_SESSION['uid']) ){ // currently logged in | uid: User ID
	header( 'Location: '. USER_HOME );
}
elseif ( !isset($_SESSION['uid']) || $_SESSION["loggedin"] !== true || trim($_SESSION['uid']) == '' ){ // not logged in | uid: User ID
	header( 'Location: '. USER_LOGIN );
	exit;
}