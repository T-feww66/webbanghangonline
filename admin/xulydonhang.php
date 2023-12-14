<?php
    include_once('../db/connect.php');
?>

    <?php 
    // cập nhật đơn hàng dựa vào mã hàng
        if(isset($_POST['capnhatdonhang'])) {
            $xuly = $_POST['xuly'];
            $mahang = $_POST['mahang_xuly'];
            $sql_update = mysqli_query($con, "UPDATE tbl_order SET order_status = '$xuly'
                        WHERE mahang = '$mahang'");
        }

        if(isset($_GET['xoa'])) {
            $mahang_xoa = $_GET['xoa'];
            $delete_order = mysqli_query($con,"DELETE FROM tbl_order WHERE mahang = '$mahang_xoa'");
        }
        // header('Location: xulydonhang.php');
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="xulydonhang.php">Đơn hàng <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
            </li>
            <li class="nav-item">                
                <a class="nav-link" href="xulykhachhang.php">Khách hàng</a>
            </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">
            <?php
                if(isset($_GET['quanly']) == 'xemdonhang') {
                    $mahang = $_GET['mahang'];
            ?>
            <h4 class="col-md-8">Chi Tiết Đơn Hàng</h4>
            <div>
                <form action="" method="post">
                    <table class="table table-reponsive table-bordered table-triped">
                            <tr>
                                <th>Thứ Tự</th>
                                <th>Mã hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt hàng</th>
                                <th>Ghi chú</th>
                                <!-- <th>Quản lý</th> -->
                            </tr>
                        <?php 
                            $sql_chitiet = mysqli_query($con,"SELECT * FROM tbl_order, tbl_product, tbl_customer
                            WHERE tbl_product.pro_id = tbl_order.pro_id AND
                            tbl_order.cus_id = tbl_customer.cus_id AND tbl_order.mahang = '$mahang'
                            ORDER BY tbl_order.order_id DESC");
                            $i = 0;
                            while($row_chitiet = mysqli_fetch_array($sql_chitiet)) {
                                $i++;
                        ?>  
                            <tbody>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $row_chitiet['mahang']?></td>
                                    <td><?php echo $row_chitiet['pro_name']?></td>
                                    <td><?php echo $row_chitiet['soluong']?></td>
                                    <td><?php echo $row_chitiet['soluong']* $row_chitiet['pro_price']?> VND</td>
                                    <td><?php echo $row_chitiet['order_ngaydathang']?></td>
                                    <td><?php echo $row_chitiet['note']?></td>
                                    <input type="hidden" name="mahang_xuly" value="<?php echo $row_chitiet['mahang']?>">
                                    <!-- <td><a href="?xoa=<?php echo $row_chitiet['order_id']?>">Xoá</a> || <a href="?quanly=xemdonhang&mahang=<?php echo $row_select_order['mahang']?>">Xen đơn hàng</a></td> -->
                                </tr>
                            </tbody>
                        <?php 
                            }
                        ?>
                    </table>
                    <select class="form-control" name="xuly">
                        <option value="0">Chưa xử lý</option>
                        <option value="1">Đã xử lý</option>
                    </select><br>
                    <input type="submit" value="Cập nhật tình trạng đơn hàng" name="capnhatdonhang" class="btn btn-success">
                </form><br>
            </div>
            <?php
                }
            ?>
            
            <div class="col-md-8">
                <h4>Liệt kê đơn hàng</h4>
                <table class="table table-reponsive table-bordered table-triped">
                    <tr>
                        <th>Thứ Tự</th>
                        <th>Mã hàng</th>
                        <th>Tình trạng đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Quản lý</th>
                    </tr>
                <?php 
                    $sql_select_order = mysqli_query($con, "SELECT * FROM tbl_product, tbl_customer, tbl_order
                    WHERE tbl_order.pro_id = tbl_product.pro_id and tbl_order.cus_id = tbl_customer.cus_id
                    GROUP BY tbl_order.mahang
                    ORDER BY tbl_order.order_id DESC");
                    $i = 0;
                    while($row_select_order = mysqli_fetch_array($sql_select_order)) {
                        $i++;
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $row_select_order['mahang']?></td>
                            <td><?php 
                                if($row_select_order['order_status'] == 0) {
                                    echo "Chưa xử lý";
                                }else {
                                    echo "Đã xử lý";
                                }
                            ?></td>
                            <td><?php echo $row_select_order['name']?></td>
                            <td><?php echo $row_select_order['order_ngaydathang']?></td>
                            <td><a href="?xoa=<?php echo $row_select_order['mahang']?>">Xoá</a> || <a href="?quanly=xemdonhang&mahang=<?php echo $row_select_order['mahang']?>">Xen đơn hàng</a></td>
                        </tr>
                    </tbody>
                <?php 
                    }
                ?>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>