<?
include_once "/models/modelGym.php";

class modelLoginGym extends modelGym {
    function loginGym($id, $sid){
        $sql = "UPDATE gyms SET sid = '".$sid."' WHERE id=".$id;
        return $this->query($sql);
    }

    function checkGym($email, $password){
        $sql = "SELECT id FROM gyms WHERE email ='".$email."' AND password = '".$password."'";
        return $this->query($sql);
    }
}