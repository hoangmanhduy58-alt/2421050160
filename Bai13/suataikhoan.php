<?php
include_once __DIR__ . '/conmect.php';
// Lấy tài khoản cần sửa theo id trên đường dẫn
$id = $_GET['id'] ?? '';
$taiKhoan = null;
if ($id !== '') {
    $stmt = $conn->prepare('SELECT id, ten_dang_nhap, mat_khau, email, ho_ten, ngay_sinh, so_dien_thoai, gioi_tinh FROM nguoidung WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $taiKhoan = $result ? $result->fetch_assoc() : null;
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
        }
        form{
            padding: 10px;
        }
        h1{
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Cập nhật tài khoản</h1>
    <?php if ($taiKhoan) { ?>
    <!-- Ô mật khẩu để trống nghĩa là giữ mật khẩu cũ -->
    <form class="khoi" action="index.php?page=suataikhoan&id=<?php echo htmlspecialchars($taiKhoan['id']); ?>" method="POST">
        <div class="i-text">
            <input type="text" name="tenDangNhap" value="<?php echo htmlspecialchars($taiKhoan['ten_dang_nhap']); ?>" placeholder="Tên đăng nhập">
        </div>
        <div class="i-text">
            <input type="password" name="matKhau" placeholder="Mật khẩu, bỏ trống nếu giữ nguyên">
        </div>
        <div class="i-text">
            <input type="email" name="email" value="<?php echo htmlspecialchars($taiKhoan['email']); ?>" placeholder="Email">
        </div>
        <div class="i-text">
            <input type="text" name="hoten" value="<?php echo htmlspecialchars($taiKhoan['ho_ten'] ?? ''); ?>" placeholder="Họ và tên">
        </div>
        <div class="i-text">
            <input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($taiKhoan['ngay_sinh'] ?? ''); ?>" placeholder="Ngày sinh">
        </div>
        <div class="i-text">
            <input type="text" name="sdt" value="<?php echo htmlspecialchars($taiKhoan['so_dien_thoai'] ?? ''); ?>" placeholder="Số điện thoại">
        </div>
        <div class="">
            <input type="radio" name="gioitinh" value="0" <?php echo ($taiKhoan['gioi_tinh'] === '0' || $taiKhoan['gioi_tinh'] === 0) ? 'checked' : ''; ?>> Nam
            <input type="radio" name="gioitinh" value="1" <?php echo ($taiKhoan['gioi_tinh'] === '1' || $taiKhoan['gioi_tinh'] === 1) ? 'checked' : ''; ?>> Nữ
        </div>
        <button>Cập nhật</button>
    </form>
    <?php } else { ?>
        <p style="color: red">Không tìm thấy tài khoản</p>
    <?php } ?>

    <?php
        // Cập nhật khi form gửi đủ trường và tài khoản vẫn tồn tại
        if(isset($_POST['tenDangNhap']) &&
           isset($_POST['email']) &&
           isset($_POST['hoten']) &&
           isset($_POST['ngaysinh']) &&
           isset($_POST['sdt']) &&
           isset($_POST['gioitinh']) &&
           $taiKhoan)
        {
            $tenDangNhap = $_POST['tenDangNhap'];
            $matKhau = $_POST['matKhau'] ?? '';
            $email = $_POST['email'];
            $hoten = $_POST['hoten'];
            $ngaysinh = $_POST['ngaysinh'];
            $sdt = $_POST['sdt'];
            $gioitinh = $_POST['gioitinh'];
            // Không nhập mật khẩu mới thì dùng lại mật khẩu đang lưu
            if ($matKhau === '') {
                $matKhau = $taiKhoan['mat_khau'];
            }
            if(!empty($tenDangNhap) &&
                !empty($matKhau) &&
                !empty($email) &&
                !empty($hoten) &&
                !empty($ngaysinh) &&
                !empty($sdt) &&
                (!empty($gioitinh) || $gioitinh === '0')){
                $sql = "UPDATE nguoidung SET ten_dang_nhap = ?, mat_khau = ?, email = ?, ho_ten = ?, ngay_sinh = ?, so_dien_thoai = ?, gioi_tinh = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('sssssssi', $tenDangNhap, $matKhau, $email, $hoten, $ngaysinh, $sdt, $gioitinh, $id);
                    if ($stmt->execute()) {
                        $stmt->close();
                        echo "<script>window.location.href='index.php?page=taikhoan';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không cập nhật được tài khoản</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không cập nhật được tài khoản</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
