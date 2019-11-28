<?

include 'cabFunc.php';

if (count($_COOKIE) > 1)
{
    if(!$_COOKIE['uid'] || !$_COOKIE['sid'] || $_COOKIE['uid']=="" || $_COOKIE['sid']=="")
        header('Location: logout.php');

    $connect = sqlConnection();

    if (!$connect) {
        header('Location: ./error.php');
    }

    $sql = "SELECT orgName,id FROM users WHERE uid='".$_COOKIE['uid']."' AND sid='".$_COOKIE['sid']."'";

    $result = $connect->query($sql);


    $userdata = $result->fetch_row();
    if(!$userdata) {
        header("Location: logout.php"); exit();
    }

    $id = $userdata[1];

    $sql = "SELECT sensor_info.id,name FROM (sensor_info INNER JOIN Access ON sensor_info.id=Access.senid) WHERE uid=".$id;

    $result = $connect->query(utf8_encode($sql));

    $sensors = array();

    while($row = $result->fetch_row()){
        $sensors[] = $row;
    }

    mysqli_close($connect);
} else {
    header('Location: logout.php');
}
?>

<!doctype html>
<html class="gr__c_advin_in_ua"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" src="js/cabinet.js"></script>

    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/style-menubar.css">
    <link rel="stylesheet" type="text/css" href="styles/style-cabinet.css">
    <link rel="stylesheet" type="text/css" href="styles/style-mobile.css">
    <link rel="stylesheet" type="text/css" href="styles/style-modal.css">
    <link rel="icon" type="image/ico" href="img/favicon.ico">
</head>
<body data-gr-c-s-loaded="true">
<div id="menu-bar" class="mbar">
    <div class="logo-container">
        <img class="logo" src="img/logo_site_0-300x71.png" alt="">
    </div>
    <div id="time" class="divp right"><label id="curr_time"></label></div>
    <div id="name-label" class="divp">
        <div class="divp">
            <h3><?php
            echo $userdata[0];
            ?></h3>
        </div>
        <div class="divp">
            <select value="1">
                <?php printOptions(); ?>
            </select>
        </div>
    </div>
    <div class="drop-menu">
        <input type="checkbox" id="check-menu">
        <label for="check-menu"></label>
        <div class="burger-line first"></div>
        <div class="burger-line second"></div>
        <div class="burger-line third"></div>
        <div class="burger-line fourth"></div>
        <nav class="main-menu" onclick="removeDropMenu();"><?php printMenu($sensors); ?></nav>
    </div>
    <div class="tools">
        <div id="timeS" class="divp right"><label id="curr_timeS"></label></div>
        <div id="message" class="divp right">
            <a href=""><img src="img/message.png" class="img"></a>
        </div>
        <div id="logout" class="divp right">
            <a href="logout.php"><img src="img/exit_button.png" class="img"></a>
        </div>
    </div>
</div>
<div id="flag" style="visibility: hidden; height: 0px; ">1</div>
<main>
    <div id="devices" class="divp">
	<a href=""><button class="navbutton button-1 device-button">Звіти та статистика</button></a>
	<a href="./analitics.php"><button class="navbutton button-1 device-button">Аналітика</button></a>
	<a href=""><button class="navbutton button-1 device-button">Активність мерчендайзерів</button></a>
	<a href=""><button class="navbutton button-1 device-button">Товари для поповнення</button></a>
	<a href=""><button class="navbutton button-2 device-button">Налаштування тригерів</button></a>
	<a href=""><button class="navbutton button-2 device-button">Зміна вартості</button></a>
    </div>
    <div class="wrapper">
	<img src="img/store.jpg" style="width: 600px">
    </div>
</main>
</body></html> 