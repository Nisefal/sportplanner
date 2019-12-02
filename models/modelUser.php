<?
include_once $_SERVER["DOCUMENT_ROOT"]."/models/Connection.php";

class modelUser extends Connection {
    function findUser($email) {
        $sql = "SELECT id FROM clients WHERE email='".$email."'";
        return $this->query($sql);
    }

    function validateUser($uid, $sid) {
        $sql = "SELECT id FROM clients WHERE sid = '".$sid."'";
        $result = $this->query($sql);

        if (md5($result->fetch_row()[0]) == $uid)
            return true;
        return false;
    }
}