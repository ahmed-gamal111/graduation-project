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
    if ($con->query("insert into categories (name,pic) value ('$_POST[inName]','$filename')")) {
      $notice = "<div class='alert alert-success'>تم الحفظ</div>";
    } else
      $notice = "<div class='alert alert-danger'>خطا:" . $con->error . "</div>";
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
  <div class="content2">
      <!-- <ol class="breadcrumb ">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الفواتير</li>
      </ol> -->
      <?php echo $notice; ?>
      <div class="center">
        <div class="alert alert-success"><span style="font-size: 18pt;color: #03954C;">فاتوره البيع </span></div>
      </div>
      <?php
      if (isset($_POST['updateBill'])) {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        foreach ($_SESSION['bill'] as $key => $value) {
          if ($_SESSION['bill'][$key]['id'] == $id)
            $_SESSION['bill'][$key]['qty'] = $qty;
        }
      }
      $i = 0;
      $total = 0;
      ?>
      <br>
      <table class="table table-hover table-striped table-bordered" style="width: 55%;margin: auto;">
        <tr>
          <th style="color: #03954C;">التسلسل</th>
          <th style="color: #03954C;">اسم الدواء</th>
          <th style="color: #03954C;">الرصيد</th>
          <th style="color: #03954C;">سعر القطعة الوحدة</th>
          <th style="color: #03954C;">حذف</th>
          <th style="color: #03954C;">الكمية</th>
        </tr>
        <?php
        foreach ($_SESSION['bill'] as $row) {
          $i++;
          echo "<tr>";
          echo "<td>$i</td>";
          echo "<td>$row[name]</td>";
          echo "<td>$row[num]</td>";
          echo "<td> $row[price]</td>";
          echo "<td><a href='called.php?remove=$row[id]'><button class='btn btn-danger btn-xs'>حذف</button></a></td>";
          echo "<td> 
            <form method='POST'>
            <input type='hidden' value='$row[id]' name='id'>
            <input type='number' min='1' class='form-control input-sm pull-left' value ='$row[qty]' style='width:88px;' name='qty'>  <button type='submit' name='updateBill' style='margin-left:2px' class='btn btn-success btn-sm'>انشاء</button>
            </form>
            </td>";
          echo "</tr>";
          $total = $total + $row['price'] * $row['qty'];
          $row['num'] = $row['num'] - $row['qty'];
          
          $newnum = $row['num'] - $row['qty'];
          // if ($row['qty'] > $row['num']) {
          //   echo '<h3 style="color:red">' . 'رصيد الصنف رقم' . $i . 'غير كاف' . '</h3>';
          // }
          $warning = "<div class='alert alert-danger' style='margin-left: 240px;width:60%'><h4 style='text-align:center'>رصيد الصنف رقم $i غيلر كاف</h4></div>";
          if ($row['qty'] > $row['num']) {
            echo $warning;
          }
        }
        ?>
        <tr>
          <td colspan="3"> <h5 style="color:#03954C;">اجمالي الفاتورة</h5></td>
          <td></td>
          <td colspan="2"><strong style="color:#03954C;">
              <?php echo $total ?>
            </strong></td>
          <!-- <td>
            <button class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#billOut" name="go">اكمال
              الفاتورة
            </button>
          </td> -->
        </tr>
      </table>
    </div><br>

    <!-- notification -->
<div class="container">
  <h3 style="text-align: center; color:#03954C;">بيانات اخر طلب</h3>
<div id="notification" class="alert alert-success" style="display:ruby-text;height: 50px;"></div>
</div>
<script>

// استرجاع الرسالة من جلسة PHP
var notificationMessage = "<?php echo isset($_SESSION['notification_message']) ? $_SESSION['notification_message'] : 'No notification received!'; ?>";
document.getElementById('notification').innerHTML = notificationMessage;
alert(notificationMessage)
</script>
    <div class="container">
    <div id="billOut"  role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header" style="display: inline-block;text-align: center;">
          
          <h4 class="modal-title" style="color: #03954C;display:inline-block;">معلومات المشتري</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="billout.php">
            <div style="width: 77%;margin: auto;">

              <div class="form-group">
                <label for="some" class="col-form-label" style="color:#03954C;" >الاسم</label>
                <input type="text" name="name" class="form-control" id="some" required>
              </div>
              <div class="form-group">
                <label for="some" class="col-form-label" style="color:#03954C;">رقم الهاتف</label>
                <input type="text" name="contact" class="form-control" id="some" required>
              </div>
              <div class="form-group">
                <label for="some" class="col-form-label" style="color:#03954C;">الخصم</label>
                <input type="text" name="discount" value="0" min="1" class="form-control" id="some" required>
              </div>
            </div>
        </div>
        <div class="modal-footer" style="margin-right: 600px;margin-top: 30px;">
          
          <button type="submit" class="btn btn-success" name="billInfo">حفظ الفاتورة</button>
        </div>
        </form>
      </div>
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
                    <h5 class="text" style="font-weight: bold;text-decoration: underline;color:#03954C;">اعدادات اخري
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

                    <a class="" href="#" style="display: inline-block;">
                        <img src="photo/mmm.jpg" alt=""
                            style="height: 145px;padding-top: 22px;margin-top: 10px;">
                        <a class="home" href="index2.html"
                            style="color: #03954C; text-decoration: none;font-weight: bold;">صيدليه
                            الايمان </a>
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
  $(document).ready(function () { $(".rightAccount").click(function () { $(".account").fadeToggle(); }); });
</script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
