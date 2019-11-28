<?
include_once "models/Connection.php";

class modelRegistrationUser extends Connection {
    function registerUser($email, $password, $date, $name) {
		$sql = "INSERT INTO clients SET email='".$email."', password='".$password."', name='".$name."', date='".$date."'";
		return $this->query($sql);
	}

	function checkUser($email){
		$sql = "SELECT id FROM users WHERE email='".$email."'";
		return $this->query($sql);
	}
}

class modelRegistrationGym extends Connection {

}