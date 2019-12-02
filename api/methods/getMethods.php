<?php
include $_SERVER["DOCUMENT_ROOT"]."/models/modelAPI.php";

function getGym($parameters) {
    $model = new modelAPI();
    $id = $parameters['gym_id'];
    $tmp = $model->getGymById($id);
    $gym = $tmp->fetch_row();
    if($gym == false || $gym == null) {
        echo "{}";
        exit();
    }
    $data = array(
        "id" => $gym[0],
        "name" => $gym[1],
        "email" => $gym[5],
        "description" => $gym[6],
        "address" => $gym[7],
    );
    $model->destroy();
    echo json_encode($data);
}

function getCoaches($parameters) {
    $model = new modelAPI();
    $id = $parameters['gym_id'];
    $coaches = $model->getCoachesByGymId($id);
    $data = array();
    if($coaches == false || $coaches == null) {
        echo "{}";
        exit();
    }
    while ($coach = $coaches->fetch_row()) {
        $data[] = array(
            "id" => $coach[0],
            "name" => $coach[1],
            "description" => $coach[3],
        );
    }
    $model->destroy();
    echo json_encode($data);
}

function getEquipment($parameters) {
    $model = new modelAPI();
    $id = $parameters['gym_id'];
    $equipment = $model->getEquipmentByGymId($id);
    $data = array();
    if($equipment == false || $equipment == null) {
        echo "{}";
        exit();
    }
    while ($equip = $equipment->fetch_row()) {
        $data[] = array(
            "id" => $equip[0],
            "name" => $equip[2],
            "occupation" => $equip[3],
            "description" => $equip[4],
        );
    }
    $model->destroy();
    echo json_encode($data);
}

function getRequests($parameters) {
    $model = new modelAPI();
    $id = $parameters['gym_id'];
    $requests = $model->getRequestsByGymId($id);
    $data = array();
    if($requests == false || $requests == null) {
        echo "{}";
        exit();
    }
    while ($equip = $requests->fetch_row()) {
        $data[] = array(
            "id" => $equip[0],
            "client_id" => $equip[1],
            "type" => $equip[3]
        );
    }
    $model->destroy();
    echo json_encode($data);
}

function getExcercises($parameters) {
    exit();
    $model = new modelAPI();
    $id = $parameters['client_id'];
    //$excercises = $model->getEquipmentByGymId($id);
    $data = array();
    if($excercises == false || $excercises == null) {
        echo "{}";
        exit();
    }
    while ($excercise = $excercises->fetch_row()) {
        $data[] = array(
            "id" => $excercise[0],
            "name" => $excercise[2],
            "description" => $excercise[3],
        );
    }
    $model->destroy();
    echo json_encode($data);
}

function getGroupExcercises($parameters) {
    exit();
    $model = new modelAPI();
    $id = $parameters['client_id'];
    $gym = $model->getEquipmentByGymId($id);
    $model->destroy();
}


?>