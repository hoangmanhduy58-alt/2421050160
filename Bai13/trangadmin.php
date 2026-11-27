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
        /* Nút dẫn tới các mục quản trị */
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
    <h1>Trang admin</h1>
    <p>Bạn đang ở trang admin</p>
    <a class="them-tai-khoan" href="index.php?page=taikhoan">Tài khoản</a>
    <a class="them-tai-khoan" href="index.php?page=danhmuc">Danh mục</a>
    <a class="them-tai-khoan" href="index.php?page=phim">Phim</a>

    <!-- Bảng lối tắt xem và thêm từng mục -->
    <table>
        <tr>
            <th>Mục</th>
            <th>Chức năng</th>
        </tr>
        <tr>
            <td>Tài khoản</td>
            <td class="chuc-nang">
                <a class="cap-nhat" href="index.php?page=taikhoan">Xem</a>
                <a class="xoa" href="index.php?page=themtaikhoan">Thêm</a>
            </td>
        </tr>
        <tr>
            <td>Danh mục</td>
            <td class="chuc-nang">
                <a class="cap-nhat" href="index.php?page=danhmuc">Xem</a>
                <a class="xoa" href="index.php?page=themdanhmuc">Thêm</a>
            </td>
        </tr>
        <tr>
            <td>Phim</td>
            <td class="chuc-nang">
                <a class="cap-nhat" href="index.php?page=phim">Xem</a>
                <a class="xoa" href="index.php?page=themphim">Thêm</a>
            </td>
        </tr>
    </table>
</body>
</html>
