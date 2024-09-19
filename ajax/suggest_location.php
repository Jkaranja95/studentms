<?php
ob_start();
session_start();
require_once '../classes/db.php';

$sql = "SELECT DISTINCT `location` FROM `apartments` WHERE  `location` LIKE :location LIMIT 0,5";
$stmt = Db::get()->conn->prepare($sql);

$location = "%".$_POST['textinput']."%";

$stmt->bindparam(":location",$location);

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_OBJ);
$toencode = array();
foreach ($row as $value) {
	$toencode[count($toencode)] = $value->location;
}
echo json_encode($toencode);

?>