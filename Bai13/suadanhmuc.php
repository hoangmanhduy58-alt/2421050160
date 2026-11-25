<?php
include_once __DIR__ . '/conmect.php';
$id = $_GET['id'] ?? '';
$danhMuc = null;
if ($id !== '') {
    $stmt = $conn->prepare('SELECT id, ten_the_loai FROM the_loai WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $danhMuc = $result ? $result->fetch_assoc() : null;
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
    <h1>Cập nhật danh mục</h1>
    <?php if ($danhMuc) { ?>
    <form class="khoi" action="index.php?page=suadanhmuc&id=<?php echo htmlspecialchars($danhMuc['id']); ?>" method="POST">
        <div class="i-text">
            <input type="text" name="tenTheLoai" value="<?php echo htmlspecialchars($danhMuc['ten_the_loai']); ?>" placeholder="Tên thể loại">
        </div>
        <button>Cập nhật</button>
    </form>
    <?php } else { ?>
        <p style="color: red">Không tìm thấy danh mục</p>
    <?php } ?>

    <?php
        if(isset($_POST['tenTheLoai']) && $danhMuc)
        {
            $tenTheLoai = $_POST['tenTheLoai'];
            if(!empty($tenTheLoai)){
                $sql = "UPDATE the_loai SET ten_the_loai = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('si', $tenTheLoai, $id);
                    if ($stmt->execute()) {
                        $stmt->close();
                        echo "<script>window.location.href='index.php?page=danhmuc';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không cập nhật được danh mục</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không cập nhật được danh mục</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
