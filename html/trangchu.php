<?php
    include_once('../db/connect.php');
?>

<?php
    session_start();
    if(!isset($_SESSION['name'])) {
        header('Location: index.php');
    }

    if(isset($_GET['login'])) {
        $dangxuat = $_GET['login'];
    }else {
        $dangxuat = '';
    }

    
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
        <title>Web Ban hang | TFeww</title>
    </head>
    <body>
    <?php 
        if($dangxuat == 'dangxuat') {
            $sql_delete = mysqli_query($con, "DELETE FROM tbl_cart");
            header('Location: index.php');
        }
    ?>
    <?php
        include('../include/header.php');
        if(isset($_GET['quanly']) =='giohang') { 
            include('../include/cart.php');
        }else {
           include('../include/slider.php');
        }
        include('../include/footer.php');
    ?>
        <script>
            // -----------------SLIDER-----------------
            let list = document.querySelector(".slider .list");
            let items = document.querySelectorAll(".slider .list .slider-item");
            let dots = document.querySelectorAll(".slider .dots li");
            let prev = document.getElementById("prev");
            let next = document.getElementById("next");

            let active = 0;
            let lenghtItems = items.length - 1;
            // next
            next.onclick = function () {
                if (active + 1 > lenghtItems) {
                    active = 0;
                } else {
                    active += 1;
                }
                reloadeSlider();
            };

            // prev
            prev.onclick = function () {
                if (active - 1 < 0) {
                    active = lenghtItems;
                } else {
                    active -= 1;
                }
                reloadeSlider();
            };

            let refreshSlider = setInterval(() => {
                next.click();
            }, 3000);
            function reloadeSlider() {
                let checkLeft = items[active].offsetLeft;
                list.style.left = -checkLeft + "px";

                let lastActiveDot = document.querySelector(
                    ".slider .dots li.active"
                );
                lastActiveDot.classList.remove("active");
                dots[active].classList.add("active");
                clearInterval(refreshSlider);
                refreshSlider = setInterval(() => {
                    next.click();
                }, 3000);
            }

            // key la vi tri tuong ung cua the li do
            dots.forEach((li, key) => {
                li.addEventListener("click", function () {
                    active = key;
                    reloadeSlider();
                });
            });
        </script>
    </body>
</html>
