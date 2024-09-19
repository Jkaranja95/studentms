<?php
ob_start();
session_start();
require_once 'classes/db.php';
require_once 'classes/alert.php';
require_once 'classes/user.php';

if (isset($_SESSION['login_id']) && isset($_SESSION['login_type'])) {
	$login = $_SESSION['login_id'];
	$login_type = $_SESSION['login_type'];
	if ($login_type == "principal") {
		header("Location: accounts/principal/");
	} elseif ($login_type == "nurse") {
		header("Location: accounts/nurse/");
	} elseif ($login_type == "sports") {
		header("Location: accounts/sports/");
	}
}

if (isset($_POST["login"])) {
	//get the request parameters
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	$user = new User();

	$tof = $user->login($username, $password);

	if (!$tof) {
		$status = Alert::create('danger', 'Aunthentication Failed', 'Invalid email or password.');
	} else {
		
		$login = $_SESSION['login_id'];
		$login_type = $_SESSION['login_type'];
		
		if ($login_type == "PRINCIPAL") {
			echo $login_type;
			header("Location: accounts/principal/");
		} elseif ($login_type == "CLUB MASTER") {
			header("Location: accounts/club/");
		} elseif ($login_type == "DISCIPLINARY MASTER") {
			header("Location: accounts/disciplinary/");
		}elseif ($login_type == "SPORT MASTER") {
			header("Location: accounts/sports/");
		}elseif ($login_type == "NURSE") {
			header("Location: accounts/medical/");
		}elseif ($login_type == "FINANCE") {
			header("Location: accounts/finance/");
		}elseif ($login_type == "TEACHER") {
			header("Location: accounts/exam/");
		}

	}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require "includes/header.php"; ?>

<body>

	<div class="container form-container">
		<h3 style="color: #000;">Login</h3>
		<form class="form" method="post" role="form">
			<?php if (isset($status))
				echo $status; ?>
			<div class="form-group">
				<label for="username" class="control-label">Username</label>
				<input type="email" name="username" id="username" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="password" class="control-label">Password</label>
				<input type="password" name="password" id="password" class="form-control" required="true">
			</div>
			<button type="submit" name="login" id="login" class="btn btn-primary btn-block">Login</button>
			<br>
			<a href="#">Dont have an account? Contact Support</a>
		
		</form>
	</div>


</body>