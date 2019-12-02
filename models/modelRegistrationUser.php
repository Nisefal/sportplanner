<?
include_once "models/modelUser.php";

class modelRegistrationUser extends modelUser {
    function registerUser($email, $password, $date, $name) {
		$sql = "INSERT INTO clients SET email='".$email."', password='".$password."', name='".$name."', birth_date='".$date."', login='user'";
		return $this->query($sql);
	}
}