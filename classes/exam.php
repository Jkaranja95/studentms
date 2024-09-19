<?php 
class Exam{

	public function exists($type,$admno,$form,$term,$subject){
		try {

			$conn = Db::get()->conn;

			$sql = "SELECT * FROM `exams` WHERE `type` = :type AND `admno` = :admno AND `form` = :form AND `term` = :term AND `subject` = :subject";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":type", $type);
			$pstmt->bindparam(":admno", $admno);
			$pstmt->bindparam(":form", $form);
			$pstmt->bindparam(":term", $term);
			$pstmt->bindparam( ":subject", $subject);
			$pstmt->execute();

			return ($pstmt->rowCount() > 0);
		} catch(PDOException $ex){
			return false;
		}
	}
	public function get_score($type,$admno,$form,$term,$subject){
		try {

			$conn = Db::get()->conn;

			$sql = "SELECT * FROM `exams` WHERE `type` = :type AND `admno` = :admno AND `form` = :form AND `term` = :term AND `subject` = :subject";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":type", $type);
			$pstmt->bindparam(":admno", $admno);
			$pstmt->bindparam(":form", $form);
			$pstmt->bindparam(":term", $term);
			$pstmt->bindparam( ":subject", $subject);
			$pstmt->execute();

			return ($pstmt->fetch(PDO::FETCH_OBJ)->score);
		} catch(PDOException $ex){
			return false;
		}
	}
	public function grade($score){
		$grade = "A";
		if($score > 87){
			$grade = "A";
		}else if($score > 82){
			$grade = "A-";
		}else if($score > 78){
			$grade = "B+";
		}else if($score > 71){
			$grade = "B";
		}else if($score > 62){
			$grade = "B-";
		}else if($score > 57){
			$grade = "C+";
		}else if($score > 52){
			$grade = "C";
		}else if($score > 47){
			$grade = "C-";
		}else if($score > 42){
			$grade = "D";
		}else if($score > 37){
			$grade = "D-";
		}else {
			$grade = "E";
		}
		return $grade;
	}
}
?>