<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
        .khoi {
           border: 1px solid black;
           border-radius: 10px;
           width: 300px;
           height: 300px;
           margin: 20px auto;
           text-align: center;
           background-color:rgb(137, 174, 255);
        }
        .form-group {
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="khoi">
        <div style="margin: auto; align-items: center; width: 80%; " class="">
            <h1>Đăng nhập</h1>
            <div class="">
                <form action="dangnhap.php" method="post">
                    <div>
                        <p><b>Tên đăng nhập:</b></p>
                        <input type="text" name="tendangnhap" placeholder="Nhập tên đăng nhập">
                    </div>
                    <div>
                        <p><b>Mật khẩu:</b></p>
                        <input type="password" name="matkhau" placeholder="Nhập mật khẩu">
                    </div>
                    <div>
                        <button type="submit">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if(isset($_POST['tendangnhap']) && isset($_POST['matkhau'])) {
        $tendangnhap = $_POST['tendangnhap'];
        $matkhau = $_POST['matkhau'];
        if($tendangnhap == "admin" && $matkhau == "123456") {
            session_start();
            $_SESSION['tendangnhap'] = "thành công";
            header("Location: trangadmin.php");
        } else {
            echo "Đăng nhập thất bại";
        }
    }
    ?>
</body>
</html>