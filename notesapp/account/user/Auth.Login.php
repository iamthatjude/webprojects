<?php

/**
 * Auth.Login.php -- Log In
 */

ob_start();
$pageTitle = 'Login'; // Page Title

session_start();
date_default_timezone_set('Africa/Lagos');

// CSRF Protection
include '../../system/functions.sys.php'; // Functions
//$token = md5(uniqid(rand(), TRUE) . time());
$token = md5( uniqid(rand(), TRUE) . time() ) . randomCodeGenerator('', 100);
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

include '../../system/config.sys.php'; // Configurations
include '../../system/constants.sys.php'; // Defined Constants

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['uid'])) { // currently logged in | uid: User ID
    header('Location: ' . USER_HOME);
}

?>

<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $pageTitle . ' ' . $pageSeparator . ' ' . SITE_NAME; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= ASSETS_URL; ?>assets/images/favicon.ico" />
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/css/backend-plugin.min.css?v=1.0.0">
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="<?= ASSETS_URL; ?>assets/vendor/@icon/dripicons/dripicons.css">

    <!-- Extra CSS -->
    <style>
        /* with background */
        /*
        .input-container {
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }
        .icon {
            padding: 13px;
            background: #f3f6fd;
            color: #768492;
            min-width: 50px;
            text-align: center;
            border-top: 1px solid #DCDDDF;
            border-bottom: 1px solid #DCDDDF;
            border-right: 1px solid #DCDDDF;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
            border-right: 0!important;
            border-top-right-radius: 0!important;
            border-bottom-right-radius: 0!important;
        }
        */
        /* without background */
        .input-container {
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }
        .input-container i {
            position: relative;
        }
        .icon {
            padding: 15px;
            color: rgb(49, 0, 128);
            min-width: 50px;
            text-align: center;
        }
        .input-field {
            width: 100%;
            padding: 10px;
        }
        #showpass:hover {
            cursor: pointer;
            background-color: #f3f6fd;
            border-radius: 100%;
        }
    </style>

</head>
<body class=" ">

    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center height-self-center">
                    <div class="col-md-5 col-sm-12 col-12 align-self-center">
                        <div class="sign-user_card" id="auth">
                            <div class="logo-detail">
                                <div class="d-flex align-items-center"><img src="<?= ASSETS_URL; ?>assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo">
                                    <h4 class="logo-title ml-3"><?= $pageTitle; ?></h4>
                                </div>
                            </div>
							<?php
							// redirect to a page
							if ( isset($_GET['redirect_to']) AND !empty($_GET['redirect_to']) ){
								$redirect_to_page = $_GET['redirect_to'];
								echo "<input type='hidden' id='redirect_to' value='{$redirect_to_page}'>";
							} else {
								echo "<input type='hidden' id='redirect_to' value='".USER_HOME."'>";
							}
							?>
                            <h3 class="mb-2">Sign In</h3>
                            <p>Login to stay connected.</p>

                            <form v-on:submit.prevent>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="text" id="username" name="username" v-model="loginData.username" placeholder="">
                                            <label for="username">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group input-container">
                                            <input class="floating-input form-control input-field" type="password" id="password" name="password" v-model="loginData.password" placeholder="">
                                            <label for="password">Password</label>
                                            <i class="fa fa-eye icon" id="showpass" onclick="showPass()"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox mb-3 text-left">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="<?= USER_RE_PASSWORD; ?>" class="text-primary float-right">Forgot Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnLogin" @click="checkFields('login', 'user')">Sign In</button>
                                <p class="mt-3 mb-0">
                                    Create an Account <a href="<?= USER_REGISTER; ?>" class="text-primary"><b>Sign Up</b></a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Auth Footer -->
    <?php include 'layout/Auth.footer.layout.php'; ?>
    <!--/ Auth Footer -->

	<script>
        $(document).ready(function(){
            $('#username').focus();
        });
    </script>

</body>
</html>

<?php
ob_end_flush();
?>
