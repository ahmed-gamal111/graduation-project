<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>sigup</title>
    <?php require "assets/function.php" ?>
    <?php require "assets/autoloader.php" ?>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>

    <?php
    $notice = $error = "";

    if (isset($_POST['save'])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $confirm = $_POST['confirm'];
        if ($confirm == $pass && !empty($email)) {

            $con = new mysqli('localhost', 'root', '', 'store');
            $result = $con->query("INSERT INTO users (`email`, `password`) VALUES  ('$email','$pass')");
            $notice = "<div class='alert alert-success'>تم الحفظ</div>";
        } else {
            $error = "<div class='alert alert-danger'>Error is:" . 'please confirm password' . "</div>";
        }

    }

    ?>
</head>

<body>
    <?php echo $notice ?>
    <?php echo $error ?>

    <div class="header" style="background: url(photo/login1.jpg);
    background-size: cover;
    height: 703px;
    width: auto;">
        <nav>
            <img src="photo/mmmm.jpg" alt="" style="width: 110px;
    height: 100px;
    margin-left: 40px;
    margin-top: 20px;
    opacity:0.8 ;
    ">
        </nav>
        <div id="card" style="width:500px; margin-right: 900px;border-radius: 20px; margin-top: 50px;">
            <div id="card-content">
                <div id="card-title">
                    <h2>SIGN UP</h2><br>
                    <div class="underline-title"></div>

                </div>
                <form method="post" class="signup">

                    <input id="user-email" class="form-content" type="email" name="email" style="margin-bottom: 20px;" autocomplete="on"
                        placeholder="Email" required />
                    <div class="form-border"></div>

                    <input id="user-password" class="form-content" type="password" style="margin-bottom: 20px;" name="password"
                        placeholder="Password" required />

                    <div class="form-border"></div>

                    <input id="user-password" class="form-content" type="password" style="margin-bottom: 20px;" name="confirm"
                        placeholder="Cofirm Password" required />
                    <div class="form-border"></div>
                    <a href="login.php">
                        <legend id="forgot-pass" style="    margin-top: 15px;">Login</legend>
                    </a>

                    <input id="submit-btn" type="submit" name="save" value="SIGN UP" />

                </form>
            </div>
        </div>

    </div>
</body>

</html>
<?php


// if (isset($_POST['save'])) {
//     $email = $_POST['email'];
//     $pass = $_POST['password'];
//     $confirm = $_POST['confirm'];
//     if ($confirm == $pass && !empty($email)) {

//         $con = new mysqli('localhost', 'root', '', 'store');
//         $result = $con->query("INSERT INTO users (`email`, `password`) VALUES  ('$email','$pass')");
//         $notice = "<div class='alert alert-success'>تم الحفظ</div>";
//     }

// }

// $notice = "";
// if (isset($_POST['save'])) {
//     if ($con->query("update users SET email='$_POST[email]',password='$_POST[password]' where id='$_SESSION[userId]'")) {

//         $notice = "<div class='alert alert-success'>تم الحفظ</div>";

//     } else {
//         $notice = "<div class='alert alert-danger'>Error is:" . $con->error . "</div>";
//     }

// }
// if (isset($_GET['notice'])) {
//     $notice = "<div class='alert alert-success'>تم الحفظ</div>";
// }
?>