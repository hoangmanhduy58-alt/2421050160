<?php
include_once __DIR__ . '/conmect.php';

// Lưu file poster hoặc trailer mới, trả về đường dẫn và lỗi nếu có
if (!function_exists('luuFilePhim')) {
    function luuFilePhim($file, $thuMuc, $duoiChoPhep, $thongBaoSaiDinhDang)
    {
        // Không chọn file mới thì giữ file cũ
        if (!isset($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['duongDan' => null, 'loi' => null];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['duongDan' => null, 'loi' => 'Không tải được file. File có thể quá lớn.'];
        }
        $duoi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($duoi, $duoiChoPhep, true)) {
            return ['duongDan' => null, 'loi' => $thongBaoSaiDinhDang];
        }
        $thuMucDayDu = __DIR__ . '/' . $thuMuc;
        if (!is_dir($thuMucDayDu)) {
            mkdir($thuMucDayDu, 0777, true);
        }
        $tenMoi = uniqid('phim_', true) . '.' . $duoi;
        if (!move_uploaded_file($file['tmp_name'], $thuMucDayDu . '/' . $tenMoi)) {
            return ['duongDan' => null, 'loi' => 'Không lưu được file.'];
        }
        return ['duongDan' => $thuMuc . '/' . $tenMoi, 'loi' => null];
    }
}

// Xóa file cũ sau khi đã lưu file mới thành công
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
// Lấy phim theo id trên đường dẫn
$id = $_GET['id'] ?? '';
$phim = null;
if ($id !== '') {
    $stmt = $conn->prepare('SELECT id, ten_phim, quoc_gia, nam, do_tuoi, mo_ta, poster, trailer FROM phim WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $phim = $result ? $result->fetch_assoc() : null;
        $stmt->close();
    }
}
$daoDiens = mysqli_query($conn, "SELECT id, ho_ten FROM dao_dien ORDER BY ho_ten");
$theLoais = mysqli_query($conn, "SELECT id, ten_the_loai FROM the_loai ORDER BY ten_the_loai");
// Đọc đạo diễn và thể loại đang gắn với phim từ hai bảng nối
$daoDienIdHienTai = '';
$theLoaiIdHienTai = '';
if ($phim) {
    $stmtDaoDien = $conn->prepare('SELECT dao_dien_id FROM phim_dao_dien WHERE phim_id = ? LIMIT 1');
    if ($stmtDaoDien) {
        $stmtDaoDien->bind_param('i', $id);
        $stmtDaoDien->execute();
        $ketQuaDaoDien = $stmtDaoDien->get_result();
        $dongDaoDien = $ketQuaDaoDien ? $ketQuaDaoDien->fetch_assoc() : null;
        $daoDienIdHienTai = $dongDaoDien['dao_dien_id'] ?? '';
        $stmtDaoDien->close();
    }
    $stmtTheLoai = $conn->prepare('SELECT the_loai_id FROM phim_the_loai WHERE phim_id = ? LIMIT 1');
    if ($stmtTheLoai) {
        $stmtTheLoai->bind_param('i', $id);
        $stmtTheLoai->execute();
        $ketQuaTheLoai = $stmtTheLoai->get_result();
        $dongTheLoai = $ketQuaTheLoai ? $ketQuaTheLoai->fetch_assoc() : null;
        $theLoaiIdHienTai = $dongTheLoai['the_loai_id'] ?? '';
        $stmtTheLoai->close();
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
            width: 320px;
            margin: 20vh auto;
            background-color:rgb(18, 243, 224);
        }
        .i-text input, .i-text select, .i-text textarea{
            padding: 5px 0;
            margin: 10px 0;
            width: 100%;
        }
        .i-text label{
            display: block;
            margin-top: 8px;
        }
        /* Ảnh và video đang lưu, hiện phía trên ô chọn file mới */
        .poster-hien-tai{
            width: 100%;
            max-height: 180px;
            object-fit: cover;
        }
        .trailer-hien-tai{
            width: 100%;
            max-height: 180px;
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
    <h1>Cập nhật phim</h1>
    <?php if ($phim) { ?>
    <form class="khoi" action="index.php?page=suaphim&id=<?php echo htmlspecialchars($phim['id']); ?>" method="POST" enctype="multipart/form-data">
        <div class="i-text">
            <input type="text" name="tenPhim" value="<?php echo htmlspecialchars($phim['ten_phim']); ?>" placeholder="Tên phim">
        </div>
        <div class="i-text">
            <input type="text" name="quocGia" value="<?php echo htmlspecialchars($phim['quoc_gia'] ?? ''); ?>" placeholder="Quốc gia">
        </div>
        <!-- Đánh dấu selected cho đạo diễn đang được gắn với phim -->
        <div class="i-text">
            <select name="daoDienId">
                <option value="">Đạo diễn</option>
                <?php
                if ($daoDiens) {
                    while ($daoDien = mysqli_fetch_assoc($daoDiens)) {
                        $selected = ((string) $daoDienIdHienTai === (string) $daoDien['id']) ? ' selected' : '';
                        echo "<option value='" . htmlspecialchars($daoDien['id']) . "'" . $selected . ">" . htmlspecialchars($daoDien['ho_ten']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <!-- Đánh dấu selected cho thể loại đang được gắn với phim -->
        <div class="i-text">
            <select name="theLoaiId">
                <option value="">Thể loại</option>
                <?php
                if ($theLoais) {
                    while ($theLoai = mysqli_fetch_assoc($theLoais)) {
                        $selected = ((string) $theLoaiIdHienTai === (string) $theLoai['id']) ? ' selected' : '';
                        echo "<option value='" . htmlspecialchars($theLoai['id']) . "'" . $selected . ">" . htmlspecialchars($theLoai['ten_the_loai']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="i-text">
            <input type="number" name="nam" value="<?php echo htmlspecialchars($phim['nam'] ?? ''); ?>" placeholder="Năm sản xuất">
        </div>
        <div class="i-text">
            <input type="number" name="doTuoi" value="<?php echo htmlspecialchars($phim['do_tuoi'] ?? ''); ?>" placeholder="Độ tuổi">
        </div>
        <div class="i-text">
            <textarea name="moTa" placeholder="Mô tả"><?php echo htmlspecialchars($phim['mo_ta'] ?? ''); ?></textarea>
        </div>
        <div class="i-text">
            <label for="poster">Poster phim</label>
            <?php if (!empty($phim['poster'])) { ?>
                <!-- img: hiện ảnh. src là đường dẫn ảnh, alt là chữ thay thế khi ảnh không tải được -->
                <img class="poster-hien-tai" src="<?php echo htmlspecialchars($phim['poster']); ?>" alt="Poster hiện tại">
            <?php } ?>
            <input type="file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp,image/gif">
        </div>
        <div class="i-text">
            <label for="trailer">Trailer phim</label>
            <?php if (!empty($phim['trailer'])) { ?>
                <!-- video: trình phát video. src là đường dẫn, controls hiện nút phát và âm lượng -->
                <video class="trailer-hien-tai" src="<?php echo htmlspecialchars($phim['trailer']); ?>" controls></video>
            <?php } ?>
            <input type="file" id="trailer" name="trailer" accept="video/mp4,video/webm,video/quicktime">
        </div>
        <button>Cập nhật</button>
    </form>
    <?php } else { ?>
        <p style="color: red">Không tìm thấy phim</p>
    <?php } ?>

    <?php
        // Chỉ cập nhật khi form gửi lên và phim vẫn tồn tại
        if(isset($_POST['tenPhim']) && $phim)
        {
            $tenPhim = $_POST['tenPhim'];
            $quocGia = $_POST['quocGia'] ?? '';
            $daoDienId = $_POST['daoDienId'] ?? '';
            $theLoaiId = $_POST['theLoaiId'] ?? '';
            $nam = $_POST['nam'] ?? '';
            $doTuoi = $_POST['doTuoi'] ?? '';
            $moTa = $_POST['moTa'] ?? '';
            if(!empty($tenPhim)){
                $quocGia = $quocGia === '' ? null : $quocGia;
                $nam = $nam === '' ? null : $nam;
                $doTuoi = $doTuoi === '' ? null : $doTuoi;
                $moTa = $moTa === '' ? null : $moTa;
                $poster = luuFilePhim(
                    $_FILES['poster'] ?? null,
                    'uploads/poster',
                    ['jpg', 'jpeg', 'png', 'webp', 'gif'],
                    'Poster chỉ nhận file ảnh jpg, png, webp hoặc gif'
                );
                $trailer = luuFilePhim(
                    $_FILES['trailer'] ?? null,
                    'uploads/trailer',
                    ['mp4', 'webm', 'mov'],
                    'Trailer chỉ nhận file video mp4, webm hoặc mov'
                );
                if ($poster['loi'] || $trailer['loi']) {
                    xoaFileDaLuu($poster['duongDan']);
                    xoaFileDaLuu($trailer['duongDan']);
                    echo "<p style='color: red'>" . htmlspecialchars($poster['loi'] ?: $trailer['loi']) . "</p>";
                } else {
                // Không chọn file mới thì giữ đường dẫn file đang có
                $posterPath = $poster['duongDan'] ?? $phim['poster'];
                $trailerPath = $trailer['duongDan'] ?? $phim['trailer'];
                $sql = "UPDATE phim SET ten_phim = ?, quoc_gia = ?, nam = ?, do_tuoi = ?, mo_ta = ?, poster = ?, trailer = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('sssssssi', $tenPhim, $quocGia, $nam, $doTuoi, $moTa, $posterPath, $trailerPath, $id);
                    if ($stmt->execute()) {
                        $stmt->close();
                        // Xóa liên kết đạo diễn cũ rồi ghi lại lựa chọn mới
                        $stmtXoaDaoDien = $conn->prepare('DELETE FROM phim_dao_dien WHERE phim_id = ?');
                        if ($stmtXoaDaoDien) {
                            $stmtXoaDaoDien->bind_param('i', $id);
                            $stmtXoaDaoDien->execute();
                            $stmtXoaDaoDien->close();
                        }
                        if ($daoDienId !== '') {
                            $stmtDaoDien = $conn->prepare('INSERT INTO phim_dao_dien (phim_id, dao_dien_id) VALUES (?, ?)');
                            if ($stmtDaoDien) {
                                $stmtDaoDien->bind_param('ii', $id, $daoDienId);
                                $stmtDaoDien->execute();
                                $stmtDaoDien->close();
                            }
                        }
                        // Xóa liên kết thể loại cũ rồi ghi lại lựa chọn mới
                        $stmtXoaTheLoai = $conn->prepare('DELETE FROM phim_the_loai WHERE phim_id = ?');
                        if ($stmtXoaTheLoai) {
                            $stmtXoaTheLoai->bind_param('i', $id);
                            $stmtXoaTheLoai->execute();
                            $stmtXoaTheLoai->close();
                        }
                        if ($theLoaiId !== '') {
                            $stmtTheLoai = $conn->prepare('INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)');
                            if ($stmtTheLoai) {
                                $stmtTheLoai->bind_param('ii', $id, $theLoaiId);
                                $stmtTheLoai->execute();
                                $stmtTheLoai->close();
                            }
                        }
                        // Có file mới thì xóa file cũ khỏi thư mục uploads
                        if ($poster['duongDan']) {
                            xoaFileDaLuu($phim['poster'] ?? '');
                        }
                        if ($trailer['duongDan']) {
                            xoaFileDaLuu($phim['trailer'] ?? '');
                        }
                        echo "<script>window.location.href='index.php?page=phim';</script>";
                    } else {
                        $stmt->close();
                        xoaFileDaLuu($poster['duongDan']);
                        xoaFileDaLuu($trailer['duongDan']);
                        echo "<p style='color: red'>Không cập nhật được phim</p>";
                    }
                } else {
                    xoaFileDaLuu($poster['duongDan']);
                    xoaFileDaLuu($trailer['duongDan']);
                    echo "<p style='color: red'>Không cập nhật được phim</p>";
                }
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
