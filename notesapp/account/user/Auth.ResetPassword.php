<?php 
/**
 * Auth.ResetPassword.php -- Password Recovery
 */

ob_start();
$pageTitle = 'Password Recovery'; // Page Title

session_start();
date_default_timezone_set('Africa/Lagos'); 

// CSRF Protection
$token = md5( uniqid(rand(), TRUE) . time() );
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

include '../../system/config.sys.php'; // Configurations
include '../../system/constants.sys.php'; // Defined Constants

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ( isset($_SESSION['uid']) ){ // currently logged in | uid: User ID
	header( 'Location: '. USER_HOME );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title><?= $pageTitle . ' ' . $pageSeparator . ' ' . SITE_NAME; ?></title>

    <link href="<?= ASSETS_URL; ?>css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= ASSETS_URL; ?>assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

</head>
<body class="bg-primary">

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">

                        <!-- Reset Form -->
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11" id="resetForm">
                            <!-- Social forgot password form-->
                            <div class="card my-5">
                                <div class="card-body p-5 text-center"><div class="h3 fw-light mb-0"><?= $pageTitle; ?></div></div>
                                <hr class="my-0" />
                                <div class="card-body p-5" id="auth">
                                    <div class="text-center small text-muted mb-4">Enter your email address below and we will send you a link to reset your password.</div>
                                    <!-- Forgot password form-->
                                    <form>
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="text-gray-600 small">Email address</label>
                                            <input class="form-control form-control-solid" type="text" id="email" name="email" v-model="resetData.email" placeholder="" />
                                        </div>
                                        <!-- Form Group (reset password button)    -->
                                        <button type="submit" id="btnReset" class="btn btn-primary" @click="checkFields('resetpassword', 'send_mail')">Reset Password</a>
                                    </form>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body px-5 py-4">
                                    <div class="small text-center">
                                        New user?
                                        <a href="<?= USER_REGISTER; ?>">Create an account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login Loader -->
                        <div class="col-lg-5" id="loginLoader" style="display:none!important;">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body text-center p-5">
                                    <div class="spinner-border mb-3" role="status"><span class="visually-hidden">Loading...</span></div>
                                    <p class="mb-0">Kindly check your email!</p>
                                    <p class="mb-0">Redirecting you to the Login page...</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>

    <!-- Auth Footer -->
    <?php include 'layout/Auth.footer.layout.php'; ?>
    <!--/ Auth Footer -->

    <script>
        $(document).ready(function(){
            $('#email').focus();
        });
    </script>

</body>
</html>

<?php
ob_end_flush();
?>