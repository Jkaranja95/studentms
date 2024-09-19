<?php 
class Club{

	public function exists($admno,$club){
		try {

			$conn = Db::get()->conn;

			$sql = "SELECT * FROM `clubs` WHERE `admno` = :admno AND `club` = :club";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":admno", $admno);
			$pstmt->bindparam(":club", $club);
			$pstmt->execute();

			return ($pstmt->rowCount() > 0);
		} catch(PDOException $ex){
			return false;
		}
	}
}
?>