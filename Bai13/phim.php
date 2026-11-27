<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Bảng danh sách chiếm hết chiều ngang */
        table{
            width: 100%;
        }
        tr, th, td{
            border: 1px solid black;
        }
        /* Nút dẫn sang trang thêm */
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
        /* Ảnh poster và video trailer trong từng dòng */
        .poster{
            width: 72px;
            height: 96px;
            object-fit: cover;
        }
        .trailer{
            width: 160px;
            max-height: 96px;
        }
    </style>
</head>
<body>
    <h1>Phim</h1>
    <a class="them-tai-khoan" href="index.php?page=themphim">Thêm phim</a>
    <?php
    include_once __DIR__ . '/conmect.php';
    // Ghép tên đạo diễn và thể loại vì mỗi phim có thể có nhiều giá trị ở bảng nối
    $sql = "SELECT p.id, p.ten_phim, p.quoc_gia,
                   GROUP_CONCAT(DISTINCT d.ho_ten ORDER BY d.ho_ten SEPARATOR ', ') AS dao_dien,
                   GROUP_CONCAT(DISTINCT t.ten_the_loai ORDER BY t.ten_the_loai SEPARATOR ', ') AS the_loai,
                   p.nam, p.do_tuoi, p.mo_ta, p.poster, p.trailer
            FROM phim p
            LEFT JOIN phim_dao_dien pd ON pd.phim_id = p.id
            LEFT JOIN dao_dien d ON d.id = pd.dao_dien_id
            LEFT JOIN phim_the_loai pt ON pt.phim_id = p.id
            LEFT JOIN the_loai t ON t.id = pt.the_loai_id
            GROUP BY p.id, p.ten_phim, p.quoc_gia, p.nam, p.do_tuoi, p.mo_ta, p.poster, p.trailer";
    $result = mysqli_query($conn, $sql);
    ?>

    <!-- table: bảng dữ liệu. tr: một hàng. th: ô tiêu đề cột. td ở vòng lặp bên dưới là ô nội dung -->
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
            <th>Poster</th>
            <th>Trailer</th>
            <th>Chức năng</th>
        </tr>
        <?php
        // Duyệt từng phim và in thành một dòng bảng
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
                // Chỉ hiện ảnh khi phim đã có poster
                echo "<td>";
                if (!empty($row['poster'])) {
                    echo "<img class='poster' src='" . htmlspecialchars($row['poster']) . "' alt='Poster'>";
                }
                echo "</td>";
                // Chỉ hiện video khi phim đã có trailer
                echo "<td>";
                if (!empty($row['trailer'])) {
                    echo "<video class='trailer' src='" . htmlspecialchars($row['trailer']) . "' controls></video>";
                }
                echo "</td>";
                echo "<td class='chuc-nang'>";
                echo "<a class='cap-nhat' href='index.php?page=suaphim&id=" . $id . "'>Cập nhật</a>";
                echo "<a class='xoa' href='index.php?page=xoaphim&id=" . $id . "' onclick=\"return confirm('Xóa phim này?')\">Xóa</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            // Hiện lỗi SQL nếu câu truy vấn thất bại
            echo "<tr><td colspan='11'>" . htmlspecialchars($conn->error) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
