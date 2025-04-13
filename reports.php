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
    <link rel="stylesheet" href="js/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
</head>

<body style="background-color: aliceblue;">
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;height: 100px;">
    <div>
      <a class="navbar-brand" href="#" style="margin-left: 40px;">
        <img src="photo/mmmm.jpg" alt="" height="45" class="d-inline-block align-text-top">
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
    <br>
    <br>
    <div class="container">
        <div class="card" style="border-radius: 20px;border-color: #03954C;border-width: 5px;">
        

<div class="tableBox">
    <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
        <thead>
            <th>التسلسل</th>
            <th>اسم المشتري</th>
            <th>رقم الهاتف</th>
            <th>الخصم</th>
            <th>المبلغ المستحق</th>
            <th>تم انشاء الفاتورة عن طريق:</th>
            <th>تاريخ انشاء الفاتورة</th>

        </thead>
        <tbody>
            <?php $i = 0;
            $array = $con->query("select * from sold ORDER BY date DESC");
            while ($row = $array->fetch_assoc()) {
                $i = $i + 1;
                $id = $row['id'];
                ?>
                <tr>
                    <td>
                        <?php echo $i; ?>
                    </td>
                    <td>
                        <?php echo $row['name']; ?>
                    </td>
                    <td>
                        <?php echo $row['contact']; ?>
                    </td>
                    <td>
                        <?php echo $row['discount']; ?>
                    </td>
                    <td>
                        <?php echo $row['amount']; ?>
                    </td>
                    <td>
                        <?php echo getAdminName($row['userId']); ?>
                    </td>
                    <td>
                        <?php echo $row['date']; ?>
                    </td>


                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
        

        </div>
    </div>
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
<script type="text/javascript">
    function addInBill(id, place) {
        var value = $("#counter").val();
        value++;
        var selection = 'selection' + place;
        $("#bill").fadeIn();
        $("#counter").val(value);
        $("#" + selection).html("selected");
        $.post('called.php?q=addtobill',
            {
                id: id
            }
        );

    }
    $(document).ready(function () {
        $(".rightAccount").click(function () { $(".account").fadeToggle(); });
        $("#dataTable").DataTable();

    });
</script>
<script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
