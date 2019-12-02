<?
// include data, etc.

include "config.php";
include "\models\modelLoginUser.php";

// Страница авторизации


// редирект, если уже авторизирован
if ($_COOKIE["uid"] and $_COOKIE["sid"] and $_COOKIE["uid"] !== "" and $_COOKIE["sid"] !== "")
{
    header("Location: account/usercabinet.php");exit();
}

if(isset($_POST['submit']))
{
    $err = array();
    $model = new modelLoginUser();

    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $valid_email = $model->removeChars($_POST['email']);

    $password = $_POST['password'];

    $result = $model->checkUser($valid_email, $password);

    if($result)
        $data_row = $result->fetch_row();
    else
        $err[] = "Електронна скринька або пароль невірні.";

    /* data[i], i:
     * 0 - id
     */

    if (count($err)> 0) {
        print "<b>Помилки:</b><br>";
        foreach ($err AS $error) {
            print $error . "<br>";
        }

        $model->destroy();
    } else {
        $sid = md5(rand(-100,100));
        $time =  time() + $exp_time;
        setcookie("sid", $sid, $time, "/", $baseUrl);

        $model->loginUser($data_row[0], $sid);

        setcookie("uid", md5($data_row[0]), time() + $exp_time, "/", $baseUrl);

        $model->destroy();

        # Переадресовываем браузер на вход
        header("Location: account/usercabinet.php");exit();
    }
}

?>
<!-- Thanks for styles to https://codepen.io/colorlib/pen/rxddKy -->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/style-log.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.8; charset=utf-8" http-equiv="Content-Type">
</head>
<body>
<div class="login-page">
    <div class="form">
    <div>
        <img width='250' src='/img/Logo_A.jpg'></img>
        <br>
        <br>
    </div>
        <form class="login-form" method="POST">
            <input type="text" name="email" placeholder="Email"/>
            <input type="password" name="password" placeholder="Пароль"/>
            <input name="submit" type="submit" value="Вхід">
            <p class="message">Для роєстрації -><a href="registerUser_tmp.php">Реєстрація</a></p>
        </form>
    </div>
</div>
</body>
<script>
//window.alert(window.outerWidth);
</script>
</html>