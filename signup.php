<?php
ob_start();
session_start();
require_once 'classes/db.php';
require_once 'classes/alert.php';
require_once 'classes/user.php';

if (isset($_POST["register"])) {
	//get the request parameters
	$name = trim($_POST["name"]);
	$idno = trim($_POST["idno"]);
	$location = trim($_POST["location"]);
	$phone = trim($_POST["phone"]);
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);


	$conn = Db::get()->conn;
	$conn->beginTransaction();
	try {
		$user = new User();

		if ($user->user_exists($username)) {
			$status = Alert::create('danger', 'Save unsuccessful', 'Email Exists.');
		} else {
			//insert user
			$salt = "1L2A7B0CFD96A012";
			$pass = sha1($salt . $password);

			$sql = "INSERT INTO `users` (`type`,`username`,`password`) VALUES (:type,:username,:password)";

			$conn = Db::get()->conn;
			$stmt = $conn->prepare($sql);
			$type = "owner";
			$stmt->bindparam(":type", $type);
			$stmt->bindparam(":username", $username);
			$stmt->bindparam(":password", $pass);

			$stmt->execute();

			$user_id = $conn->lastInsertId();


			$sql = "INSERT INTO `owners` (`user_id`,`name`,`idno`,`phoneno`,`location`) VALUES (:user_id,:name,:idno,:phoneno,:location)";

			$conn = Db::get()->conn;
			$stmt = $conn->prepare($sql);
			$stmt->bindparam(":user_id", $user_id);
			$stmt->bindparam(":location", $location);
			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":idno", $idno);
			$stmt->bindparam(":phoneno", $phone);

			$stmt->execute();

			$id = $conn->lastInsertId();

			if ($id) {
				$status = Alert::create('success', 'Registration successful', 'Account created. Login to proceed');
				header("refresh:1;login.php");
			} else {
				$status = Alert::create('danger', 'Registration unsuccessful', 'Error Occured.');
			}
			$conn->commit();
		}
	} catch (PDOException $e) {
		$conn->rollBack();
		echo $e->getMessage();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require "includes/header.php"; ?>

<body>

	<div class="container form-container">
		<h3 style="color: #000;">Owner/Landlord Registration</h3>
		<form class="form" method="post" role="form" id="add-form">
			<?php if (isset($status))
				echo $status; ?>
			<div class="form-group">
				<label for="name" class="control-label">Name</label>
				<input type="text" name="name" id="name" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="idno" class="control-label">National ID</label>
				<input type="number" name="idno" id="idno" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="phone" class="control-label">Phone</label>
				<input type="text" name="phone" id="phone" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="location" class="control-label">Residence</label>
				<input type="text" name="location" id="location" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="username" class="control-label">Email</label>
				<input type="email" name="username" id="username" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="password" class="control-label">Password</label>
				<input type="password" name="password" id="password" class="form-control" required="true">
			</div>
			<button type="submit" name="register" id="register" class="btn btn-primary btn-block">Register</button>
			<br>
			<div style="text-align:center;">
				<a href="login.php">Have an Account? Click to login</a>
			</div>
		</form>
	</div>

	<script>
		document.getElementById("add-form").addEventListener("submit", function (event) {
			var name =
				document.getElementById("name").value;
			var phone =
				document.getElementById("phone").value;
			var password =
				document.getElementById("password").value;
			var username =
				document.getElementById("username").value;

			var regName = /\d+$/g;

			var regAge = /^(1[89]|[2-9]\d)$/gm;

			var regPhone = /^\d{10}$/;

			var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g; //Javascript reGex for Email Validation.



			if (name == "" || regName.test(name)) {
				window.alert("Please enter your name properly.");
				event.preventDefault();
				return;
			}

			if (!regPhone.test(phone)) {
				window.alert("Please enter a valid phone number.");
				event.preventDefault();
				return;
			}
			if (!regEmail.test(username)) {
				window.alert("Please enter a valid email.");
				event.preventDefault();
				return;
			}

			if (password.length < 6) {
				window.alert("Please enter a longer password. Atleast 6 characters");
				event.preventDefault();
				return;
			}


		});
	</script>

</body>