<?
include $_SERVER["DOCUMENT_ROOT"]."/models/Connection.php";

class modelAPI extends Connection {
    function getGymById($id) {
        $sql = "SELECT * FROM gyms WHERE id=".$id.";";
        return $this->query($sql);
    }

    function getClientById($id) {
        $sql = "SELECT * FROM clients WHERE id=".$id.";";
        return $this->query($sql);
    }

    function getCoachesByGymId($id) {
        $sql = "SELECT * FROM coaches WHERE gym_id=".$id.";";
        return $this->query($sql);
    }

    function getEquipmentByGymId($id) {
        $sql = "SELECT * FROM equipment WHERE gym_id=".$id.";";
        return $this->query($sql);
    }

    function getRequestsByGymId($id) {
        $sql = "SELECT * FROM requests WHERE gym_id=".$id.";";
        return $this->query($sql);
    }
}