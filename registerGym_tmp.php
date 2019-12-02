<?php

include "config.php";
include "\models\modelRegistrationUser.php";
include "\models\modelLoginUser.php";

// Страница регситрации нового пользователя

// редирект, если уже авторизирован
if ($_COOKIE['sid'] and  $_COOKIE["sid"] !== "" )
    setcookie("sid", "", time() + $exp_time, "/", $baseUrl);

if ($_COOKIE['gid'] and $_COOKIE["gid"] !== "")
    setcookie("gid", "", time() + $exp_time, "/", $baseUrl);

if(isset($_POST['submit']))
{
    if($_POST['email']==='')
        $err[] = 'Вкажіть вашу електронну скриньку!';
    if($_POST['name']==='')
        $err[] = 'Вкажіть назву спортзали!';
    if($_POST['password']==='')
        $err[] = 'Вкажіть пароль!';
    if($_POST['tele']==='')
        $err[] = 'Вкажіть телефон!';

    $err = array();
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $tele = $_POST['tele'];

    $model = new modelRegistrationGym();

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
        $err[] = "Довжина назви має бути не менше 3 символів.";
    }

    $query = $model->findGym($valid_email);

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

        $result = $model->registerGym($valid_email, $password, $valid_name, $tele);

        $result = $model->findGym($valid_email);

        if($result) {
            $row = $result->fetch_row();
        }
        else $err[] = "Проблема добавления юзера";

        $id = $row[0];

        $uid = md5($id);
        $sid = md5(rand(-100,100));
        $model->destroy();
        $model = new modelLoginUser();
        $model->loginGym($id,$sid);

        $model->destroy();


        # Выдать sid, uid
        setcookie("sid", $sid, time() + $exp_time, "/", $baseUrl);
        setcookie("gid", $uid, time() + $exp_time, "/", $baseUrl);

        if(count($err) == 0) {
            header("Location: authGym.php"); exit();
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
    header("Location: authGym.php");exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportPlanner</title>

    <link href="styles/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="main3">

    <!--Header-->
    <div id="myNavbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#navbar" class="navbar-brand">SportPlanner</a>
            </div>
            <ul class="buttons">
                <a href="index.php" class="navbar-brand"><li class="hov">Головна</li></a>
                <a href="auth.php" class="navbar-brand"><li class="hov">Авторизація</li></a>
            </ul>
        </div>
    </div>
    <!--End Header-->

    <!--Body-->
    <section class="formreg">
        <div class="wrap">
            <h3>
                Шановний клієнт, заповніть, будь ласка, інформацію
            </h3>

            </form>

            <form class="login-form" method="post">
                <input class="input-form" name="email" type="text" placeholder="example@gmail.com">
                <input class="input-form" name="name" type="text" placeholder="ФІО">
                <input class="input-form" name="password" type="password" placeholder="Пароль">
                <p>Дата народження:</p><input name="birthday" type="date">
                <p>
                    <input name="submit" type="submit" value="Зареєструватись">
                <p class="message">Для входу -><a href="./auth.php">Вхід</a></p>
            </form>
        </div>


    </section>


    <!--End Body-->
</div>

</body>
</html>
