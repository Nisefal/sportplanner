<?
include_once "models/Connection.php";

class modelLoginUser extends Connection {
	function loginUser($id, $sid){
		$sql = "UPDATE users SET sid = '".$sid."' WHERE id=".$id;
		return $this->query($sql);
	}
	
	function checkUser($email){
		$sql = "SELECT id FROM users WHERE email='".$email."'";
		return $this->query($sql);
	}

}