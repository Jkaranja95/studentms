<?php 
class User{

	public function user_exists($username){
		try {
			$conn = Db::get()->conn;
			$sql = "SELECT * FROM `users` WHERE `username` = :username";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":username",$username);
			$pstmt->execute();

			return ($pstmt->rowCount() > 0);
		} catch(PDOException $ex){
			return false;
		}
	}
	public function get_by_id($user_id){
		$conn = Db::get()->conn;
		$sql = "SELECT * FROM `users` WHERE `id` = :user_id";
		$stmt = $conn->prepare($sql);
		$stmt->bindparam(":user_id",$user_id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	public function login($username,$pass){

		try{
			$conn = Db::get()->conn;

			$salt = "1L2A7B0CFD96A012";
			$pass = sha1($salt.$pass);
			$sql = "SELECT * FROM `users` WHERE `username` = :username AND `password` = :pass AND `status` = 1";
			$pstmt = $conn->prepare($sql);
			$pstmt->bindparam(":username", $username);
			$pstmt->bindparam(":pass", $pass);
			$pstmt->execute();
			if($pstmt->rowCount() === 1){
				$row = $pstmt->fetch(PDO::FETCH_OBJ);
				$_SESSION['login_id'] = $row->id;
				$_SESSION['login_email'] = $row->username;
				$_SESSION['login_type'] = $row->type;
				return true;
			}
			return false;

		} catch(PDOException $ex) {
			return false;
		}
	}
}
?>