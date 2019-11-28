<?
// include data, etc.

include "config.php";

// Страница авторизации


// редирект, если уже авторизирован
if ($_COOKIE["uid"] and $_COOKIE["sid"] and $_COOKIE["uid"] !== "" and $_COOKIE["sid"] !== "")
{
    header("Location: index.php");exit();
}

if(isset($_POST['submit']))
{
    $connect = mysqli_connect(
'yrn.mysql.tools', /* Хост, к которому мы подключаемся */
'yrn_kb', /* Имя пользователя */
'e27y18JIKpgU', /* Используемый пароль */
'yrn_advin'); /* База данных для запросов по умолчанию */

    if (!$connect) {
        setcookie("error", "Не вдалося підключитися до Бази Данних.", time() + $exp_time, "/", $baseUrl);
        header('Location: ./error.php');
    }

    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $valid_email = $connect->real_escape_string($_POST['email']);

    $sql = "SELECT uid, sid, exp FROM users WHERE email ='".$valid_email."' AND password = '".md5(md5($_POST['password']))."'";

    $query = $connect->query(utf8_encode($sql));

    $data_row = $query->fetch_row();
    /* data[i], i:
     * 0 - uid
     * 1 - sid
     * 2 - exp
     */

    $sid = $data_row[1];
    $exp = $data_row[2];

    $err = array();

    if(!$data_row)
        $err[] = "Електронна скринька або пароль невірні."; 

    if (count($err)> 0) {
        print "<b>Помилки:</b><br>";
        foreach ($err AS $error) {
            print $error . "<br>";
        }

        mysqli_close($connect);
    } else {

        $now =  date('Y-m-d H:i');

        if($exp <= $now) {
            $sid = md5(rand(-100,100));
            $time =  time() + $exp_time;
            setcookie("sid", $sid, $time, "/", $baseUrl);
            $sql = "UPDATE users SET sid='" . $sid . "', exp = '".gmdate("Y-m-d H:i", $time)."' WHERE uid='" . $data_row[0] ."';";

            # Записываем в БД новый sid
            $connect->query(utf8_encode($sql));
        } else {
            setcookie("sid", $sid, mktime($exp), "/", $baseUrl);
        }
        
        setcookie("uid", $data_row[0], time() + $exp_time, "/", $baseUrl);

        mysqli_close($connect);

        # Переадресовываем браузер на вход
        header("Location: index.php");exit();

    }
    if(isset($_POST['redirect'])) {
        header("Location: register.php");exit();
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
            <p class="message">Для роєстрації -><a href="./register.php">Реєстрація</a></p>
        </form>
    </div>
</div>
</body>
<script>
//window.alert(window.outerWidth);
</script>
</html>