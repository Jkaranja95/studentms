<?php 
ob_start();
if (!isset($_SESSION['login_id'])) {
	header("Location: ../../login.php");
}
?>