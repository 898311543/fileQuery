<?php
/**
* 
*/
class Verify extends DbConn
{	

	public function verifyUser($username,$password){
	 $return_data = array('username' => '', 'token'=>'','code'=>500);
		try{
		$db = new DbConn;
		$err = '';
		$return_data['code'] = 200;
		}catch (PDOException $e){
		$err = $e->getMessage();
		$return_data['code'] = 501;
		}
		$return_data['username'] = $username;
		$stmt = $db->conn->prepare("SELECT * FROM login WHERE username = :myusername");
		$stmt->bindParam(':myusername',$username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($this->verify_($password,$result['password'])){
			$return_data['token'] = $db->updateToken($username,$db);
		}
		return $return_data;

	}
	public function verify_($password,$current_password){
		if(md5($password) == $current_password){
			return true;
		}
		else{
			return false;
		}
	}
	}
	?>