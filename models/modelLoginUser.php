<?
include_once "\models\modelUser.php";

class modelLoginUser extends modelUser {
	function loginUser($id, $sid){
		$sql = "UPDATE clients SET sid = '".$sid."' WHERE id=".$id;
		return $this->query($sql);
	}

    function checkUser($email, $password){
        $sql = "SELECT id FROM clients WHERE email ='".$email."' AND password = '".$password."'";
        return $this->query($sql);
    }
}