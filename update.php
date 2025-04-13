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
    <?php
    $notice = "";
    if (isset($_POST['safeIn'])) {
        $filename = $_FILES['inPic']['name'];
        move_uploaded_file($_FILES["inPic"]["tmp_name"], "photo/" . $_FILES["inPic"]["name"]);
        if ($con->query("insert into categories (name,pic) value ('$_POST[name]','$filename')")) {
            $notice = "<div class='alert alert-success'>Successfully Saved</div>";
        } else
            $notice = "<div class='alert alert-danger'>Not saved Error:" . $con->error . "</div>";
    }

    ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="height: 50px; background-color: white;">
        <div class="container">
            <a class="navbar-brand" href="#" style="display: inline-block;">
                <img src="photo/mmmm.jpg" alt=""
                    style="    height: 50px;margin: -9px">
                <a class="home" href="index.php" style="color: #03954C; text-decoration: none;font-weight: bold;">صيدليه
                    الايمان
                </a>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main"
                aria-controls="main" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="main">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-2">
                    <li class="nav-item">
                        <a class="nav-link p-2 p-lg-3 " aria-current="page" href="index.php"
                            style="color: #03954C; text-decoration: none;font-weight: bold;">الرئيسيه</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 p-lg-3" href="inventeries.php"
                            style="color: #03954C; text-decoration: none;font-weight: bold;">الادويه</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 p-lg-3" href="addnew.php"
                            style="color: #03954C; text-decoration: none;font-weight: bold;">اضافه دواء جديد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 p-lg-3" href="reports.php"
                            style="color: #03954C; text-decoration: none;font-weight: bold;">الفواتير</a>
                    </li>
                </ul>
                <div class="search ps-3 pe-3 d-none d-lg-block">
                    <i class="fa-solid fa-magnifying-glass" style="color: #03954C;"></i>
                </div>
            </div>
        </div>
    </nav>
<br>
   
    <div class="container">
<div class="content2">

<?php
      $notice = "<div class='alert alert-success' style='margin-left: 160px;'><h4>تم تعديل رصيد الصنف </h4></div>";
        if(isset($_POST['saveProduct'])){
          echo $notice;
          
        }

      ?>
    <div style="width: 55%;margin: auto;padding: 22px;" class="well well-sm center">

      <h4 style="color: #03954C;">تعديل رصيد الصنف</h4>
      <form method="POST" class="card" style="background-color:aliceblue;border-radius: 20px;border-color: #03954C;"><br>
         <div class="form-group">
         <label for="some" class="col-form-label">اسم الدواء</label>
         <select name="name" class="form-control" required style="width: 80%;margin-left: 60px;">
                    <?php

                    $dsn = "mysql:host=localhost;dbname=store;charset=utf8mb4";
                    $username = "root";
                    $password = "";

                    try {
                        $pdo = new PDO($dsn, $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                        $query = "SELECT name FROM inventeries";
                        $stmt = $pdo->query($query);


                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    ?>
                </select>
          </div>
          <div class="form-group">
                <label for="some" class="col-form-label"> الرصد الجديد</label>
                <input type="number" name="newnum" class="form-control" required style="width: 80%;margin-left: 60px;">
            </div>
          <br>
          <div class="center">
            <button class="btn btn-success btn-sm btn-block" style="width: 100px;" name="saveProduct">حفظ</button>
          </div>   <br>
        </form>
    </div>
</div>
</div>

    <?php
    if (isset($_POST['saveProduct'])) {
        $new = $_POST['newnum'];
        $name = $_POST['name'];



        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE inventeries SET num = :new WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':new', $new);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $pdo = null;

    }

    ?>



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

                <div class="col-md-6 col-lg-3 " style="padding-top: 62px;margin-top: 9px;">
                    <div class="links" style="direction: rtl;">
                        <h5 class="text" style="font-weight: bold;text-decoration: underline;color:#03954C;">اعدادات
                            اخري
                        </h5>
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
                <div class="col-md-6 col-lg-3" style="    padding-left: 25px;">
                    <div class="info mb-4">

                        <a class="navbar-brand" href="#" style="display: inline-block;">
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