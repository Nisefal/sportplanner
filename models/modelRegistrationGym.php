<?
include_once "models/modelGym.php";

class modelRegistrationGym extends modelUser {
    function registerGym($email, $password, $date, $name) {
		//$sql = "INSERT INTO clients SET email='".$email."', password='".$password."', name='".$name."', birth_date='".$date."', login='user'";
		return $this->query($sql);
	}
}
