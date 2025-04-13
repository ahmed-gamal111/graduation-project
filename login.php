<?php require "assets/function.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Login</title>
	<?php require "assets/autoloader.php"?>
	<style type="text/css">
	<?php include 'style.css'; ?>
	
	</style>
</head>

<body>
  <div class="header" style="background: url(photo/1234.jpg);
    background-size: cover;
    height:703px;
    width: auto;
    ">
<nav>,</nav>

    
    <div id="card" style="width:700px; margin-right: 900px;border-radius: 20px; margin-top: 200px; margin-left: 230px;">
    <div id="card-content">
      <div id="card-title">
        <h2 style="color:#3abfae;">LOGIN</h2><br>
        <div class="underline-title"></div>
        
      </div>
      <form method="post" class="form">
        <label for="user-email" style="padding-top:13px">
            &nbsp;Email
          </label>
        <input id="user-email" class="form-content" type="email" name="email" autocomplete="on" required />
        <div class="form-border"></div>
        <label for="user-password" style="padding-top:22px">&nbsp;Password
          </label>
        <input id="user-password" class="form-content" type="password" name="password" required />
        <div class="form-border"></div>
        <div class="" style="display: flex;">

        <a href="sign up.php">
          <legend id="forgot-pass" style="margin-top: 10px;">sign up?</legend>
        </a>
        </div>
        <input id="submit-btn" type="submit" name="login" value="LOGIN" />
        
      </form>
    </div>
  </div>
    
  </div>
</body>

</html>

<?php 

if (isset($_POST['login'])) 
{
	$user = $_POST['email'];
    $pass = $_POST['password'];
    $con = new mysqli('localhost','root','','store');



    session_start();
$_SESSION['userId'] = 1; // أي رقم تجريبي
$_SESSION['bill'] = array();
header('location:index.php');
exit();

}

 ?>