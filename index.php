<?php
ob_start();
session_start();
require 'classes/db.php';

if (isset($_SESSION['print_receipt'])) {
	header("refresh:1; payments/print_receipt.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php require "includes/header.php"; ?>

<head>
	<style type="text/css">
		/* start of side bar*/
		body {
			overflow-x: hidden;
		}

		/* start of side bar*/

		#carouselExampleControls .row,
		#why-us-car .row {
			height: 600px;
			padding-top: 150px;
		}

		#carouselExampleControls .row {
			background-size: 100%;
		}

		#carouselExampleControls h1,
		#why-us-car h1 {
			font-weight: bold;
			font-size: 48px;
		}


		/* Mobile Phones and tablets */
		@media only screen and (min-width: 320px) and (max-width: 767px) {
			#carouselExampleControls .row {
				height: 500px;
				padding-top: 90px;
				background-size: 100% 500px;
			}

			#carouselExampleControls h1 {
				margin-left: 20px;
				font-size: 42px;
			}

		}

		.section-title {
			margin-bottom: 10px;
		}

		.col-sm-3,
		.col-sm-4 {
			margin-bottom: 20px;
		}

		/* header css */
		.header-section {
			min-height: 400px;
			color: #fff;
		}

		.header-text-div {
			background-color: orange;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.header-text-div h1 {
			margin-top: 100px;
		}

		.header-text-div h3 {
			margin-top: 50px;
		}

		.header-image-div {
			padding-right: 0px;
		}

		@media only screen and (max-width: 768px) {
			.header-image-div {
				margin-top: 20px;
				padding: 0px;
			}
		}

		@media only screen and (max-width: 768px) {
			.image-holder {
				margin-top: 20px;
				padding: 0px;
				text-align: center;
			}
		}

		.card {
			color: #000;
			height: 100%
		}

		@media only screen and (max-width: 768px) {
			.content-panel {
				margin-bottom: 20px;
				padding: 30px;
			}
		}

		.content-panel {
			padding: 10px;
			background-color: white;
			color: #000;

			min-height: 200px;
			height: 100%;

		}

		.content-panel:hover {
			box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.5);

		}

		.footer {
			background: #000;
			color: #fff;
		}

		.footer h1 {
			font-size: 20px;
			margin: 25px 0px;
		}

		.footer p {
			font-size: 15px;
		}

		.copyright {
			font-size: 20px;
			margin-bottom: -80px;
			padding-bottom: 20px;
		}

		.footer hr {
			margin-top: 10px;
			background-color: #ccc;
		}

		.footer .row .fa {
			padding-right: 20px;
			font-size: 15px;
		}

		/*for jquery*/
		.fadein {
			opacity: 0.2;
		}

		.slideinleft {
			margin-left: -300px;
			max-width: 100%;
		}

		.slideintop {
			margin-top: 200px;
			max-width: 100%;
		}

		.image-holder {
			border: 1px solid #edeeef;
			text-align: center;
			padding: 30px;
		}

		.featured-apartments img {
			height: 180px;
			width: 180px;
		}

		@media only screen and (max-width: 768px) {
			.featured-apartments img {
				height: 100%;
				width: 100%;
			}
		}

		#my-qr-reader {
			padding: 20px !important;
			border: 1.5px solid #b2b2b2 !important;
			border-radius: 8px;
		}

		#my-qr-reader img[alt="Info icon"] {
			display: none;
		}

		#my-qr-reader img[alt="Camera based scan"] {
			width: 100px !important;
			height: 100px !important;
		}

		#html5-qrcode-anchor-scan-type-change {
			text-decoration: none !important;
			color: #1d9bf0;
		}
	</style>
</head>

<body>
	<?php require "includes/deftopnav.php"; ?>
	<section class="header-section">
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="row"
						style="background-image: url('resources/images/sl2.png'); background-repeat: no-repeat;background-size:  100% 600px;">
						<div class="col-sm-6 offset-sm-1">
							<div style="background-color: blue;padding: 10px;">
								<h1>Student Management System.</h1>
							</div>
							<a class="btn"
								style="background: #ff5e14;padding: 10px;border-radius: none;width: 160px;color: #fff;font-weight: bold;margin-top: 15px; margin-left: 5px;" href="login.php">SIGN IN</a>

						</div>

					</div>

				</div>
				<div class="carousel-item">
					<div class="row"
						style="background-image: url('resources/images/sl3.jpg'); background-repeat: no-repeat;">
						<div class="col-sm-6 offset-sm-1">
							<div style="background-color: blue;padding: 10px;">
								<h1>Student Management System.</h1>
							</div>
							<a class="btn"
								style="background: #ff5e14;padding: 10px;border-radius: none;width: 160px;color: #fff;font-weight: bold;margin-top: 15px; margin-left: 5px;"  href="login.php">SIGN IN</a>

						</div>
					</div>
				</div>
				<div class="carousel-item">
					<div class="row"
						style="background-image: url('resources/images/sl1.jpg'); background-repeat: no-repeat;">
						<div class="col-sm-6 offset-sm-1">
							<div style="background-color: blue;padding: 10px;">
								<h1>Student Management System.</h1>
							</div>
							<a  href="login.php" class="btn"
								style="background: #ff5e14;padding: 10px;border-radius: none;width: 160px;color: #fff;font-weight: bold;margin-top: 15px; margin-left: 5px;">SIGN IN</a>


						</div>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</section>

	<?php require "includes/deffooter.php"; ?>

	<script src="https://unpkg.com/html5-qrcode"></script>
	<script type="text/javascript" src="resources/javascript/myjquery.js"></script>
	<script type="text/javascript">

		function onScanSuccess(decodeText, decodeResult) {
			//alert("You Qr is : " + decodeText, decodeResult);
			window.location.href = "view_rooms.php?apartment_id=" + decodeText, decodeResult;
		}
		function launchQR() {
			event.preventDefault();
			$("#qrModal").modal("show");

			let htmlscanner = new Html5QrcodeScanner(
				"my-qr-reader",
				{ fps: 10, qrbos: 250 }
			);

			$('#qrModal').on('hidden.bs.modal', function () {
				$('#html5-qrcode-button-camera-stop').click();
			});
			htmlscanner.render(onScanSuccess);
		}
	</script>
</body>