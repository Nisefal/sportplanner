<?php

include "config.php";
include "\models\modelRegistrationUser.php";
include "\models\modelLoginUser.php";

// Страница регситрации нового пользователя

// редирект, если уже авторизирован
if ($_COOKIE['sid'] and  $_COOKIE["sid"] !== "" )
    setcookie("sid", "", time() + $exp_time, "/", $baseUrl);

if ($_COOKIE['uid'] and $_COOKIE["uid"] !== "")
    setcookie("uid", "", time() + $exp_time, "/", $baseUrl);

if(isset($_POST['submit']))
{
    if($_POST['email']==='')
	   $err[] = 'Вкажіть вашу електронну скриньку!';
    if($_POST['name']==='')
        $err[] = 'Вкажіть ваше ім\'я!';
    if($_POST['password']==='')
   	    $err[] = 'Вкажіть пароль!';

    $err = array();
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $date = $_POST['birthday'];

    $model = new modelRegistrationUser();

    # чистим и проверям email

    $valid_email = $model->removeChars($email);
    if(!filter_var($valid_email, FILTER_VALIDATE_EMAIL))
    {
        $err[] = "Неправильний формат електронної скриньки.";
    }

    if(strlen($valid_email) < 3 or strlen($valid_email) > 30)
    {
        $err[] = "Довжина назви електронної скриньки має бути від 3 до 32 символів.";
    }

    # чистим и проверяем имя
    $valid_name = $model->removeChars($name);
    if(strlen($valid_name) < 3)
    {
        $err[] = "Довжина ФІО має бути не менше 3 символів.";
    }

    $query = $model->findUser($valid_email);

    try{
        if($query)
            $row = $query->fetch_row();
        else new Exception();
        # пользователь существует
        if($row)
        {
            $err[] = "Користувач з такою електронною скринькою вже існує. Використайте іншу або зверніться за відновленням за адресою ".$adminmail;
        }
    } catch(Exception $exc) {

    }
    

    # Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $password = $_POST['password'];

        $result = $model->registerUser($valid_email, $password, $date, $valid_name);

        $result = $model->findUser($valid_email);

        if($result) {
            $row = $result->fetch_row();
        }
        else $err[] = "Проблема добавления юзера";

        $id = $row[0];

        $uid = md5($id);
        $sid = md5(rand(-100,100));
        $model->destroy();
        $model = new modelLoginUser();
        $model->loginUser($id,$sid);

        $model->destroy();


        # Выдать sid, uid
        setcookie("sid", $sid, time() + $exp_time, "/", $baseUrl);
        setcookie("uid", $uid, time() + $exp_time, "/", $baseUrl);

        if(count($err) == 0) {
            header("Location: loginUser.php"); exit();
        }
        else {
            $str = "<b>Помилки:</b><br>";
            foreach ($err AS $error) {
                $str .= $error . "<br>";
            }
        }
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
    header("Location: loginUser.php");exit();
}

?>
<!-- Thanks for styles to https://codepen.io/colorlib/pen/rxddKy -->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/style-log.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="login-page">
    <div class="form">
	<div>
		<img width='250' src='/img/Logo_A.jpg'></img>
		<br>
		<br>
	</div>
        <form class="login-form" method="post">
            <input name="email" type="text" placeholder="Електронна пошта">
            <input name="name" type="text" placeholder="ФІО">
            <input name="password" type="password" placeholder="Пароль">
            <p>Дата народження:</p><input name="birthday" type="date">
            <p>
            <input name="submit" type="submit" value="Зареєструватись">
            <p class="message">Для входу -><a href="./loginUser.php">Вхід</a></p>
        </form>
    </div>
</div>
</body>
</html>