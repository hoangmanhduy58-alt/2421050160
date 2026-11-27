<?php
include_once __DIR__ . '/conmect.php';

// Lưu poster hoặc trailer, trả về đường dẫn và thông báo lỗi nếu có
if (!function_exists('luuFilePhim')) {
    function luuFilePhim($file, $thuMuc, $duoiChoPhep, $thongBaoSaiDinhDang)
    {
        // Không có file thì bỏ qua, không tính là lỗi
        if (!isset($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['duongDan' => null, 'loi' => null];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['duongDan' => null, 'loi' => 'Không tải được file. File có thể quá lớn.'];
        }
        // Chỉ nhận đúng các đuôi file được truyền vào
        $duoi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($duoi, $duoiChoPhep, true)) {
            return ['duongDan' => null, 'loi' => $thongBaoSaiDinhDang];
        }
        $thuMucDayDu = __DIR__ . '/' . $thuMuc;
        if (!is_dir($thuMucDayDu)) {
            mkdir($thuMucDayDu, 0777, true);
        }
        // Đổi tên file để tránh trùng với file đã có
        $tenMoi = uniqid('phim_', true) . '.' . $duoi;
        if (!move_uploaded_file($file['tmp_name'], $thuMucDayDu . '/' . $tenMoi)) {
            return ['duongDan' => null, 'loi' => 'Không lưu được file.'];
        }
        return ['duongDan' => $thuMuc . '/' . $tenMoi, 'loi' => null];
    }
}

// Xóa file đã lưu khi thêm phim thất bại
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
// Lấy danh sách đạo diễn và thể loại để đổ vào ô chọn
$daoDiens = mysqli_query($conn, "SELECT id, ho_ten FROM dao_dien ORDER BY ho_ten");
$theLoais = mysqli_query($conn, "SELECT id, ten_the_loai FROM the_loai ORDER BY ten_the_loai");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Khung form thêm phim */
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
        .i-text input[type="file"]{
            margin-top: 4px;
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
    <h1>Thêm phim</h1>
    <!-- enctype bắt buộc vì form có gửi file poster và trailer -->
    <form class="khoi" action="index.php?page=themphim" method="POST" enctype="multipart/form-data">
        <div class="i-text">
            <input type="text" name="tenPhim" placeholder="Tên phim">
        </div>
        <div class="i-text">
            <input type="text" name="quocGia" placeholder="Quốc gia">
        </div>
        <!-- Đạo diễn lấy từ bảng dao_dien, lưu sau qua bảng nối phim_dao_dien -->
        <div class="i-text">
            <!-- select: hộp chọn một mục. name là tên PHP nhận giá trị -->
            <select name="daoDienId">
                <!-- option: một lựa chọn. value là giá trị gửi đi, chữ bên trong là chữ hiện ra -->
                <option value="">Đạo diễn</option>
                <?php
                if ($daoDiens) {
                    while ($daoDien = mysqli_fetch_assoc($daoDiens)) {
                        echo "<option value='" . htmlspecialchars($daoDien['id']) . "'>" . htmlspecialchars($daoDien['ho_ten']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <!-- Thể loại lấy từ bảng the_loai, lưu sau qua bảng nối phim_the_loai -->
        <div class="i-text">
            <select name="theLoaiId">
                <option value="">Thể loại</option>
                <?php
                if ($theLoais) {
                    while ($theLoai = mysqli_fetch_assoc($theLoais)) {
                        echo "<option value='" . htmlspecialchars($theLoai['id']) . "'>" . htmlspecialchars($theLoai['ten_the_loai']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="i-text">
            <!-- type="number": ô chỉ nhập số -->
            <input type="number" name="nam" placeholder="Năm sản xuất">
        </div>
        <div class="i-text">
            <input type="number" name="doTuoi" placeholder="Độ tuổi">
        </div>
        <div class="i-text">
            <!-- textarea: ô nhập nhiều dòng -->
            <textarea name="moTa" placeholder="Mô tả"></textarea>
        </div>
        <div class="i-text">
            <!-- label: nhãn của ô nhập. for trùng id thì bấm vào chữ sẽ focus vào ô đó -->
            <label for="poster">Poster phim</label>
            <!-- type="file": ô chọn file. accept giới hạn loại file được chọn -->
            <input type="file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp,image/gif">
        </div>
        <div class="i-text">
            <label for="trailer">Trailer phim</label>
            <input type="file" id="trailer" name="trailer" accept="video/mp4,video/webm,video/quicktime">
        </div>
        <button>Thêm</button>
    </form>

    <?php
        // Chỉ xử lý khi form đã được gửi
        if(isset($_POST['tenPhim']))
        {
            $tenPhim = $_POST['tenPhim'];
            $quocGia = $_POST['quocGia'] ?? '';
            $daoDienId = $_POST['daoDienId'] ?? '';
            $theLoaiId = $_POST['theLoaiId'] ?? '';
            $nam = $_POST['nam'] ?? '';
            $doTuoi = $_POST['doTuoi'] ?? '';
            $moTa = $_POST['moTa'] ?? '';
            if(!empty($tenPhim)){
                // Ô bỏ trống được lưu thành NULL
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
                // File không hợp lệ thì xóa file vừa lưu và báo lỗi
                if ($poster['loi'] || $trailer['loi']) {
                    xoaFileDaLuu($poster['duongDan']);
                    xoaFileDaLuu($trailer['duongDan']);
                    echo "<p style='color: red'>" . htmlspecialchars($poster['loi'] ?: $trailer['loi']) . "</p>";
                } else {
                    $posterPath = $poster['duongDan'];
                    $trailerPath = $trailer['duongDan'];
                    // Ghi thông tin chính của phim
                    $sql = "INSERT INTO phim (ten_phim, quoc_gia, nam, do_tuoi, mo_ta, poster, trailer) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param('sssssss', $tenPhim, $quocGia, $nam, $doTuoi, $moTa, $posterPath, $trailerPath);
                        if ($stmt->execute()) {
                            $phimId = $stmt->insert_id;
                            $stmt->close();
                            // Gắn đạo diễn qua bảng nối, giống cách gắn thể loại
                            if ($daoDienId !== '') {
                                $stmtDaoDien = $conn->prepare("INSERT INTO phim_dao_dien (phim_id, dao_dien_id) VALUES (?, ?)");
                                if ($stmtDaoDien) {
                                    $stmtDaoDien->bind_param('ii', $phimId, $daoDienId);
                                    $stmtDaoDien->execute();
                                    $stmtDaoDien->close();
                                }
                            }
                            // Gắn thể loại qua bảng nối phim_the_loai
                            if ($theLoaiId !== '') {
                                $stmtTheLoai = $conn->prepare("INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)");
                                if ($stmtTheLoai) {
                                    $stmtTheLoai->bind_param('ii', $phimId, $theLoaiId);
                                    $stmtTheLoai->execute();
                                    $stmtTheLoai->close();
                                }
                            }
                            // script: đoạn JavaScript. Ở đây dùng để chuyển sang trang danh sách phim
                            echo "<script>window.location.href='index.php?page=phim';</script>";
                        } else {
                            $stmt->close();
                            xoaFileDaLuu($posterPath);
                            xoaFileDaLuu($trailerPath);
                            echo "<p style='color: red'>Không thêm được phim</p>";
                        }
                    } else {
                        xoaFileDaLuu($posterPath);
                        xoaFileDaLuu($trailerPath);
                        echo "<p style='color: red'>Không thêm được phim</p>";
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
