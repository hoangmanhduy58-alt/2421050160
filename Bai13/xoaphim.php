<?php
include_once __DIR__ . '/conmect.php';
$id = $_GET['id'] ?? '';
if ($id !== '') {
    $stmt = $conn->prepare('DELETE FROM phim WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
echo "<script>window.location.href='index.php?page=phim';</script>";
?>
