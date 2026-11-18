<?php
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
    if (isset($_SESSION['tendangnhap']) && $_SESSION['tendangnhap'] == "thành công") {
        echo "Xin chào " . $_SESSION['tendangnhap'];
    } else {
        header("Location: dangnhap.php");
        exit;
    }
    ?>
    <header>
        <nav>
            <ul>
                <li><a href="index.php?page=trangadmin">Trang admin</a></li>
                <li><a href="index.php?page=taikhoan">Tài khoản</a></li>
                <li><a href="index.php?page=danhmuc">Danh mục</a></li>
                <li><a href="index.php?page=phim">phim</a></li>
            </ul>
        </nav>
    </header>
    <?php
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
        }
    }
    ?>
</body>
</html> 