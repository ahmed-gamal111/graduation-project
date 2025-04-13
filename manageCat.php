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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require "assets/autoloader.php" ?>
    <style type="text/css">
        <?php include 'css/customStyle.css'; ?>
    </style>
    <?php
    $notice = "";
    if (isset($_POST['safeIn'])) {
        $filename = $_FILES['inPic']['name'];
        move_uploaded_file($_FILES["inPic"]["tmp_name"], "photo/" . $_FILES["inPic"]["name"]);
        if ($con->query("insert into categories (name,pic) value ('$_POST[inName]','$filename')")) {
            $notice = "<div class='alert alert-success'>تم الاضافة بنجاح</div>";
        } else
            $notice = "<div class='alert alert-danger'>خطأ:" . $con->error . "</div>";
    }

    ?>
</head>

<body>
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;height: 100px;">
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

        <li class="nav-item" style="margin-left: 600px;">
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
    <div class="content2">

        <?php echo $notice; ?>
        <div>
            <span style="font-size: 20pt;color: #03954C;margin-left: 650px;">التصنيفات </span>
            <hr style="width: 120px;margin-left: 650px;color: #03954C;">
            <button class="btn btn-success btn-sm pull-right" style="margin-right: 30px; display: block;"
                data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-plus fa-fw"> </i>اضافة تصنيف
                جديد</button>

        </div>
        <div class="card" style="width: 700px;margin-left: 380px; background-color:azure;padding-bottom: 30px;">
            <?php
            $i = 0;
            $array = $con->query("select * from categories");
            ?>
            <br>
            <table class="table table-hover table-striped " style="width: 90%;margin: auto;">
                <tr>
                    <th style="color: #03954C;">التسلسل</th>
                    <th style="color: #03954C;">الاسم</th>
                    <th style="color: #03954C;">كمية الادوية</th>
                    <th style="color: #03954C;">تحرير</th>
                </tr>
                <?php
                while ($row = $array->fetch_assoc()) {
                    $i++;
                    $array2 = $con->query("select count(*) as qty from inventeries where catId = '$row[id]'");
                    $row2 = $array2->fetch_assoc();
                    ?>
                    <tr>
                        <td>
                            <?php echo $i ?>
                        </td>
                        <td>
                            <?php echo $row['name']; ?>
                        </td>
                        <td>
                            <?php echo $row2['qty']; ?>
                        </td>
                        <td><a href="delete.php?category=<?php echo $row['id'] ?>"><button
                                    class="btn btn-xs btn-danger">حذف</button></a></td>
                    </tr>

                    <?php
                }
                echo "</table>";
                ?>
        </div>

    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color:aliceblue;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="margin-right: 220px;"></button>
                    <h4 class="modal-title">اضافة تصنيف جديد</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div style="width: 77%;margin: auto;">

                            <div class="form-group">
                                <label for="some" class="col-form-label">الاسم</label>
                                <input type="text" name="inName" class="form-control" id="some" required>
                            </div>
                            <div class="form-group">
                                <label for="2" class="col-form-label">الصورة</label>
                                <input type="file" name="inPic" class="form-control" id="2" required>
                            </div>


                        </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-primary" name="safeIn">اضافة </button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <br>




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
                <div class="col-md-6 col-lg-3" style="    padding-left: 25px;">
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
