<?php
/**
* 
*/
class PhoneVerify extends DbConn
{
	
	function get($phone)
	{
		var $return_data;
		var $token;
		try{
			$db = new DbConn;
		}catch (PDOException $e){
		$err = $e->getMessage();
		}
		$stmt = $db->conn->prepare("SELECT * FROM login phone=:phone");
		$stmt->bindParam(":phone",$phone);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$return_data['token'] = $result['token'];
			$return_data['username']=$result['username'];
			return $return_data;
		}else{
			return NULL;
		}
	}
}