<?php
session_start();

if (!isset($_SESSION['userId'])) {
  header('location:login.php');
}
?>
<?php require "assets/function.php" ?>
<?php require 'assets/db.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <title>
    <?php echo siteTitle(); ?>
  </title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
    <?php include 'css/customStyle.css'; ?>
  </style>
  <?php
  $notice = "";

  ?>
</head>

<body style="background: #ECF0F5;padding:0;margin:0">

  <div class="content2">
    <div class="well well-sm" style="width: 77%;margin:auto;margin-top: 33px;">
      <div class="well well-sm center">
        <h1>
          <?php echo siteName(); ?>
        </h1>
      </div>
    </div>
    <br>
    <div class="well well-sm" style="width: 77%;margin: auto;">
      <table class="table table-bordered table-striped">
        <tr>
          <th>اسم المشتري</th>
          <td>
            <?php echo $_POST['name'] ?>
            </th>
          <th>رقم الهاتف</th>
          <td>
            <?php echo $_POST['contact'] ?>
            </th>
        </tr>
        <tr>
          <th>تاريخ انشاء الفاتورة:</th>
          <td>
            <?php echo date("Y-m-d h:i:sa"); ?>
          </td>
          <th>تم انشاء الفاتورة بواسطة</th>
          <td>
            <?php echo adminName(); ?>
          </td>
        </tr>
        <tr>
          <th colspan="4" class="center">
            <h3>تفاصيل الطلب</h3>
          </th>
        </tr>
        <tr>
          <th>التسلسل</th>
          <th>اسم الطلب</th>
          <th>سعر القطعة</th>
          <th>الكمية</th>
        </tr>
        <?php
        $i = $total = 0;
        foreach ($_SESSION['bill'] as $row) {
          $i++;
          echo "<tr>";
          echo "<td>$i</td>";
          echo "<td>$row[name]</td>";
          echo "<td>USD. $row[price]</td>";
          echo "<td>$row[qty]</td>";
          echo "</tr>";
          $total = $total + $row['price'] * $row['qty'];
        }
        ?>
        <tr>
          <td colspan="3" style="text-align: right;">المجموع الكلي </td>
          <th>
            <?php echo $total; ?>
          </th>
        </tr>
        <tr>
          <td colspan="3" style="text-align: right;">الخصم</td>
          <th style="border-bottom: 1px solid blue;">
            <?php echo $_POST['discount']; ?>
          </th>
        </tr>
        <tr>
          <td colspan="3" style="text-align: right;border-right: 1px solid blue">المبلغ المستحق </td>
          <th style="border: 1px solid blue;">
            <?php echo $total - $_POST['discount']; ?>
          </th>
        </tr>
        <tr>
          <td class="center" colspan="4"><button class="btn btn-primary" onclick="window.print()">طباعة</button> <a
              href="index.php"><button class="btn btn-success" name="back">العودة</button></a></td>
        </tr>
      </table>
    </div>
  </div>


  <?php
  $total = $total - $_POST['discount'];
  if (!$con->query("insert into sold (name,contact,discount,amount,item,userId) values ('$_POST[name]','$_POST[contact]','$_POST[discount]','$total','$i','$_SESSION[userId]')")) {
    echo "Error is:" . $con->error;
  }
  if (isset($_POST['billInfo'])) {
    foreach ($_SESSION['bill'] as $row) {
      $newnum = $row['num'] - $row['qty'];
      $id = $row['id'];
      $update_query = "UPDATE inventeries SET num='$newnum' WHERE id=$id";

      if ($con->query($update_query) === TRUE) {
        echo "Record updated successfully for item with ID: $id";
      } else {
        echo "Error updating record for item with ID: $id. Error: " . $con->error;
      }
    }

    unset($_SESSION['bill']);
    $_SESSION['bill'] = array();
  }


  ?>
</body>

</html>

<script type="text/javascript">
  $(document).ready(function () { $(".rightAccount").click(function () { $(".account").fadeToggle(); }); });
</script>