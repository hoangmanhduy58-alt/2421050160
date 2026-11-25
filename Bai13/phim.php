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
    <h1>Phim</h1>
    <a class="them-tai-khoan" href="index.php?page=themphim">Thêm phim</a>
    <?php
    include_once __DIR__ . '/conmect.php';
    $sql = "SELECT p.id, p.ten_phim, p.quoc_gia, d.ho_ten AS dao_dien,
                   GROUP_CONCAT(DISTINCT t.ten_the_loai ORDER BY t.ten_the_loai SEPARATOR ', ') AS the_loai,
                   p.nam, p.do_tuoi, p.mo_ta
            FROM phim p
            LEFT JOIN dao_dien d ON p.dao_dien_id = d.id
            LEFT JOIN phim_the_loai pt ON pt.phim_id = p.id
            LEFT JOIN the_loai t ON t.id = pt.the_loai_id
            GROUP BY p.id, p.ten_phim, p.quoc_gia, d.ho_ten, p.nam, p.do_tuoi, p.mo_ta";
    $result = mysqli_query($conn, $sql);
    ?>

    <table>
        <tr>
            <th>id</th>
            <th>Tên phim</th>
            <th>Thể loại</th>
            <th>Quốc gia</th>
            <th>Đạo diễn</th>
            <th>Năm</th>
            <th>Độ tuổi</th>
            <th>Mô tả</th>
            <th>Chức năng</th>
        </tr>
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = htmlspecialchars($row['id']);
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . htmlspecialchars($row['ten_phim']) . "</td>";
                echo "<td>" . htmlspecialchars($row['the_loai'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['quoc_gia'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['dao_dien'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['nam'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['do_tuoi'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['mo_ta'] ?? '') . "</td>";
                echo "<td class='chuc-nang'>";
                echo "<a class='cap-nhat' href='index.php?page=suaphim&id=" . $id . "'>Cập nhật</a>";
                echo "<a class='xoa' href='index.php?page=xoaphim&id=" . $id . "' onclick=\"return confirm('Xóa phim này?')\">Xóa</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>" . htmlspecialchars($conn->error) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
