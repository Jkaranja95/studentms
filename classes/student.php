<?php
class Student
{

	public function admno_exists($admno)
	{
		try {

			$conn = Db::get()->conn;

			$sql = "SELECT * FROM `students` WHERE `admno` = :admno";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":admno", $admno);
			$pstmt->execute();

			return ($pstmt->rowCount() > 0);
		} catch (PDOException $ex) {
			return false;
		}
	}
}
?>