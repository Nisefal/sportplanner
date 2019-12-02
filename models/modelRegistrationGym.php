<?
include_once "models/modelGym.php";

class modelRegistrationGym extends modelGym {
    function registerGym($email, $password, $name, $tele) {
        $sql = "INSERT INTO gyms SET email='".$email."', password='".$password."', name='".$name."', uniqueIdentifier='".$tele."', address='', description=''";
        return $this->query($sql);
    }
}
