<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Khung form thêm thể loại */
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
    <h1>Thêm danh mục</h1>
    <form class="khoi" action="index.php?page=themdanhmuc" method="POST">
        <div class="i-text">
            <input type="text" name="tenTheLoai" placeholder="Tên thể loại">
        </div>
        <button>Thêm</button>
    </form>

    <?php
        include_once __DIR__ . '/conmect.php';
        // Chỉ thêm khi form đã gửi tên thể loại
        if(isset($_POST['tenTheLoai']))
        {
            $tenTheLoai = $_POST['tenTheLoai'];
            if(!empty($tenTheLoai)){
                $sql = "INSERT INTO the_loai (ten_the_loai) VALUES (?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('s', $tenTheLoai);
                    if ($stmt->execute()) {
                        $stmt->close();
                        echo "<script>window.location.href='index.php?page=danhmuc';</script>";
                    } else {
                        $stmt->close();
                        echo "<p style='color: red'>Không thêm được danh mục</p>";
                    }
                } else {
                    echo "<p style='color: red'>Không thêm được danh mục</p>";
                }
            }
            else{
                echo "<p style='color: red'>Vui lòng nhập đầy đủ thông tin</p>";
            }
        }
    ?>
</body>
</html>
