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
    </style>
</head>
<body>
    <h1>Tài khoản</h1>
    <?php
    include_once __DIR__ . '/conmect.php';
    $sql = "SELECT id, ten_dang_nhap, email, ho_ten, ngay_sinh, so_dien_thoai, gioi_tinh FROM nguoidung";
    $result = mysqli_query($conn, $sql);
    ?>

    <table>
        <tr>
            <th>id</th>
            <th>Tên đăng nhập</th>
            <th>email</th>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Giới tính</th>
        </tr>
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['gioi_tinh'] === '0' || $row['gioi_tinh'] === 0) {
                    $gioiTinh = 'Nam';
                } elseif ($row['gioi_tinh'] === '1' || $row['gioi_tinh'] === 1) {
                    $gioiTinh = 'Nữ';
                } else {
                    $gioiTinh = '';
                }
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ten_dang_nhap']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ho_ten'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['ngay_sinh'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['so_dien_thoai'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($gioiTinh) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>" . htmlspecialchars($conn->error) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
