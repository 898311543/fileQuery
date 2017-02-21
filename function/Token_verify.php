<?php
	class Token_verify extends DbConn{
		public function verify_token($token){
			try{
				$db = new DbConn;
			}catch(Exception $e){
				$err = $e->getMessage();
			}
		$stmt = $db->conn->prepare("SELECT * FROM login WHERE token = :token");
		$stmt->bindParam(':token',$token);
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