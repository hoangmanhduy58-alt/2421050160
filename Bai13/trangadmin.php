<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Trang admin</h1>
    <?php
    echo "Xin chào " ;
    session_start();
    if($_SESSION['tendangnhap']=="thành công") {
        echo "Xin chào " . $_SESSION['tendangnhap'];
    } else {
        header("Location: dangnhap.php");
    }
    ?>
</body>
</html> 