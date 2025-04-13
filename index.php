<?php
session_start();

?>

<?php require "assets/function.php" ?>
<?php require 'assets/db.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>task</title>


  <?php require "assets/autoloader.php" ?>
  <link rel="stylesheet" href="css/customStyle.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js">
  <link
    href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,200&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- <script src="js/jquery.js"></script> -->
  <script src="css/bootstrap.min.js"></script>
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

<body style="background-color: #ECF3F6;">
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
  <div class="our-work pt-4 pb-4">
    <div class="container pb-5 pt-5">
      <a href="manageCat.php" ><button class="btn btn-success" style="width: 150px;height: 40px;"><h4><i class="fa fa-gear  fa-fw"> </i>ادارة
          التصنيفات</h4></button></a>
      <div class=" text-center mt-4 mb-4 position-relative ">
        <h2 class="text-bold" style="color: #03954C;">التصنيفات </h2>
        <hr style="width: 150px;display:inline-block;border: 4px solid green;">
      </div>
    </div>

  </div>

  <div class="container">
    <div class="row" style="margin-left: 225px;">
      <div style="display: contents;">
        <?php
        $array = $con->query("select * from categories");
        while ($row = $array->fetch_assoc()) {
          $array2 = $con->query("select count(*) from inventeries where catId = '$row[id]'");
          $row2 = $array2->fetch_assoc();
          ?>
          <div class="box" style="margin-right: 10px;padding-right: 50px;">
            <a href="inventeries.php?catId=<?php echo $row['id'] ?>">
              <div class="box2">
                <div class="center"> <img src="photo/<?php echo $row['pic'] ?>" style="width: 155px;height: 122px;"
                    class='img-thumbnail'></div>
                <hr style="margin: 7px;">
                <span style="padding: 11px"><strong style="font-size: 10pt">الاسم</strong><span class="pull-right"
                    style="color:blue;margin-right: 11px;">
                    <?php echo $row['name'] ?>
                  </span></span>
                <hr style="margin: 7px;">
                <span style="padding: 11px"><strong style="font-size: 10pt">الادوية المتوفرة</strong><span
                    class="pull-right" style="color:blue;margin-right: 11px">
                    <?php echo $row2['count(*)']; ?>
                  </span></span>
              </div>
            </a>
          </div>

          <?php
        }
        ?>
      </div>
    </div>
  </div>
  <br>
  <br>

  <div class="footer pt-2 pb-2 text-center text-md-start" style="background-color:#333F4B">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-5 text-light" style="display: flex;align-items: center;padding: 24px;color: white;">
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
            <h5 class="text" style="font-weight: bold;text-decoration: underline;color:#03954C;">اعدادات اخري</h5>
            <ul class="link list-unstyled">
              <li class="nav-item">
                <a class="nav-link p-2 p-lg-3 text-light" aria-current="page" href="sitesetting.php">اعدادات النظام</a>
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
        <div class="col-md-6 col-lg-3" style=" padding-left: 25px;">
          <div class="info mb-4">

            <a class="" href="#" style="display: inline-block;">
              <img src="photo/mmm.jpg" alt="" style="height: 145px;padding-top: 22px;margin-top: 10px;">
              <a class="home" href="index2.html" style="color: #03954C; text-decoration: none;font-weight: bold;">
                صيدليه الايمان </a>
            </a>
            <p class="mb5 text-light" style="font-weight: bold;">سيستم متكامل لتوفير احتياجات المرضي بسهوله</p>
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
<script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script type="text/javascript">
  $(document).ready(function () { $(".rightAccount").click(function () { $(".account").fadeToggle(); }); });
</script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>