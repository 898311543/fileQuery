<?php
/**
* 
*/
class AddUser extends DbConn
{

	public function createUser($username,$email,$phoneNum,$password)
	{
		$return_data = array('username' => '', 'token'=>'','code'=>500);
		$current_time = time();
		$conf = new Globalconf;
		$db = new DbConn;
		if ($this->existance($username,$db)) {
			$return_data['code'] = 201;
			$return_data['username'] = $username;
		}else{
		try {
			$tbl_members = "login";
			$stmt = $db->conn->prepare("INSERT INTO ".$tbl_members." (id,username,password,ip_addr,phone,email,token,last_login_time) VALUES (NULL,:username,:password,:ip_addr,:phone,:email,NULL,:current_time)");
			$stmt->bindParam(':username',$username);
			$stmt->bindParam(':password',md5($password));
			$stmt->bindParam(':ip_addr',$conf->ip_address);
			$stmt->bindParam(':phone',$phoneNum);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':current_time',$current_time);
			$stmt->execute();
			$return_data['code'] = 200;
			$return_data['username'] = $username;
			$return_data['token'] = $db->updateToken($username,$db);
		} catch (Exception $e) {
			$return_data['code'] = 501;
		}
	}
		return $return_data;

	}
	public function existance($username,$db){
		$stmt = $db->conn->prepare("SELECT * FROM login WHERE username = :username");
		$stmt->bindParam(":username",$username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return true;
		}
		else{
			return false;
		}
	}
}