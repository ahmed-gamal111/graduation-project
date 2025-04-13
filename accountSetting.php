<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header('location:login.php');
}
?>
<?php require "assets/function.php" ?>
<?php require 'assets/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require "assets/autoloader.php" ?>
    <style type="text/css">
        <?php include 'css/customStyle.css'; ?>
    </style>
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
    $notice = "";
    if (isset($_POST['saveSetting'])) {
        if ($con->query("update users SET email='$_POST[email]',password='$_POST[password]' where id='$_SESSION[userId]'")) {

            $notice = "<div class='alert alert-success'>تم الحفظ</div>";
           
        } else {
            $notice = "<div class='alert alert-danger'>Error is:" . $con->error . "</div>";
        }

    }
    if (isset($_GET['notice'])) {
        $notice = "<div class='alert alert-success'>تم الحفظ</div>";
    }
    ?>
</head>

<body style="background-color: aliceblue;">
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;height: 90px;">
    <div>
      <a class="navbar-brand" href="#" style="margin-left: 40px;">
        <img src="photo/mmmm.jpg" alt="" height="60" class="d-inline-block align-text-top">
      </a>
      <h5></h5>

    </div>
    <div class="collapse navbar-collapse" id="main">
      <ul class="navbar-nav " style="font-size: 20px ; ">
        <li class="nav-item">
          <a class="nav-link p-2 p-lg-3 " aria-current="page" href="index.php"
            style="color: #03954C; text-decoration: none;font-weight: bold;">صيدليه الايمان</a>
        </li>

        <li class="nav-item" style="margin-left: 490px;">
          <a class="nav-link p-2 p-lg-3 " aria-current="page" href="index.php"
            style="color: #03954C; text-decoration: none;font-weight: bold;">الرئيسيه</a>
        </li>
        <li class="nav-item" style="padding-left: 30px;">
          <a class="nav-link p-2 p-lg-3" href="inventeries.php"
            style="color: #03954C; text-decoration: none;font-weight: bold;">الادويه</a>
        </li>
        <li class="nav-item" style="padding-left: 30px;">
          <a class="nav-link p-2 p-lg-3" href="addnew.php"
            style="color: #03954C; text-decoration: none;font-weight: bold;">اضافه دواء جديد</a>
        </li>
        <li class="nav-item" style="padding-left: 30px;">
          <a class="nav-link p-2 p-lg-3" href="reports.php"
            style="color: #03954C; text-decoration: none;font-weight: bold;">الفواتير</a>
        </li>
      </ul>
    </div>


  </nav>


    <div class="container">

        <div class="content2">

            <?php echo $notice ?>
            <div style="width: 55%;margin: auto;padding: 22px;height: 320px;" class="well well-sm center">

                <h4 style="color: #03954C;"> بيانات تسجيل الدخول </h4>
                <form method="POST" class="card"
                    style="background-color:aliceblue;border-radius: 20px;border-color: #03954C;"><br>
                    <div class="form-group">
                        <label for="some" class="col-form-label">
                            <h5> البريد الالكتروني</h5>
                        </label>
                        <input type="email" name="email" style="width: 80%;margin-left: 60px;" class="form-control"
                            value="<?php echo $user['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="some" class="col-form-label">
                            <h5> كلمه المرور</h5>
                        </label>
                        <input type="password" name="password" style="width: 80%;margin-left: 60px;"
                            value="<?php echo $user['password'] ?>" class="form-control" required>
                    </div>
                    <br>
                    <div class="center">
                        <button class="btn btn-success" style="width: 100px;"
                            name="saveSetting">حفظ</button>
                    </div> <br>
                </form>
            </div>
        </div>
    </div>


    <div class="footer pt-2 pb-2 text-center text-md-start" style="background-color:#333F4B">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5 text-light" style="display: flex;align-items: center;padding: 24px;">
                    <div>
                        <h4>تواصل معنا من خلال </h4>
                        <div class="icons">
                            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-youtube"></ion-icon></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 " style="padding-top: 55px;margin-top: 9px;">
                    <div class="links" style="direction: rtl;">
                        <h5 class="text" style="font-weight: bold;text-decoration: underline;color:#03954C;">اعدادات
                            اخري</h5>
                        <ul class="link list-unstyled">
                            <li class="nav-item">
                                <a class="nav-link p-2 p-lg-3 text-light" aria-current="page"
                                    href="sitesetting.php">اعدادات النظام</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2 p-lg-3 text-light" href="profile.php">الملف الشخصي</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2 p-lg-3 text-light" href="accountSetting.php">بيانات الحساب</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-2 p-lg-3 text-light" href="login.php">تسجيل الخروج</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info mb-4">

                        <a class="" href="#" style="display: inline-block;">
                            <img src="photo/mmm.jpg" alt=""
                                style="height: 145px;padding-top: 22px;margin-top: 10px;">
                            <a class="home" href="index2.html"
                                style="color: #03954C; text-decoration: none;font-weight: bold;">صيدليه
                                الايمان </a>
                        </a>
                        <p class="mb5 text-light" style="font-weight: bold;">سيستم متكامل لتوفير احتياجات المرضي بسهوله
                        </p>
                        <div class="copyright text-light">
                            creater by <span>Team</span>
                            <div>&copy; 2024 - <span>صيدليه الايمان</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>