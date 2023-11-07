<?php
/**
 * texts.sys.php -- Texts Used in Application
 */

# https://stackoverflow.com/questions/1414079/most-efficient-way-to-do-language-file-in-php
# https://lokalise.com/blog/implementing-php-localization-complete-guide/
# https://www.toptal.com/php/build-multilingual-app-with-gettext

/*function _T( $phrase ){
    static $texts = array(
        // 'text' => 'message'
        'LOGIN_NONEXISTENT' => 'This Account Doesn\'t Exist!',
        'LOGIN_CANNOTLOGIN' => 'This Account Has Been ',
        'LOGIN_WRONG' => 'Your Username/Password Is Incorrect!',
        'LOGIN_SUCCESS' => 'Log In Successful.<br>Welcome Back 😊',
    );

    return ( !array_key_exists($phrase,$texts) ) ? $phrase : $texts[$phrase];
}*/

// CSRF Messages
define( 'CSRF_EXPIRED', 'CSRF Token Expired! Reload Page.' );
define( 'CSRF_PROBLEM', 'Problem with CSRF Token Validation! Reload Page.' );
define( 'CSRF_NOACCESS', 'You Do Not Have Access!' );

// Login Messages
define( 'LOGIN_NONEXISTENT', 'This Account Doesn\'t Exist!' );
define( 'LOGIN_CANNOTLOGIN', 'This Account Has Been ' );
define( 'LOGIN_WRONG', 'Your Login Details Are Incorrect!' );
define( 'LOGIN_ERRMAX_WARN', 1 ); // Failed Log In Warning
define( 'LOGIN_ERRMSG_WARN', 'Your Account Will Be Suspended If Your Next Log In Attempt Fails!' ); // Failed Log In Warning Message
define( 'LOGIN_ERRMIN_COUNT', 0 ); // Failed Log In Count Starts Here
define( 'LOGIN_ERRMAX_COUNT', 2 ); // Failed Log In Count then Suspension
define( 'LOGIN_ERRMSG_COUNT', 'Your Account Has Been Suspended!' ); // Failed Log In Count Message
define( 'LOGIN_EMAIL_INVALID', 'Your Email Is Not Valid!' );
define( 'LOGIN_SUCCESS', 'Log In Successful.<br>Welcome Back 😊' );

// Register Messages
define( 'REGISTER_EMAIL_EXISTS', 'Email Already Exists!' );
define( 'REGISTER_EMAIL_INVALID', 'Your Email Is Not Valid!' );
define( 'REGISTER_SUCCESS_CODESENT', 'Your Registration Was Successful.<br>Check Email for Authentication Code.' );
define( 'REGISTER_SUCCESS_CODENOTSENT', 'Your Registration Was Successful But We Couldn\'t Send You An Email.<br>Here is your code: ' );
define( 'REGISTER_FAILED', 'Account Creation Failed; Try Again or Contact Admin: ' );

// Users:
// Log Messages
define( 'USERLOG_LOGIN_SUCCESS', 'You <b>logged in</b>.' );
define( 'USERLOG_LOGIN_UP_FAILED', 'Log in <b>failed</b>! Your Username/Password was wrong.' );
define( 'USERLOG_LOGIN_SUSPENDED', '<b>Account Suspended</b>!' );

// Order Messages
define( 'ORDER_EXISTS', 'This Order Already Exists!' );
define( 'ORDER_DOESNTEXIST', 'This Order Doesn\'t Seem To Exist!' );
define( 'ORDER_ADD_SUCCESS', 'Order Has Been Added.' );
define( 'ORDER_ADD_FAILED', 'Order Addition Failed; Try Again or Contact Admin: ' );
define( 'ORDER_ASSIGN_SUCCESS', 'Order Has Been Assigned To: ' );
define( 'ORDER_ASSIGN_FAILED', 'Order Could Not Be Assigned: ' );
define( 'ORDER_TRACKINGCODE', 'Your Order Tracking Code Is: ' );
define( 'ORDER_TRACKINGCODE_WRONG', 'Your Order Tracking Code Is Incorrect!' );
define( 'ORDER_TRACKINGCODE_VERIFIED', 'Order Tracking Code Is Correct!' );
define( 'ORDER_NOTMOVED', 'We\'re Sorry But Your Order Has Not Been Moved Yet!' );
define( 'ORDER_PINCODE', 'Your Order PIN Code Is: ' );
define( 'ORDER_PINCODE_WRONG', 'The PIN You Entered Is Not Correct!' );
define( 'ORDER_PINCODE_VERIFIED', 'The PIN Provided by The Customer Is Correct.' );
define( 'ORDER_INTRANSIT', 'Order Is In-transit!' );
define( 'ORDER_COMPLETED', 'Order Has Been Completed!' );
define( 'ORDER_EMAIL_INVALID', 'Your Email Is Not Valid!' );
define( 'ORDER_MAILSMS_SENT', 'An Email/SMS Has Been Sent To You' );
define( 'ORDER_DOESNTEXIST_WRONGDETAILS', 'This Order Doesn\'t Exist or the Details Are Wrong!' );

// Rider Messages
define( 'RIDER_DOESNT_EXIST', 'This Rider Doesn\'t Seem To Exist!' );

// Add New User
define( 'NEWUSER_PHOTO_FILESIZEBYTE', 1000000 ); // 1,000,000 = 1MB
define( 'NEWUSER_PHOTO_FILESIZEMB', '1MB' );
define( 'NEWUSER_PHOTO_FILETOOLARGE', 'The Photo You Selected Is Too Large! '. NEWUSER_PHOTO_FILESIZEMB .' Max.' );
define( 'NEWUSER_PHOTO_INVALID', 'The Photo You Selected Is Invalid!' );
define( 'NEWUSER_PHOTO_EMPTY', 'You Cannot Upload an Empty File Please!' );
define( 'NEWUSER_ADD_SUCCESS', 'New User Added Successfully!' );
define( 'NEWUSER_ADD_FAILED', 'Sorry, Could Not Add New User!' );