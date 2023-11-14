<?php
/**
 * constants.sys.php -- Defined Constants
 */

// General Definitions
define( 'SITE_NAME', 'NotesApp' ); // Site Name - Long
define( 'SITE_NAME_SHORT', 'NA' ); // Site Name - Short/Initials
define( 'MAX_TIME', 60*60*24 ); // Maximum Time then Destroy Login Session | in seconds but it is 24hours


// Directory Definitions
define( 'APP_URL', $base_url .'/' );
define( 'ASSETS_URL', $base_url .'/template_assets/' );
define( 'ADMIN_URL', $base_url .'/account/admin/' );
define( 'USER_URL', $base_url .'/account/user/' );
define( 'ACCOUNT_URL', $base_url .'/account/' ); /* never used; might be needed */


// Page Name/Link Definitions
//-- Admin

//-- User
define( 'USER_LOGIN', 'Auth.Login' ); // Log In
define( 'USER_LOGOUT', 'Auth.Logout' ); // Log Out
define( 'USER_REGISTER', 'Auth.Register' ); // Register
define( 'USER_RE_PASSWORD', 'Auth.ResetPassword' ); // Reset Password
define( 'USER_UP_PASSWORD', 'Auth.UpdatePassword' ); // Update Password
define( 'USER_HOME', 'Page.Notes' ); // Page: Homepage/Dashboard
define( 'USER_NOTEBOOKS', 'Notes.Notebooks' ); // Notes: Notebooks
define( 'USER_BIN', 'Notes.Bin' ); // Notes: Bin
define( 'USER_PROFILE', 'Page.Profile' ); // Page: Profile

//-- Status
define( 'STA_404', 'Status.404' ); // Status: Error 404
define( 'STA_500', 'Status.500' ); // Status: Error 404
define( 'STA_DOWN', 'Status.Down' ); // Status: Down/Maintenance


// API Keys
//define( '', '' ); //


// Database Table Definitions
define( 'TBL_ADM', 'admin' ); // Admin table
define( 'TBL_USR', 'users' ); // Users table
define( 'TBL_ULOG', 'users_log' ); // Users Log table
define( 'TBL_ULOGIND', 'users_login_data' ); // Users Login Data table
define( 'TBL_UTOKEN', 'users_token' ); // Users Token table

?> 