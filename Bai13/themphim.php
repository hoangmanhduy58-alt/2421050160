<?php
include_once __DIR__ . '/conmect.php';
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
    <form class="khoi" action="index.php?page=themphim" method="POST">
        <div class="i-text">
            <input type="text" name="tenPhim" placeholder="Tên phim">
        </div>
        <div class="i-text">
            <input type="text" name="quocGia" placeholder="Quốc gia">
        </div>
        <div class="i-text">
            <select name="daoDienId">
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
            <input type="number" name="nam" placeholder="Năm sản xuất">
        </div>
        <div class="i-text">
            <input type="number" name="doTuoi" placeholder="Độ tuổi">
        </div>
        <div class="i-text">
            <textarea name="moTa" placeholder="Mô tả"></textarea>
        </div>
        <button>Thêm</button>
    </form>

    <?php
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
                $quocGia = $quocGia === '' ? null : $quocGia;
                $daoDienId = $daoDienId === '' ? null : $daoDienId;
                $nam = $nam === '' ? null : $nam;
                $doTuoi = $doTuoi === '' ? null : $doTuoi;
                $moTa = $moTa === '' ? null : $moTa;
                $sql = "INSERT INTO phim (ten_phim, quoc_gia, dao_dien_id, nam, do_tuoi, mo_ta) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('ssssss', $tenPhim, $quocGia, $daoDienId, $nam, $doTuoi, $moTa);
                    if ($stmt->execute()) {
                        $phimId = $stmt->insert_id;
                        $stmt->close();
                        if ($theLoaiId !== '') {
                            $stmtTheLoai = $conn->prepare("INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)");
                            if ($stmtTheLoai) {
                                $stmtTheLoai->bind_param('ii', $phimId, $theLoaiId);
                                $stmtTheLoai->execute();
                                $stmtTheLoai->close();
                            }
                        }
                        echo "<script>window.location.href='index.php?page=phim';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không thêm được phim</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không thêm được phim</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
