<?php
// Mở session và chặn người chưa đăng nhập
session_start();
include_once 'conmect.php';
if (!isset($_SESSION['tendangnhap']) || $_SESSION['tendangnhap'] != "thành công") {
    header("Location: dangnhap.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Menu ngang trên đầu trang */
        ul {
            list-style: none;
            display: flex;
            gap: 10px;
            background-color: #333;
            padding: 0px;
            border-radius: 20px;
        }
        
       a {
        text-decoration: none;
        color: #fff;
       }
    </style>
</head>
<body>
    <?php
    // Kiểm tra lại session trước khi hiện nội dung
    if (isset($_SESSION['tendangnhap']) && $_SESSION['tendangnhap'] == "thành công") {
        echo "Xin chào " . $_SESSION['tendangnhap'];
    } else {
        header("Location: dangnhap.php");
        exit;
    }
    ?>
    <!-- Các mục chính của trang quản trị -->
    <!-- header: vùng đầu trang -->
    <header>
        <!-- nav: khối menu điều hướng -->
        <nav>
            <!-- ul: danh sách không đánh số. li: một mục trong danh sách -->
            <ul>
                <!-- a: liên kết. href là địa chỉ mở ra khi bấm -->
                <li><a href="index.php?page=trangadmin">Trang admin</a></li>
                <li><a href="index.php?page=taikhoan">Tài khoản</a></li>
                <li><a href="index.php?page=danhmuc">Danh mục</a></li>
                <li><a href="index.php?page=phim">phim</a></li>
            </ul>
        </nav>
    </header>
    <?php
    // Tham số page quyết định file được nhúng vào trang
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch ($page) {
            case 'trangadmin':
                include 'trangadmin.php';
                break;
            case 'taikhoan':
                include 'taikhoan.php';
                break;
            case 'danhmuc':
                include 'danhmuc.php';
                break;
            case 'phim':
                include 'phim.php';
                break;
            case 'themtaikhoan':
                include 'themtaikhoan.php';
                break;
            case 'suataikhoan':
                include 'suataikhoan.php';
                break;
            case 'xoataikhoan':
                include 'xoataikhoan.php';
                break;
            case 'themdanhmuc':
                include 'themdanhmuc.php';
                break;
            case 'suadanhmuc':
                include 'suadanhmuc.php';
                break;
            case 'xoadanhmuc':
                include 'xoadanhmuc.php';
                break;
            case 'themphim':
                include 'themphim.php';
                break;
            case 'suaphim':
                include 'suaphim.php';
                break;
            case 'xoaphim':
                include 'xoaphim.php';
                break;
        }
    }
    ?>
</body>
</html>
