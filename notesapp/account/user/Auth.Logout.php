<?php
/**
 * Auth.Logout.php - Processes Log Out
 */

require_once '../../classes/Database.class.php'; // Database Class
$db = new Database();

include '../../system/config.sys.php'; // Configurations
include '../../system/constants.sys.php'; // Defined Constants
include '../../system/texts.sys.php'; // System Texts Constatnts

session_start();

//error_reporting(E_ALL);
//error_reporting(-1);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

$user_id = $_SESSION['uid'];
//$role = $_SESSION['role'];
$loggedin = $_SESSION["loggedin"];

$query = $db->query( "SELECT uid FROM ". TBL_USR ." WHERE uid=?", [$user_id] );

if ( $query->rowCount() > 0 ){
    $db->query( "UPDATE ". TBL_USR ." SET token=NULL, online='No' WHERE uid=?", [$user_id] );

    $db->query( "INSERT INTO ". TBL_ULOG ." (uid, log_detail, created_at) VALUES (?, ?, NOW())", [$user_id, "You <b>logged out</b>."] );

    session_destroy();
    header('Location: ' . USER_URL );
}
?>