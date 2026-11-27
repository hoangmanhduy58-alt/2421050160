<?php
// Bắt đầu session để lưu trạng thái đăng nhập
session_start();
include 'conmect.php';

// Biến chứa câu báo lỗi, để trống khi chưa gửi form
$thongbao = "";
// Chỉ kiểm tra khi form gửi đủ tên đăng nhập và mật khẩu
if (isset($_POST['tendangnhap']) && isset($_POST['matkhau'])) {
    $tendangnhap = $_POST['tendangnhap'];
    $matkhau = $_POST['matkhau'];
    // Tìm tài khoản khớp cả tên đăng nhập và mật khẩu
    $sql = "SELECT id FROM nguoidung WHERE ten_dang_nhap = ? AND mat_khau = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tendangnhap, $matkhau);
    $stmt->execute();
    $stmt->store_result();
    // Có bản ghi thì đánh dấu đăng nhập thành công và về trang chính
    if ($stmt->num_rows > 0) {
        $_SESSION['tendangnhap'] = "thành công";
        header("Location: index.php");
        exit;
    } else {
        $thongbao = "tên đăng nhập hoặc mật khẩu không đúng";
    }
}
?>
<!-- DOCTYPE html: khai báo trang dùng HTML5 -->
<!DOCTYPE html>
<!-- html: thẻ gốc bao toàn bộ trang. lang là ngôn ngữ của trang -->
<html lang="en">
<!-- head: phần thông tin của trang, không hiện trên màn hình -->
<head>
    <!-- meta charset: bảng mã ký tự, UTF-8 để hiện tiếng Việt -->
    <meta charset="UTF-8">
    <!-- meta viewport: cho trang co theo chiều rộng màn hình -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- title: chữ hiện trên tab trình duyệt -->
    <title>Document</title>
    <!-- style: nơi viết CSS cho trang -->
    <style>
        /* Khung form đăng nhập nằm giữa trang */
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
<!-- body: phần nội dung người dùng nhìn thấy -->
<body>
    <!-- Form gửi tên đăng nhập và mật khẩu về chính file này -->
    <!-- div: khối dùng để nhóm và căn bố cục -->
    <div class="khoi">
        <div style="margin: auto; align-items: center; width: 80%; " class="">
            <!-- h1: tiêu đề chính -->
            <h1>Đăng nhập</h1>
            <div class="">
                <!-- form: nhóm dữ liệu gửi đi. action là trang nhận, method="post" gửi ở dạng ẩn -->
                <form action="dangnhap.php" method="post">
                    <div>
                        <!-- p: một đoạn chữ. b: in đậm phần chữ bên trong -->
                        <p><b>Tên đăng nhập:</b></p>
                        <!-- input: ô nhập. type="text" nhập chữ thường, name là tên PHP lấy trong $_POST, placeholder là chữ gợi ý -->
                        <input type="text" name="tendangnhap" placeholder="Nhập tên đăng nhập">
                    </div>
                    <div>
                        <p><b>Mật khẩu:</b></p>
                        <!-- type="password": ô nhập mật khẩu, ký tự bị che khi gõ -->
                        <input type="password" name="matkhau" placeholder="Nhập mật khẩu">
                    </div>
                    <div>
                        <!-- button type="submit": nút gửi form -->
                        <button type="submit">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    // Hiện thông báo khi đăng nhập sai
    if ($thongbao !== "") {
        echo $thongbao;
    }
    ?>
</body>
</html>
