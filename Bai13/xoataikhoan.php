<?php
include_once __DIR__ . '/conmect.php';
// Xóa tài khoản theo id, rồi quay lại danh sách
$id = $_GET['id'] ?? '';
if ($id !== '') {
    $stmt = $conn->prepare('DELETE FROM nguoidung WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
echo "<script>window.location.href='index.php?page=taikhoan';</script>";
?>
