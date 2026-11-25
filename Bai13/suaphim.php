<?php
include_once __DIR__ . '/conmect.php';
$id = $_GET['id'] ?? '';
$phim = null;
if ($id !== '') {
    $stmt = $conn->prepare('SELECT id, ten_phim, quoc_gia, dao_dien_id, nam, do_tuoi, mo_ta FROM phim WHERE id = ?');
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
$theLoaiIdHienTai = '';
if ($phim) {
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
    <form class="khoi" action="index.php?page=suaphim&id=<?php echo htmlspecialchars($phim['id']); ?>" method="POST">
        <div class="i-text">
            <input type="text" name="tenPhim" value="<?php echo htmlspecialchars($phim['ten_phim']); ?>" placeholder="Tên phim">
        </div>
        <div class="i-text">
            <input type="text" name="quocGia" value="<?php echo htmlspecialchars($phim['quoc_gia'] ?? ''); ?>" placeholder="Quốc gia">
        </div>
        <div class="i-text">
            <select name="daoDienId">
                <option value="">Đạo diễn</option>
                <?php
                if ($daoDiens) {
                    while ($daoDien = mysqli_fetch_assoc($daoDiens)) {
                        $selected = ((string) $phim['dao_dien_id'] === (string) $daoDien['id']) ? ' selected' : '';
                        echo "<option value='" . htmlspecialchars($daoDien['id']) . "'" . $selected . ">" . htmlspecialchars($daoDien['ho_ten']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
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
        <button>Cập nhật</button>
    </form>
    <?php } else { ?>
        <p style="color: red">Không tìm thấy phim</p>
    <?php } ?>

    <?php
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
                $daoDienId = $daoDienId === '' ? null : $daoDienId;
                $nam = $nam === '' ? null : $nam;
                $doTuoi = $doTuoi === '' ? null : $doTuoi;
                $moTa = $moTa === '' ? null : $moTa;
                $sql = "UPDATE phim SET ten_phim = ?, quoc_gia = ?, dao_dien_id = ?, nam = ?, do_tuoi = ?, mo_ta = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('ssssssi', $tenPhim, $quocGia, $daoDienId, $nam, $doTuoi, $moTa, $id);
                    if ($stmt->execute()) {
                        $stmt->close();
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
                        echo "<script>window.location.href='index.php?page=phim';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không cập nhật được phim</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không cập nhật được phim</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
