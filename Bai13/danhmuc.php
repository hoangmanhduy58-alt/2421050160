<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            width: 100%;
        }
        tr, th, td{
            border: 1px solid black;
        }
        .them-tai-khoan{
            display: inline-block;
            margin: 8px 0 12px;
            padding: 8px 14px;
            border-radius: 18px;
            background-color:rgb(235, 37, 53);
            color: #F1F5F9;
            text-decoration: none;
        }
        .chuc-nang a{
            display: inline-block;
            margin: 2px;
            padding: 4px 8px;
            border-radius: 12px;
            color: #F1F5F9;
            text-decoration: none;
        }
        .cap-nhat{
            background-color: #2563EB;
        }
        .xoa{
            background-color: rgb(235, 37, 53);
        }
    </style>
</head>
<body>
    <h1>Danh mục</h1>
    <a class="them-tai-khoan" href="index.php?page=themdanhmuc">Thêm danh mục</a>
    <?php
    include_once __DIR__ . '/conmect.php';
    $sql = "SELECT id, ten_the_loai FROM the_loai";
    $result = mysqli_query($conn, $sql);
    ?>

    <table>
        <tr>
            <th>id</th>
            <th>Tên thể loại</th>
            <th>Chức năng</th>
        </tr>
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = htmlspecialchars($row['id']);
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . htmlspecialchars($row['ten_the_loai']) . "</td>";
                echo "<td class='chuc-nang'>";
                echo "<a class='cap-nhat' href='index.php?page=suadanhmuc&id=" . $id . "'>Cập nhật</a>";
                echo "<a class='xoa' href='index.php?page=xoadanhmuc&id=" . $id . "' onclick=\"return confirm('Xóa danh mục này?')\">Xóa</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>" . htmlspecialchars($conn->error) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
