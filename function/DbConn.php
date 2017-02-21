<?php
class DbConn{
	public $conn;
	public function __construct(){
		require 'dbconf.php';
		$this->hostname  = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->db_name = $db_name;
	try{
		$this->conn = new PDO('mysql:host='.$hostname.';dbname='.$db_name.';charset=utf8',$username,$password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(Exception $e){
	die('Database connection error');
}
}
	public function updateToken($username,$database){
		$stmt = $database->conn->prepare("SELECT * FROM login WHERE username = :username");
		$stmt->bindParam(':username',$username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result['token']){
			return $result['token'];
		}else{
			$token = md5($username.time());
			try{
			$stmt = $database->conn->prepare("UPDATE `login` SET `token` = :token WHERE username = :username");
			$stmt->bindParam(":token",$token);
			$stmt->bindParam(":username",$username);
			$stmt->execute();
			return $token;
}
		catch(Exception $e){
			return false;
			;
		}

		}
}
}
?>
