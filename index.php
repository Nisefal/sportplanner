<?php
$flag = false;
if (count($_COOKIE) > 1)
{
    if(isset($_COOKIE['uid'])) {
        if(!$_COOKIE['uid'] || !$_COOKIE['sid'] || $_COOKIE['uid']=="" || $_COOKIE['sid']=="")
            header('Location: logout.php');

        include "/models/modelUser.php";

        $model = new modelUser();
        $flag = $model->validateUser($_COOKIE['uid'], $_COOKIE['sid']);
        if($flag !== true)
            header("Location: /logout.php");
        $model->destroy();
    }
    else {
        if(!$_COOKIE['gid'] || !$_COOKIE['sid'] || $_COOKIE['gid']=="" || $_COOKIE['sid']=="")
            header('Location: logout.php');
        include "/models/modelUser.php";

        $model = new modelGym();
        $flag = $model->validateGym($_COOKIE['gid'], $_COOKIE['sid']);
        if($flag !== true)
            header("Location: /logout.php");
        $model->destroy();
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
 <script src="https://use.fontawesome.com/53c0c327d5.js"></script>
  <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/animate.min.css">
	<link href="styles/style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="main">
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
                <?php
                if ($flag == false)
                    echo "<a href=\"auth.php\" class=\"navbar-brand\"><li class=\"hov\">Авторизація</li></a>
                    <a href=\"generegistr.php\" class=\"navbar-brand\"><li class=\"hov\">Реєстрація</li></a>";
                else {
                    if (isset($_COOKIE['uid']))
                        echo "<a href=\"account\usercabinet.php\" class=\"navbar-brand\"><li class=\"hov\">Кабінет</li></a>";
                    else
                        echo "<a href=\"account\gymcabinet.php\" class=\"navbar-brand\"><li class=\"hov\">Кабінет</li></a>";

                    echo "<a href=\"logout.php\" class=\"navbar-brand\"><li class=\"hov\">Вийти</li></a>";

                }

                ?>
            </ul>
        </div>
        </div>
		<!--End Header-->
	
	<!--Body-->
	<div id="header" class="header">
          
          	<p id="pr1"class="animated fadeInUp"></p>
          	<h1 id="pr2"class="animated fadeInUp">SportPlanner</h1>
          	<p id="pr3"class="animated fadeInUp ">Твій персональний планер. Займайся спортом разом із нами.</p>
          	<p id="pr3" class="animated pulse infinite"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
          
    </div>
    <!--End Body-->	
	</div>
		
</body>
</html>