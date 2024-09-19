<?php
//object oriented
class Db{
  private static $instance = null;

  private  $host = "localhost";
  private   $db_name = "studentms";
  private  $username = "root";
  private  $password = "";
  public  $conn;

  public function __construct(){
    $this->conn = null;
    try{
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $exception) {
     // echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }

  public static function get(){
    if(!isset(self::$instance)){
      self::$instance = new Db();
    }
    return self::$instance;
  }

  public function get_by_id($table,$id){
    $sql = "SELECT * FROM $table WHERE `id` = :id";
    $stmt = Db::get()->conn->prepare($sql);
    $stmt->bindparam(":id",$id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  public function get_by($table,$column,$value){
    $sql = "SELECT * FROM $table WHERE $column = :value";
    $stmt = Db::get()->conn->prepare($sql);
    $stmt->bindparam(":value",$value);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function generate_unique($table,$column){
    try{
      $pdo = $this->conn;
      $tof = false;
      $id = null;
      while ($tof == false) {
        $id = sha1(uniqid(rand()));

        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = :id";
        $pstmt = $pdo->prepare($sql);
        $pstmt->bindparam(":id",$id);
        $pstmt->execute();
        if($pstmt->rowCount() == 0){
          $tof = true;
        }
      }
      return $id;
    } catch(PDOException $ex){
      //echo $ex->getMessage();
    }
  }
  public function get_last_id($table){
    $sql = "SELECT * FROM `".$table."` ORDER BY `id` LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ)->id;
  }
  public function sanitize($value) {
    return htmlspecialchars(strip_tags($value));
  }
  public function random_number($length)
  {
    return join('', array_map(function($value) { return $value == 1 ? mt_rand(1, 9) : mt_rand(0, 9); }, range(1, $length)));
  }
}
?>
