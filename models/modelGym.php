<?
include_once $_SERVER["DOCUMENT_ROOT"]."/models/Connection.php";

class modelGym extends Connection {
    function findGym($tele) {
        $sql = "SELECT id FROM gyms WHERE uniqueIdentifier='".$tele."'";
        return $this->query($sql);
    }

    function findGymByEmail($email) {
        $sql = "SELECT id FROM gyms WHERE email='".$email."'";
        return $this->query($sql);
    }

    function validateGym($gid, $sid) {
        $sql = "SELECT id FROM gyms WHERE sid = '".$sid."'";
        $result = $this->query($sql);

        if (md5($result->fetch_row()[0]) == $gid)
            return true;
        return false;
    }
}