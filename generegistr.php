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
          <h3>Оберіть, будь ласка</h3>
        
         <a href="registrsport.php" class="navbar-brand"><button class="registration" type="button"
                                                                 value=""> Спортзал </button></a>

         <a href="registclient.php" class="navbar-brand"><button class="registration" type="button"
                                                                 value=""> Клієнт </button></a>
          


      
        </div>
      

      </section>
  
	 
    <!--End Body-->	
	</div>
		
</body>
</html>
