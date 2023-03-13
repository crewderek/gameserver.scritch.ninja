<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="img/favicon.png" type="image/png">
	<title>Login | Gamer Servers - Scritch Ninja</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="vendors/linericon/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
	<link rel="stylesheet" href="vendors/animate-css/animate.css">
	<link rel="stylesheet" href="vendors/flaticon/flaticon.css">
	<!-- main css -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<!--================Header Menu Area =================-->
<?
require_once ("../header.html");
?>
<!--================Header Menu Area =================-->


<section class="home_banner_area">
	<div class="banner_inner">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="home_left_img">
						<img class="img-fluid" src="img/banner/home-left.png" alt="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="banner_content">
						<h2>
							Verify Your Email
						</h2>
						<section class="form-wrap">
							<form id="verificationForm">
								<input type="email" id="verificationEmail" class="verification-text-field" placeholder="Email" required>
								<input type="text" id="verificationCode" class="verification-text-field" placeholder="One Time Verification Code" required>
								<input type="submit" class="primary_btn" value="Verify">

								<div id="form-error-viewer">
								</div>
								<div class="verificationForm-link">
									<a href="#">Didn't get the code? Click here to send another.</a>
								</div>
							</form>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/aws/aws-cognito-sdk.min.js"></script>
<script src="js/aws/amazon-cognito-identity.min.js"></script>
<script src="js/aws/config.js"></script>
<script src="js/aws/cognito-auth.js"></script>
<script>
    $(function(){
        $("#includedHeaderContent").load("html/header.html");
    });
</script>
</body>
</html>
