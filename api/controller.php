<?php

include_once "./methods/postMethods.php";
include_once "./methods/getMethods.php";

if(!isset($_POST) && !isset($_GET))
	exit();

if (isset($_POST['method'])) {
    $function = htmlspecialchars($_POST["method"]);
    $function($_POST["data"]);
}

if (isset($_GET['method'])) {
    $function = htmlspecialchars($_POST["method"]);
    $function();	
}

?>