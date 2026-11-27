<?php
include_once __DIR__ . '/conmect.php';

// Chỉ xóa file nằm trong thư mục uploads, tránh xóa file ngoài dự án
if (!function_exists('xoaFileDaLuu')) {
    function xoaFileDaLuu($duongDan)
    {
        if (!$duongDan || str_contains($duongDan, '..') || !str_starts_with($duongDan, 'uploads/')) {
            return;
        }
        $dayDu = __DIR__ . '/' . $duongDan;
        if (is_file($dayDu)) {
            unlink($dayDu);
        }
    }
}

// Lấy id phim từ đường dẫn, bỏ qua nếu không có id
$id = $_GET['id'] ?? '';
if ($id !== '') {
    // Lấy đường dẫn poster và trailer trước khi xóa dòng trong database
    $stmtLayFile = $conn->prepare('SELECT poster, trailer FROM phim WHERE id = ?');
    if ($stmtLayFile) {
        $stmtLayFile->bind_param('i', $id);
        $stmtLayFile->execute();
        $ketQua = $stmtLayFile->get_result();
        $phim = $ketQua ? $ketQua->fetch_assoc() : null;
        $stmtLayFile->close();
        if ($phim) {
            xoaFileDaLuu($phim['poster'] ?? '');
            xoaFileDaLuu($phim['trailer'] ?? '');
        }
    }
    // Xóa phim; bảng nối thể loại và đạo diễn tự xóa theo khóa ngoại
    $stmt = $conn->prepare('DELETE FROM phim WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
// Quay lại danh sách phim
echo "<script>window.location.href='index.php?page=phim';</script>";
?>
