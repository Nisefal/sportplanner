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
	<div class="main2">

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
              <a href="generegistr.php" class="navbar-brand"><li class="hov">Реєстрація</li></a>
          </ul>
          </div>
        </div>
		<!--End Header-->
	
	<!--Body-->
<section class="formreg">
        <div class="wrap">
            <h3>Вітаємо!</h3>
            <form class="login-form" method="POST">
                <input class="input-form" id="e-mail"  type="text" name="email" placeholder="example@gmail.com"/>
                <input class="input-form" id="password" type="password" name="password" placeholder="Пароль"/>
                <input name="submit" type="submit" value="Вхід">
                <p class="message">Для роєстрації -><a href="registclient.php">Реєстрація</a></p>
            </form>
        </div>
      </section>
  
	 
    <!--End Body-->	
	</div>
		
</body>
</html>
