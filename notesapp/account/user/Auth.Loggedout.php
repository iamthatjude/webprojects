<?php

/**
 * Auth.Loggedout.php -- Logged Out Successfully
 */

ob_start();
$pageTitle = 'Logged Out'; // Page Title

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
			<div class="container-fluid h-100">
				<div class="row justify-content-center align-items-center height-self-center">
					<div class="col-md-5 col-sm-12 col-12 align-self-center">
						<div class="sign-user_card" id="auth">
							<div class="logo-detail">
								<div class="d-flex align-items-center"><img src="<?= ASSETS_URL; ?>assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo">
									<h4 class="logo-title ml-3"><?= $pageTitle; ?></h4>
								</div>
							</div>
							<h3 class="mb-2">All wrapped up for the day?</h3>
							<p class="cnf-mail m-auto mb-1">You have been logged out successfully.</p>
							<p class="cnf-mail m-auto pt-3">Should you need to log back in, click the button below.</p>
							<div class="d-inline-block w-100">
								<a href="<?= USER_LOGIN ?>" class="btn btn-primary mt-3">Return to Login</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!-- Auth Footer -->
    <?php include 'layout/Auth.footer.layout.php'; ?>
    <!--/ Auth Footer -->

</body>
</html>

<?php
ob_end_flush();
?>
