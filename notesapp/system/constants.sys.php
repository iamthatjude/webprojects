<?php
/**
 * constants.sys.php -- Defined Constants
 */

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
define( 'USER_HOME', 'Page.Dashboard' ); // Homepage/Dashboard
define( 'USER_PROFILE', 'Account.Profile' ); // Account: Profile
define( 'USER_BILLING', 'Account.Billing' ); // Account: Billing
define( 'USER_SECURITY', 'Account.Security' ); // Account: Security
define( 'USER_NOTIFICATIONS', 'Account.Notifications' ); // Account: Notifications


// General Definitions
define( 'SITE_NAME', 'IN-PROGRESS WEB APP' );
define( 'SITE_NAME_SHORT', 'IP WEB APP' );


// API Keys
//define( '', '' ); //


// Database Table Definitions
define( 'TBL_ADM', 'admin' ); // Admin table
define( 'TBL_USR', 'users' ); // Users table
define( 'TBL_ULOG', 'users_log' ); // Users Log table
define( 'TBL_UTOKEN', 'users_token' ); // Users Token table

?> 