<?php
/**
 * config.sys.php -- Configuration
 */

// Get Base Url -- http/https
if ( isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ){
        $ssl = 'https'; // HTTPS or SSL Version
}
else {
    $ssl = 'http'; // HTTP Version
}

//--Local
$base_url = ($ssl) ."://". $_SERVER['HTTP_HOST'] ."/dir/inprogresswebapp";
//--Online
//$base_url = ($ssl) ."://". $_SERVER['HTTP_HOST'];
//$base_url = ($ssl) ."://". $_SERVER['HTTP_HOST'] ."/";


// Some Settings
$pageSeparator = '|';
?>