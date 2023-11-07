<?php 
/**
 * Auth.Register.php -- Create an account
 */

ob_start();
$pageTitle = 'Create an Account'; // Page Title

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

                        <!-- Regsiter Form -->
                        <div class="col-xl-8 col-lg-9" id="registerForm">
                            <!-- Social registration form-->
                            <div class="card my-5">
                                <div class="card-body p-5 text-center">
                                    <div class="h3 fw-light mb-3"><?= $pageTitle; ?></div>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body p-5" id="auth">
                                    <div class="text-center small text-muted mb-4">Enter your information below.</div>
                                    <!-- Login form-->
                                    <form v-on:submit.prevent>
                                        <!-- Form Row-->
                                        <div class="row gx-3">
                                            <div class="col-md-4">
                                                <!-- Form Group (username)-->
                                                <div class="mb-3">
                                                    <label class="text-gray-600 small">Username</label>
                                                    <input class="form-control form-control-solid" type="text" id="username" name="username" v-model="registerData.username" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- Form Group (email address)-->
                                                <div class="mb-3">
                                                    <label class="text-gray-600 small">Email address</label>
                                                    <input class="form-control form-control-solid" type="text" id="email" name="email" v-model="registerData.email" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Row-->
                                        <div class="row gx-3">
                                            <div class="col-md-6">
                                                <!-- Form Group (choose password)-->
                                                <div class="mb-3">
                                                    <label class="text-gray-600 small">Password</label>
                                                    <input class="form-control form-control-solid" type="password" id="password" name="password" v-model="registerData.password" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Form Group (confirm password)-->
                                                <div class="mb-3">
                                                    <label class="text-gray-600 small">Confirm Password</label>
                                                    <input class="form-control form-control-solid" type="password" id="confirm_password" name="confirm_password" v-model="registerData.confirm_password" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Group (form submission)-->
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" id="checkTerms" type="checkbox" value="" />
                                                <label class="form-check-label" for="checkTerms">
                                                    I accept the
                                                    <a href="#!">terms &amp; conditions</a>
                                                </label>
                                            </div>
                                            <button type="submit" id="btnRegister" class="btn btn-primary" @click="checkFields('register')">Create Account</button>
                                        </div>
                                    </form>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body px-5 py-4">
                                    <div class="small text-center">
                                        Have an account?
                                        <a href="<?= USER_LOGIN; ?>">Log in!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login Loader -->
                        <div class="col-lg-5" id="loginLoader" style="display:none!important;">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body text-center p-5">
                                    <div class="spinner-border mb-3" role="status"><span class="visually-hidden">Loading...</span></div>
                                    <p class="mb-0">Your registration was successful!</p>
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
            $('#username').focus();
        });
    </script>

</body>
</html>

<?php
ob_end_flush();
?>