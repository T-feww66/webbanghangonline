<?php
    session_start();
    include_once('../db/connect.php');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/styles.css" />
        <link
            href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
            rel="stylesheet"
        />
        <title>headerigation | TFeww</title>
    </head>
    <body>
        <?php
            if(!isset($_SESSION['name'])) {
                header('Location: index.php');
            }

            if(isset($_GET['login'])) {
                $dangxuat = $_GET['login'];
            }else {
                $dangxuat = '';
            }

            if($dangxuat == 'dangxuat') {
                $sql_delete = mysqli_query($con, "DELETE FROM tbl_cart");
                header('Location: index.php');
            }
        ?>
        <?php
            if(isset($_GET['quanly'])) {
                $tam = $_GET['quanly'];
            }else {
                $tam = '';
            }
            include('../include/header.php');
            if($tam =='chitietsp') { 
               include('../include/chitietproduct.php');
            }elseif($tam=='giohang') {
               include('../include/cart.php');
                
            }elseif($tam == 'timkiem') {
                include('../include/search.php');
            }else {
                include('../include/product.php');
            }
            include('../include/footer.php');
        ?>
    </body>
</html>
