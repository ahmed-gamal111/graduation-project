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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            $notice = "<div class='alert alert-success'>تم اضافة الدواء بنجاح</div>";
        } else
            $notice = "<div class='alert alert-danger'>خطا :" . $con->error . "</div>";
    }

    ?>
    <?php
    require 'vendor/autoload.php';

    use Zxing\QrReader;

    $msg = "";
    if (isset($_POST['upload'])) {
        $filename = $_FILES['qrcode']['name'];
        $filetype = $_FILES['qrcode']['type'];
        $filetemp = $_FILES['qrcode']['tmp_name'];
        $filesize = $_FILES['qrcode']['size'];

        $filetype = explode("/", $filetype);
        if ($filetype[0] !== 'image') {
            $msg = "file must be an image file";

        } elseif ($filesize > 5242880) {
            $msg = "file size is too gig";

        } else {

            $newfilename = md5(rand() . time()) . $filename;

            $qrscane = new QrReader("uploads/" . $filename);

            $msg = $qrscane->text();


        }


    }

    ?>
</head>

<body>
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
    <?php
    if (isset($_POST['saveProduct'])) {
        if ($con->query("insert into inventeries (catId,supplier,name,unit,price,num,description,company) values ('$_POST[catId]','$_POST[supplier]','$_POST[name]','$_POST[unit]','$_POST[price]','$_POST[num]','$_POST[discription]','$_POST[company]')")) {
            $notice = "<div class='alert alert-success'>تم اضافة الدواء بنجاح</div>";
        } else {
            $notice = "<div class='alert alert-danger'>خطا:" . $con->error . "</div>";
        }
    }
    ?>
    <div class="content2">

        <?php echo $notice ?>
        <div style="width: 55%;margin: auto;padding: 22px;" class="well well-sm center">

            <h4 style="color: #03954C;">اضافة دواء جديد</h4>
            <hr style="border-top:4px solid #03954C;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="qrcode" class="form-label">Upload Your QrCode</label>
                    <input class="form-control" type="file" name="qrcode" id="qrcode" required>
                    <br>
                    <button type="submit" name="upload" class="btn btn-success" style="margin-left: 500px;">
                        convert it
                    </button>
                </div>
            </form>
            <br>

            <form method="POST">

                <div class="form-group">

                    <label for="some" class="col-form-label" style="color: #03954C;">اسم الدواء</label>
                    <input type="text" name="name" class="form-control" id="text" readonly="" value="<?php echo $msg ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">التركيز</label>
                    <input type="text" name="unit" placeholder="mg" class="form-control" id="some" value="<?php
                    if ($msg == "One Two Three") {
                        echo "500mg";
                    } elseif ($msg == "One Two Three") {
                        echo "500";
                    } elseif ($msg == "Abimol") {
                        echo "500";
                    } elseif ($msg == "Abimol Extra") {
                        echo "500";
                    } elseif ($msg == "Adol Extra") {
                        echo "500";
                    } elseif ($msg == "Adwiflam") {
                        echo "75mg";

                    } elseif ($msg == "Aggrex 75") {
                        echo "75mg";
                    } elseif ($msg == "All Vent") {
                        echo "125ml";
                    } elseif ($msg == "Alphintern") {
                        echo "0";

                    } elseif ($msg == "Amaryl") {
                        echo "1mg";
                    } elseif ($msg == "Ambizem") {
                        echo "0";
                    } elseif ($msg == "Anticox") {
                        echo "15mg/3ml";
                    } elseif ($msg == "Antinal") {
                        echo "200mg";
                    } elseif ($msg == "antodin") {
                        echo "20mg";
                    } elseif ($msg == "Apidone") {
                        echo "125ml";
                    } elseif ($msg == "Aspocid") {
                        echo "75mg";
                    } elseif ($msg == "Betaderm") {
                        echo "0";
                    } elseif ($msg == "Biovit") {
                        echo "0";
                    } elseif ($msg == "brufen400 tab") {
                        echo "400mg";
                    } elseif ($msg == "Brufen") {
                        echo "400mg";
                    } elseif ($msg == "Calcimate") {
                        echo "500mg";
                    } elseif ($msg == "Cataflam") {
                        echo "75mg/3ml";
                    } elseif ($msg == "Cataflam") {
                        echo "50mg";
                    } elseif ($msg == "Ceporex 1g 500mg") {
                        echo "500mg";
                    } elseif ($msg == "Cetal syrp") {
                        echo "250mg/5ml";
                    } elseif ($msg == "Cipro") {
                        echo "500mg";
                    } elseif ($msg == "Ciprocin 500") {
                        echo "500mg";
                    } elseif ($msg == "Ciprofar 500") {
                        echo "500mg";
                    } elseif ($msg == "Cold Free") {
                        echo "0";
                    } elseif ($msg == "Concor") {
                        echo "5mg";
                    } elseif ($msg == "Congestal") {
                        echo "500mg";
                    } elseif ($msg == "Controloc") {
                        echo "40mg";
                    } elseif ($msg == "Curam 1g 625mg") {
                        echo "500mg";
                    } elseif ($msg == "Daflon") {
                        echo "500mg";
                    } elseif ($msg == "Declophen") {
                        echo "75mg/3ml";
                    } elseif ($msg == "Depovit") {
                        echo "1000mgc";
                    } elseif ($msg == "Dexamethazone") {
                        echo "8mg/2ml";
                    } elseif ($msg == "Digenorm") {
                        echo "120ml";
                    } elseif ($msg == "Digestin") {
                        echo "0";
                    } elseif ($msg == "Dolipran") {
                        echo "1g";
                    } elseif ($msg == "Dorofen") {
                        echo "0";
                    } elseif ($msg == "Edemex") {
                        echo "1mg";
                    } elseif ($msg == "Erastapex") {
                        echo "20mg";
                    } elseif ($msg == "Ezapril-co") {
                        echo "20/12.5mg";
                    } elseif ($msg == "Ezapril") {
                        echo "10mg";
                    } elseif ($msg == "Feroglobin") {
                        echo "0";
                    } elseif ($msg == "Flagyl") {
                        echo "125mg/5ml";
                    } elseif ($msg == "Flector") {
                        echo "50mg";
                    } elseif ($msg == "Flepton") {
                        echo "0";
                    } elseif ($msg == "Flumox 500mg 1g") {
                        echo "500mg";
                    } elseif ($msg == "Flurest") {
                        echo "0";
                    } elseif ($msg == "Fuci") {
                        echo "0";
                    } elseif ($msg == "Fucicort") {
                        echo "15gm";
                    } elseif ($msg == "Fucizone") {
                        echo "0";
                    } elseif ($msg == "Gast-Reg") {
                        echo "125ml";
                    } elseif ($msg == "Glucophage 500") {
                        echo "500mg";
                    } elseif ($msg == "Hibiotec 1g 625mg") {
                        echo "1gm";
                    } elseif ($msg == "Histazen") {
                        echo "10mg";
                    } elseif ($msg == "Iruxol") {
                        echo "15gm";
                    } elseif ($msg == "Ivypront") {
                        echo "120mg";
                    } elseif ($msg == "Kenacomp") {
                        echo "0";
                    } elseif ($msg == "Ketolac") {
                        echo "30mg/3ml";
                    } elseif ($msg == "Ketolac") {
                        echo "10mg";
                    } elseif ($msg == "Lamifen") {
                        echo "125mg";
                    } elseif ($msg == "Livabion") {
                        echo "2ml";
                    } elseif ($msg == "Maxilaze") {
                        echo "100ml";
                    } elseif ($msg == "Maxrone") {
                        echo "50gm";
                    } elseif ($msg == "Mebo") {
                        echo "15gm";
                    } elseif ($msg == "Megafen") {
                        echo "0";
                    } elseif ($msg == "Milga Advanca") {
                        echo "0";
                    } elseif ($msg == "Milga") {
                        echo "0";
                    } elseif ($msg == "Muco") {
                        echo "15mg/5ml";
                    } elseif ($msg == "Muco SR") {
                        echo "75mg";
                    } elseif ($msg == "Mucosol") {
                        echo "375mg";
                    } elseif ($msg == "Mucosta") {
                        echo "100mg";
                    } elseif ($msg == "Mucotec") {
                        echo "300mg";
                    } elseif ($msg == "Myofen") {
                        echo "0";
                    } elseif ($msg == "Napizole 20 40") {
                        echo "20mg";
                    } elseif ($msg == "Nexicure 40") {
                        echo "20mg";
                    } elseif ($msg == "Olfen 100SR") {
                        echo "100mg";
                    } elseif ($msg == "Olpen 75") {
                        echo "75mg";
                    } elseif ($msg == "Omega 3 plus") {
                        echo "0";
                    } elseif ($msg == "omez 20 40") {
                        echo "20mg";
                    } elseif ($msg == "Oplex") {
                        echo "125mg";
                    } elseif ($msg == "Optidex") {
                        echo "5ml";
                    } elseif ($msg == "Otal") {
                        echo "5ml";
                    } elseif ($msg == "Otrivin child adult baby") {
                        echo "5ml";
                    } elseif ($msg == "Oxymet child adult") {
                        echo "5ml";
                    } elseif ($msg == "Panadol Extra") {
                        echo "0";
                    } elseif ($msg == "Panadol") {
                        echo "0";
                    } elseif ($msg == "Paramol") {
                        echo "500mg";
                    } elseif ($msg == "Plavix") {
                        echo "75mg";
                    } elseif ($msg == "Polyfresh") {
                        echo "10ml";
                    } elseif ($msg == "Predsol") {
                        echo "5mg/5ml";
                    } elseif ($msg == "Relaxon") {
                        echo "0";
                    } elseif ($msg == "Salpovent") {
                        echo "2mg/5ml";
                    } elseif ($msg == "Selgon") {
                        echo "20mg";
                    } elseif ($msg == "Spasmofree") {
                        echo "5mg/2ml";
                    } elseif ($msg == "Stugron") {
                        echo "25mg";
                    } elseif ($msg == "Tavacin 500mg") {
                        echo "500mg";
                    } elseif ($msg == "Telfast") {
                        echo "30mg/5ml";
                    } elseif ($msg == "Telfast") {
                        echo "120mg";
                    } elseif ($msg == "Trental 400SR") {
                        echo "400mg";
                    } elseif ($msg == "Vantomor") {
                        echo "50mg";
                    } elseif ($msg == "Vastarel MR") {
                        echo "35mg";
                    } elseif ($msg == "Vitamount") {
                        echo "0";
                    } elseif ($msg == "Voltaren") {
                        echo "75mg/3ml";
                    } elseif ($msg == "Voltaren") {
                        echo "100gm";
                    } elseif ($msg == "Voltaren 100SR") {
                        echo "100mg";
                    } elseif ($msg == "Zinctron") {
                        echo "0";
                    } elseif ($msg == "Zorcal 20 40") {
                        echo "20mg";
                    } elseif ($msg == "Zylorec 300") {
                        echo "100mg";
                    } elseif ($msg == "Zyrtec") {
                        echo "100ml";
                    } elseif ($msg == "Zyrtec") {
                        echo "10mg";
                    } ?>">
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">سعر المنتج الواحد</label>
                    <input type="text" name="price" class="form-control" id="some" value="<?php
                    if ($msg == "One Two Three") {
                        echo "24 ";
                    } elseif ($msg == "One Two Three") {
                        echo "19.5 ";
                    } elseif ($msg == "Abimol") {
                        echo "13 ";
                    } elseif ($msg == "Abimol Extra") {
                        echo "21 ";
                    } elseif ($msg == "Adol Extra") {
                        echo "22 ";
                    } elseif ($msg == "Adwiflam") {
                        echo "36 ";

                    } elseif ($msg == "Aggrex 75") {
                        echo "33 ";
                    } elseif ($msg == "All Vent") {
                        echo "22 ";
                    } elseif ($msg == "Alphintern") {
                        echo "36 ";

                    } elseif ($msg == "Amaryl") {
                        echo "26.5 ";
                    } elseif ($msg == "Ambizem") {
                        echo "64.5 ";
                    } elseif ($msg == "Anticox") {
                        echo "54.5 ";
                    } elseif ($msg == "Antinal") {
                        echo "36 ";
                    } elseif ($msg == "antodin") {
                        echo "56 ";
                    } elseif ($msg == "Apidone") {
                        echo "15 ";
                    } elseif ($msg == "Aspocid") {
                        echo "21 ";
                    } elseif ($msg == "Betaderm") {
                        echo "15 ";
                    } elseif ($msg == "Biovit") {
                        echo "19 ";
                    } elseif ($msg == "brufen400 tab") {
                        echo "51 ";
                    } elseif ($msg == "Brufen") {
                        echo "24 ";
                    } elseif ($msg == "Calcimate") {
                        echo "20 ";
                    } elseif ($msg == "Cataflam") {
                        echo "83 ";
                    } elseif ($msg == "Cataflam") {
                        echo "62 ";
                    } elseif ($msg == "Ceporex 1g 500mg") {
                        echo "54 ";
                    } elseif ($msg == "Cetal syrp") {
                        echo "21 ";
                    } elseif ($msg == "Cipro") {
                        echo "36 ";
                    } elseif ($msg == "Ciprocin 500") {
                        echo "53 ";
                    } elseif ($msg == "Ciprofar 500") {
                        echo "47 ";
                    } elseif ($msg == "Cold Free") {
                        echo "31 ";
                    } elseif ($msg == "Concor") {
                        echo "51 ";
                    } elseif ($msg == "Congestal") {
                        echo "31 ";
                    } elseif ($msg == "Controloc") {
                        echo "130 ";
                    } elseif ($msg == "Curam 1g 625mg") {
                        echo "21 ";
                    } elseif ($msg == "Daflon") {
                        echo "128 ";
                    } elseif ($msg == "Declophen") {
                        echo "22.5 ";
                    } elseif ($msg == "Depovit") {
                        echo "57.5 ";
                    } elseif ($msg == "Dexamethazone") {
                        echo "45 ";
                    } elseif ($msg == "Digenorm") {
                        echo "25 ";
                    } elseif ($msg == "Digestin") {
                        echo "21 ";
                    } elseif ($msg == "Dolipran") {
                        echo "28.5 ";
                    } elseif ($msg == "Dorofen") {
                        echo "115.5 ";
                    } elseif ($msg == "Edemex") {
                        echo "18 ";
                    } elseif ($msg == "Erastapex") {
                        echo "52.5 ";
                    } elseif ($msg == "Ezapril-co") {
                        echo "51 ";
                    } elseif ($msg == "Ezapril") {
                        echo "25 ";
                    } elseif ($msg == "Feroglobin") {
                        echo "100 ";
                    } elseif ($msg == "Flagyl") {
                        echo "11.25 ";
                    } elseif ($msg == "Flector") {
                        echo "57 ";
                    } elseif ($msg == "Flepton") {
                        echo "34.5 ";
                    } elseif ($msg == "Flumox 500mg 1g") {
                        echo "49  63 ";
                    } elseif ($msg == "Flurest") {
                        echo "20 ";
                    } elseif ($msg == "Fuci") {
                        echo "15 ";
                    } elseif ($msg == "Fucicort") {
                        echo "35 ";
                    } elseif ($msg == "Fucizone") {
                        echo "30 ";
                    } elseif ($msg == "Gast-Reg") {
                        echo "46.5 ";
                    } elseif ($msg == "Glucophage 500") {
                        echo "35 ";
                    } elseif ($msg == "Hibiotec 1g 625mg") {
                        echo "120  71.5 ";
                    } elseif ($msg == "Histazen") {
                        echo "23 ";
                    } elseif ($msg == "Iruxol") {
                        echo "76 ";
                    } elseif ($msg == "Ivypront") {
                        echo "39.5 ";
                    } elseif ($msg == "Ketolac") {
                        echo "24 ";
                    } elseif ($msg == "Ketolac") {
                        echo "40 ";
                    } elseif ($msg == "Lamifen") {
                        echo "75.5 ";
                    } elseif ($msg == "Livabion") {
                        echo "63 ";
                    } elseif ($msg == "Maxilaze") {
                        echo "39.5 ";
                    } elseif ($msg == "Maxrone") {
                        echo "53 ";
                    } elseif ($msg == "Mebo") {
                        echo "73.5 ";
                    } elseif ($msg == "Megafen") {
                        echo "23 ";
                    } elseif ($msg == "Milga Advanca") {
                        echo "100 ";
                    } elseif ($msg == "Milga") {
                        echo "68 ";
                    } elseif ($msg == "Muco") {
                        echo "23.5 ";
                    } elseif ($msg == "Muco SR") {
                        echo "16 ";
                    } elseif ($msg == "Mucosol") {
                        echo "16 ";
                    } elseif ($msg == "Mucosta") {
                        echo "79 ";
                    } elseif ($msg == "Mucotec") {
                        echo "47 ";
                    } elseif ($msg == "Myofen") {
                        echo "34.5 ";
                    } elseif ($msg == "Napizole 20 40") {
                        echo "41.5 ";
                    } elseif ($msg == "Nexicure 40") {
                        echo "103 ";
                    } elseif ($msg == "Olfen 100SR") {
                        echo "23.5 ";
                    } elseif ($msg == "Olpen 75") {
                        echo "40 ";
                    } elseif ($msg == "Omega 3 plus") {
                        echo "99 ";
                    } elseif ($msg == "omez 20 40") {
                        echo "37  88 ";
                    } elseif ($msg == "Oplex") {
                        echo "19 ";
                    } elseif ($msg == "Optidex") {
                        echo "33.5 ";
                    } elseif ($msg == "Otal") {
                        echo "13 ";
                    } elseif ($msg == "Otrivin child adult baby") {
                        echo "16  16  13 ";
                    } elseif ($msg == "Oxymet child adult") {
                        echo "8.5 ";
                    } elseif ($msg == "Panadol Extra") {
                        echo "34 ";
                    } elseif ($msg == "Panadol") {
                        echo "31 ";
                    } elseif ($msg == "Paramol") {
                        echo "25 ";
                    } elseif ($msg == "Plavix") {
                        echo "236 ";
                    } elseif ($msg == "Polyfresh") {
                        echo "47 ";
                    } elseif ($msg == "Predsol") {
                        echo "20.5 ";
                    } elseif ($msg == "Relaxon") {
                        echo "40.5 ";
                    } elseif ($msg == "Salpovent") {
                        echo "16.5 ";
                    } elseif ($msg == "Selgon") {
                        echo "18 ";
                    } elseif ($msg == "Spasmofree") {
                        echo "37.5 ";
                    } elseif ($msg == "Stugron") {
                        echo "34.5 ";
                    } elseif ($msg == "Tavacin 500mg") {
                        echo "63,5 ";
                    } elseif ($msg == "Telfast") {
                        echo "76 ";
                    } elseif ($msg == "Telfast") {
                        echo "32 ";
                    } elseif ($msg == "Trental 400SR") {
                        echo "33.5 ";
                    } elseif ($msg == "Vantomor") {
                        echo "34 ";
                    } elseif ($msg == "Vastarel MR") {
                        echo "112.5 ";
                    } elseif ($msg == "Vitamount") {
                        echo "40.5 ";
                    } elseif ($msg == "Voltaren") {
                        echo "66 ";
                    } elseif ($msg == "Voltaren") {
                        echo "11.5 ";
                    } elseif ($msg == "Voltaren 100SR") {
                        echo "91 ";
                    } elseif ($msg == "Zinctron") {
                        echo "90 ";
                    } elseif ($msg == "Zorcal 20 40") {
                        echo "55  66 ";
                    } elseif ($msg == "Zylorec 300") {
                        echo "39.5 ";
                    } elseif ($msg == "Zyrtec") {
                        echo "32 ";
                    } elseif ($msg == "Zyrtec") {
                        echo "65 ";
                    } ?>" placeholder="L.E">
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">اسم المستورد</label>
                    <input type="text" name="supplier" class="form-control" id="some">
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">الشركة المصنعه للدواء</label>
                    <input type="text" name="company" class="form-control" id="some" value="<?php
                    if ($msg !== "") {
                        $x = array("ابن سيناء", "الشركه المتحده للصيادله", "شركه فارما");
                        $z = array_rand($x);
                        $y = $x[$z];
                        echo $y;
                    }

                    ?>">
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">اختار تصنيف الدواء
                    </label>
                    <select class="form-control" required name="catId">
                        <option selected disabled value="" style="color: #03954C;">الرجاء قم باختيار تصنيف الدواء
                        </option>
                        <?php getAllCat(); ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">العدد</label>
                    <input type="number" name="num" class="form-control" id="some">
                </div>
                <div class="form-group">
                    <label for="some" class="col-form-label" style="color: #03954C;">وصف العلاج</label>
                    <textarea class="form-control" name="discription" placeholder="قم بكتابة وصف حول الدواء"></textarea>
                </div>
                <div class="center">
                    <br>
                    <button type="submit" name="saveProduct" class="btn btn-primary" style="width: 100px;">حفظ</button>
                    <a href="index.php"><button class="btn btn-success" style="width: 100px;">الغاء</button></a>
                </div>
            </form>
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
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
