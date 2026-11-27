<?php
// Máy chủ, tài khoản và tên database dùng để kết nối MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netflix";

// Tạo kết nối tới database
$conn = new mysqli($servername, $username, $password, $dbname);

// Dừng chương trình nếu không kết nối được.
// Trang xem phim định nghĩa CHO_PHEP_LOI_KET_NOI để tự hiện giao diện dự phòng.
if ($conn->connect_error && !defined('CHO_PHEP_LOI_KET_NOI')) {
  die("Connection failed: " . $conn->connect_error);
}
// Dùng utf8mb4 để đọc và ghi tiếng Việt có dấu
if (!$conn->connect_error) {
  $conn->set_charset("utf8mb4");
}
?>
