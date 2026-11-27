
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Khung form thêm tài khoản */
        .khoi{
            border: 1px solid black;
            border-radius: 10px;
            width: 250px;
            margin: 20vh auto;
            background-color:rgb(18, 243, 224);
        }
        .i-text input{
            padding: 5px 0;
            margin: 10px 0;
            width: 100%;
        }
        button{
            padding: 5px 0;
            width: 100%;
            background-color:rgb(25, 230, 25);
            color:rgb(240, 33, 33);
        }
        form{
            padding: 10px;
            background-color:rgb(253, 247, 247);
            color:rgb(240, 33, 33);
            border-radius: 10px;
        }
        h1{
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Thêm tài khoản</h1>
    <!-- value 0 là Nam, value 1 là Nữ -->
    <form class="khoi" action="index.php?page=themtaikhoan" method="POST">
        <div class="i-text">
            <input type="text" name="tenDangNhap" id="" placeholder="Tên đăng nhập">
        </div>
        <div class="i-text">
            <input type="password" name="matKhau" id="" placeholder="Mật khẩu">
        </div>
        <div class="i-text">
            <!-- type="email": ô nhập email -->
            <input type="email" name="email" id="" placeholder="Email">
        </div>
        <div class="i-text">
            <input type="text" name="hoten" id="" placeholder="Họ và tên">
        </div>
        <div class="i-text">
            <!-- type="date": ô chọn ngày -->
            <input type="date" name="ngaysinh" id="" placeholder="Ngày sinh">
        </div>
        <div class="i-text">
            <input type="text" name="sdt" id="" placeholder="Số điện thoại">
        </div>
        <div class="">
            <!-- type="radio": chọn một trong các ô cùng name. checked là ô được chọn sẵn -->
            <input type="radio" name="gioitinh" id="" value="0" checked> Nam
            <input type="radio" name="gioitinh" id="" value="1"> Nữ
        </div>
        <button>Thêm</button>
    </form>

    <?php
        include_once __DIR__ . '/conmect.php';
        // Chỉ thêm khi form gửi đủ các trường bắt buộc
        if(isset($_POST['tenDangNhap']) &&
           isset($_POST['matKhau']) &&
           isset($_POST['email']) &&
           isset($_POST['hoten']) &&
           isset($_POST['ngaysinh']) &&
           isset($_POST['sdt']))
        {
            $tenDangNhap = $_POST['tenDangNhap'];
            $matKhau = $_POST['matKhau'];
            $email = $_POST['email'];
            $hoten = $_POST['hoten'];
            $ngaysinh = $_POST['ngaysinh'];
            $sdt = $_POST['sdt'];
            $gioitinh = $_POST['gioitinh'];
            // Giới tính 0 vẫn hợp lệ dù empty() coi chuỗi "0" là rỗng
            if(!empty($tenDangNhap) &&
                !empty($matKhau) &&
                !empty($email) &&
                !empty($hoten) &&
                !empty($ngaysinh) &&
                !empty($sdt) &&
                (!empty($gioitinh) || $gioitinh === '0')){
                $sql = "INSERT INTO nguoidung (ten_dang_nhap, mat_khau, email, ho_ten, ngay_sinh, so_dien_thoai, gioi_tinh) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('sssssss', $tenDangNhap, $matKhau, $email, $hoten, $ngaysinh, $sdt, $gioitinh);
                    if ($stmt->execute()) {
                        $stmt->close();
                        echo "<script>window.location.href='index.php?page=taikhoan';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không thêm được tài khoản</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không thêm được tài khoản</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
