<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/style-log.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<?php

include "config.php";
include "models/modelLogin.php";

// редирект, если уже авторизирован
if ($_COOKIE['sid'] and  $_COOKIE["sid"] !== "")
{
    setcookie("sid", "", time() + $exp_time, "/", $baseUrl);
}
if ($_COOKIE['uid']  and $_COOKIE["uid"] !== "")
{
    setcookie("uid", "", time() + $exp_time, "/", $baseUrl);
}

$connect

if(isset($_POST['submit']))
{
    if($_POST['email']==='')
	$err[] = 'Вкажіть вашу електронну скриньку!';
    if($_POST['orgName']==='')
    $err[] = 'Вкажіть назву вашої організації!';
    if($_POST['password']==='')
   	$err[] = 'Вкажіть пароль!';

    $err = array();
    $email = $_POST['email'];
    $orgName = $_POST['orgName'];
    $pass = $_POST['password'];

    # чистим и проверям email
    $valid_email = $connect->real_escape_string($email);
    if(!filter_var($valid_email, FILTER_VALIDATE_EMAIL))
    {
        $err[] = "Неправильний формат електронної скриньки.";
    }

    if(strlen($valid_email) < 3 or strlen($valid_email) > 30)
    {
        $err[] = "Довжина назви електронної скриньки має бути від 3 до 32 символів.";
    }

    # чистим и проверяем логин
    $valid_orgName = $connect->real_escape_string($orgName);
    if(strlen($valid_orgName) < 3 or strlen($valid_orgName) > 30)
    {
        $err[] = "Довжина назви організації має бути від 3 до 32 символів.";
    }

    $sql = "SELECT * FROM users WHERE email='".$valid_email."'";
    $query = $connect->query(utf8_encode($sql));

    try{
        $row = $query->fetch_row();
        # пользователь существует
        if($row)
        {
            $err[] = "Користувач з такою електронною скринькою вже існує. Використайте іншу або зверніться за відновленням за адресою roman@riara.ua.";
        }
    } catch(Exception $exc) {

    }
    

    # Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $password = md5(md5($_POST['password']));

        $sql = "INSERT INTO users SET email='".$valid_email."', password='".$password."', orgName='".$valid_orgName."'";

        $connect->query(utf8_encode($sql));

        $sql = "SELECT id FROM users WHERE email = '".$valid_email."';";

        $result = $connect->query($sql);

        $row = $result->fetch_row();

        $id = $row[0];

        $uid = md5($id);

        $sid = md5(rand(-100,100));

        $sql = "UPDATE users SET uid='".$uid."', sid = '".$sid."' WHERE id=".$id;

        $connect->query(utf8_encode($sql));
        
        mysqli_close($connect);


        # Выдать sid, uid
        setcookie("sid", $sid, time() + $exp_time, "/", $baseUrl);
        setcookie("uid", $uid, time() + $exp_time, "/", $baseUrl);
       
        header("Location: login.php"); exit();
    }

    if (count($err)> 0) {
        $str = "<b>Помилки:</b><br>";
        foreach ($err AS $error) {
            $str .= $error . "<br>";
        }
	echo $str;
    }
}
if(isset($_POST['redirect'])) {
    header("Location: login.php");exit();
}

?>
<!-- Thanks for styles to https://codepen.io/colorlib/pen/rxddKy -->

<div class="login-page">
    <div class="form">
	<div>
		<img width='250' src='/img/Logo_A.jpg'></img>
		<br>
		<br>
	</div>
        <form class="login-form" method="post">
            <input name="email" type="text" placeholder="Електронна пошта">
            <input name="orgName" type="text" placeholder="Назва організації">
            <input name="password" type="password" placeholder="Пароль">
            <p>
            <input name="submit" type="submit" value="Зареєструватись">
            <p class="message">Для входу -><a href="./login.php">Вхід</a></p>
        </form>
    </div>
</div>
</body>
</html>