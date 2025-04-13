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
    <?php require "assets/autoloader.php" ?>
    <style type="text/css">
        <?php include 'css/customStyle.css'; ?>
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>task</title>
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



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


    <a href="index.php" style="margin-left: 30px;"><button class="btn btn-success"
            style="width: 150px;margin-top: 30px;">
            <h4>الرئيسيه</h4>
        </button></a><br>
    <br>
    <br>
    <br>

    <!-- <a href="" style="margin-left: 30px;"><button class="btn btn-success" style="width: 100px;margin-bottom: 20px;">الرئيسيه</button></a><br> -->

    <?php
    if (isset($_GET['catId'])) {
        $catId = $_GET['catId'];
        $array = $con->query("select * from categories where id='$catId'");
        $catArray = $array->fetch_assoc();
        $catName = $catArray['name'];
        $stockArray = $con->query("select * from inventeries where catId='$catArray[id]'");

    } else {
        $catName = "الادوية";
        $stockArray = $con->query("select * from inventeries");
    }
    include 'assets/bill.php';
    ?>

    <div class="content">

        <div class="tableBox" style="margin: 40px;">
            <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
                <thead>
                    <th style="color:#03954C ;">التسلسل</th>
                    <th style="color:#03954C ;">اسم الدواء</th>
                    <th style="color:#03954C ;">القوة</th>
                    <th style="color:#03954C ;">السعر</th>
                    <th style="color:#03954C ;">الرصيد</th>
                    <th style="color:#03954C ;">اسم المستورد</th>
                    <th style="color:#03954C ;">الشركة المصنعة</th>
                    <th style="color:#03954C ;">بيع</th>
                    <th style="color:#03954C ;"> حذف</th>
                    <th style="color:#03954C ;">تعديل</th>
                </thead>
                <tbody>
                    <?php $i = 0;
                    while ($row = $stockArray->fetch_assoc()) {
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
                                <?php echo $row['unit']; ?>
                            </td>
                            <td>
                                <?php echo $row['price']; ?>
                            </td>
                            <td>
                                <?php echo $row['num']; ?>
                            </td>
                            <td>
                                <?php echo $row['supplier']; ?>
                            </td>
                            <td>
                                <?php echo $row['company']; ?>
                            </td>
                            <?php
                            if (!empty($_SESSION['bill'])) {

                                foreach ($_SESSION['bill'] as $key => $value) {
                                    if (in_array($row['id'], $_SESSION['bill'][$key])) {
                                        echo "<td>تم الاختيار</td>";
                                        break;
                                    } else {
                                        ?>
                                        <td id='selection<?php echo $i; ?>'><button class="btn btn-success  btn-xs"
                                                onclick="addInBill('<?php echo $id ?>','<?php echo $i; ?>')">بيع</button></td>
                                        <?php break;
                                    }
                                }
                            } else { ?>
                                <td id='selection<?php echo $i; ?>'><button class="btn btn-success btn-xs"
                                        onclick="addInBill('<?php echo $id ?>','<?php echo $i; ?>')">بيع</button></td>
                            <?php } ?>
                            <td colspan="center"><a
                                    href="delete.php?item=<?php echo $row['id'] ?>&url=<?php echo $_SERVER['QUERY_STRING'] ?>"><button
                                        class='btn btn-danger btn-xs'>حذف</button></a></td>
                            <td><a href="update.php"><button class='btn btn-primary btn-xs'>تعديل</button></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
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

                <div class="col-md-6 col-lg-3 " style="padding-top: 62px;margin-top: 9px;">
                    <div class="links" style="direction: rtl;">
                        <h5 class="text" style="font-weight: bold;text-decoration: underline;color:#03954C;">اعدادات
                            اخري
                        </h5>
                        <ul class="link list-unstyled">
                            <li class="nav-item">
                                <a class="nav-link p-2 p-lg-3 text-light" aria-current="page"
                                    href="sitesetting.php">اعدادات
                                    النظام</a>
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
                            <img src="photo/mmm.jpg" alt="" style="height: 145px;padding-top: 22px;margin-top: 10px;">
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