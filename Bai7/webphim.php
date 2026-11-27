<?php
// Dùng chung file kết nối của Bai13. Nếu MySQL tắt, trang vẫn hiện phim tĩnh.
mysqli_report(MYSQLI_REPORT_OFF);
define('CHO_PHEP_LOI_KET_NOI', true);
include_once __DIR__ . '/../Bai13/conmect.php';

$youtubeMacDinh = 'https://www.youtube.com/embed/tFjmeBM41Bg';
$youtubeTheoTen = [
    'Hải Mộ Tầm Long' => 'https://www.youtube.com/embed/84PUOZtp4ZI',
    'Những Ngả Đường Ước Mơ' => 'https://www.youtube.com/embed/xsODpM3Rwdg',
    'Đứa Con Của Riêng Tôi' => 'https://www.youtube.com/embed/8bggMB_AzEY',
    'Vạn Dặm Hẹn Ước' => 'https://www.youtube.com/embed/O6ngd5E1MJE',
    'Ký Sinh Trùng' => 'https://www.youtube.com/embed/5xH0HfJHsaY',
];
$tenPhimAnh = [
    'Hải Mộ Tầm Long', 'Những Ngả Đường Ước Mơ', 'Đứa Con Của Riêng Tôi', 'Vạn Dặm Hẹn Ước',
    'Ký Sinh Trùng', 'Hồn Ma Không Chân 2', 'Hồn Ma Không Chân', 'Lời Mời',
    'Trò chơi con mực', 'Stranger Things', 'Wednesday', 'The Witcher',
    'Phi vụ triệu đô', 'One Piece', 'John Wick', 'Mad Max: Fury Road',
    'Nhiệm vụ bất khả thi', 'Kỵ sĩ bóng đêm', 'Avengers: Endgame', 'Gladiator',
    'Top Gun: Maverick', 'Furiosa', 'Ám ảnh kinh hoàng', 'It',
    'Hereditary', 'Get Out', 'Vùng đất câm lặng', 'Vòng tròn tử thần',
    'Insidious', 'Smile', 'Titanic', 'La La Land',
    'The Notebook', 'Kiêu hãnh và định kiến', 'Before Sunrise', 'Crazy Rich Asians',
    'Me Before You', 'Your Name', 'Deadpool', 'Superbad',
    'The Hangover', 'Free Guy', 'Jumanji', 'Mrs. Doubtfire',
    'Grand Budapest Hotel', 'Ted', 'Frozen', 'Encanto',
    'Spider-Verse', 'Inside Out', 'Toy Story', 'Moana',
];
$anhTheoTen = [];
foreach ($tenPhimAnh as $thuTu => $tenPhimAnhItem) {
    $anhTheoTen[$tenPhimAnhItem] = sprintf('../Anh/phim%02d.jpg', $thuTu + 1);
}
$anhNhanVat = [
    'Scooby-Doo' => ['../Anh/nhanvat01.png', 'mau-vang'],
    'Doraemon' => ['../Anh/nhanvat02.png', 'mau-cam'],
    'Jinx' => ['../Anh/nhanvat03.png', 'mau-xanh-la'],
    'Shrek' => ['../Anh/nhanvat04.png', 'mau-xanh-duong'],
    'Pikachu' => ['../Anh/nhanvat05.png', 'mau-hong'],
    'SpongeBob' => ['../Anh/nhanvat06.png', 'mau-xanh-duong'],
    'Mickey Mouse' => ['../Anh/nhanvat07.png', 'mau-cam'],
    'Sonic' => ['../Anh/nhanvat08.png', 'mau-vang'],
    'Wednesday' => ['../Anh/nhanvat09.png', 'mau-do'],
    'Po' => ['../Anh/nhanvat10.png', 'mau-hong'],
];
$mauNhanVat = ['mau-vang', 'mau-cam', 'mau-xanh-la', 'mau-xanh-duong', 'mau-hong', 'mau-do'];

function duongDanBai13($duongDan)
{
    if (!$duongDan) {
        return '';
    }
    if (preg_match('#^(https?:)?//#', $duongDan) || str_starts_with($duongDan, '../') || str_starts_with($duongDan, '/')) {
        return $duongDan;
    }
    return '../Bai13/' . ltrim($duongDan, '/');
}

function esc($giaTri)
{
    return htmlspecialchars((string) $giaTri, ENT_QUOTES, 'UTF-8');
}

$nhomTinh = [
    'Gợi ý' => ['Có thể bạn chưa xem', array_slice($tenPhimAnh, 0, 8)],
    'Phổ biến' => ['Top 10 phim bộ hôm nay', array_slice($tenPhimAnh, 8, 6)],
    'Hành động' => ['Phim hành động', array_slice($tenPhimAnh, 14, 8)],
    'Kinh dị' => ['Phim kinh dị', array_slice($tenPhimAnh, 22, 8)],
    'Tình cảm' => ['Phim tình cảm', array_slice($tenPhimAnh, 30, 8)],
    'Hài hước' => ['Phim hài', array_slice($tenPhimAnh, 38, 8)],
    'Hoạt hình' => ['Phim hoạt hình', array_slice($tenPhimAnh, 46, 6)],
];
$nhomPhim = [];
$phimJs = [];
$phimTheoTen = [];
$idTinh = 10001;
foreach ($nhomTinh as $tenNhom => $thongTin) {
    foreach ($thongTin[1] as $ten) {
        $phim = [
            'id' => $idTinh,
            'ten' => $ten,
            'poster' => $anhTheoTen[$ten],
            'trailer' => '',
            'url' => $youtubeTheoTen[$ten] ?? $youtubeMacDinh,
            'moTa' => '',
            'tieuDeNho' => $tenNhom,
            'tieuDe' => $thongTin[0],
        ];
        $nhomPhim[$tenNhom][] = $phim;
        $phimTheoTen[$ten] = [count($nhomPhim[$tenNhom]) - 1, $tenNhom];
        $idTinh++;
    }
}

$nhanVat = [];

if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    $sqlPhim = "SELECT p.id, p.ten_phim, p.poster, p.trailer, p.mo_ta, t.ten_the_loai
                FROM phim p
                LEFT JOIN phim_the_loai pt ON pt.phim_id = p.id
                LEFT JOIN the_loai t ON t.id = pt.the_loai_id
                ORDER BY p.id";
    $ketQuaPhim = mysqli_query($conn, $sqlPhim);
    $daGanTheLoai = [];
    if ($ketQuaPhim) {
        while ($dong = mysqli_fetch_assoc($ketQuaPhim)) {
            $ten = $dong['ten_phim'];
            $poster = duongDanBai13($dong['poster']);
            if ($poster === '' && isset($anhTheoTen[$ten])) {
                $poster = $anhTheoTen[$ten];
            }
            $trailer = duongDanBai13($dong['trailer']);
            $url = $trailer === '' ? ($youtubeTheoTen[$ten] ?? $youtubeMacDinh) : '';
            $theLoai = $dong['ten_the_loai'] ?: '';
            $phimMoi = [
                'id' => (int) $dong['id'],
                'ten' => $ten,
                'poster' => $poster,
                'trailer' => $trailer,
                'url' => $url,
                'moTa' => trim(preg_replace('/\s+/', ' ', $dong['mo_ta'] ?? '')),
            ];
            if (isset($phimTheoTen[$ten])) {
                [$viTri, $nhomCu] = $phimTheoTen[$ten];
                $phimCu = $nhomPhim[$nhomCu][$viTri];
                if ($poster !== '') {
                    $phimCu['poster'] = $poster;
                }
                if ($trailer !== '') {
                    $phimCu['trailer'] = $trailer;
                    $phimCu['url'] = '';
                }
                if ($phimMoi['moTa'] !== '') {
                    $phimCu['moTa'] = $phimMoi['moTa'];
                }
                $phimCu['id'] = $phimMoi['id'];
                $nhomPhim[$nhomCu][$viTri] = $phimCu;
                continue;
            }
            if (isset($daGanTheLoai[$phimMoi['id']])) {
                continue;
            }
            $daGanTheLoai[$phimMoi['id']] = true;
            if ($theLoai === '') {
                $phimMoi['tieuDeNho'] = 'Gợi ý';
                $phimMoi['tieuDe'] = 'Có thể bạn chưa xem';
                $nhomPhim['Gợi ý'][] = $phimMoi;
            } else {
                $phimMoi['tieuDeNho'] = 'Thể loại';
                $phimMoi['tieuDe'] = $theLoai;
                if (!isset($nhomPhim[$theLoai])) {
                    $nhomPhim = [$theLoai => []] + $nhomPhim;
                }
                $nhomPhim[$theLoai][] = $phimMoi;
            }
        }
    }

    $cotTen = 'ho_ten';
    $kiemTraCot = mysqli_query($conn, "SHOW COLUMNS FROM dien_vien LIKE 'ho_ten'");
    if (!$kiemTraCot || mysqli_num_rows($kiemTraCot) === 0) {
        $cotTen = 'ten_dien_vien';
    }
    $ketQuaNhanVat = mysqli_query($conn, "SELECT id, `$cotTen` AS ten FROM dien_vien ORDER BY id");
    if ($ketQuaNhanVat) {
        $thuTuMau = 0;
        while ($dong = mysqli_fetch_assoc($ketQuaNhanVat)) {
            $ten = $dong['ten'];
            $anh = $anhNhanVat[$ten][0] ?? '';
            $mau = $anhNhanVat[$ten][1] ?? $mauNhanVat[$thuTuMau % count($mauNhanVat)];
            $nhanVat[] = ['ten' => $ten, 'anh' => $anh, 'mau' => $mau];
            $thuTuMau++;
        }
    }
}

foreach ($nhomPhim as $danhSachPhimNhom) {
    foreach ($danhSachPhimNhom as $phim) {
        $phimJs[$phim['id']] = $phim;
    }
}

if (!$nhanVat) {
    foreach ($anhNhanVat as $ten => $thongTin) {
        $nhanVat[] = ['ten' => $ten, 'anh' => $thongTin[0], 'mau' => $thongTin[1]];
    }
}

$banner = '../Anh/banner1.jpg';
$duLieuJs = array_values($phimJs);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web phim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="danh-muc">
            <ul class="danh-sach-muc">
                <li class="muc"><a class="lien-ket-muc" href="webphim.php"><img src="../Anh/logo.svg" alt="Logo" class="logo"></a></li>
                <li class="muc"><a class="lien-ket-muc" href="webphim.php">Trang chủ</a></li>
                <li class="muc"><a class="lien-ket-muc" href="#nhan-vat">Nhân vật</a></li>
                <li class="muc"><a class="lien-ket-muc" href="../Bai13/index.php?page=danhmuc">Series</a></li>
                <li class="muc"><a class="lien-ket-muc" href="../Bai13/index.php?page=phim">Phim</a></li>
                <li class="muc"><a class="lien-ket-muc" href="#phim">Mới & phổ biến</a></li>
                <li class="muc"><a class="lien-ket-muc" href="../Bai13/index.php?page=taikhoan">Netflix của tôi</a></li>
                <li class="muc"><a class="lien-ket-muc" href="../Bai13/index.php?page=trangadmin">Duyệt tìm theo ngôn ngữ</a></li>
            </ul>
        </nav>
        <div class="chuc-nang">
            <div class="tim-kiem"></div>
            <div class="thong-tin">
                <a href="../Bai13/dangnhap.php" title="Đăng nhập quản trị"><img src="../Anh/avata.jpg" alt="Avata" class="avata"></a>
            </div>
        </div>
    </header>

    <main>
        <div class="banner">
            <img class="banner-anh" src="<?php echo esc($banner); ?>" alt="Banner" onclick="hienThiBannerVideo()" style="cursor: pointer;">
        </div>
        <div style="display: none;" class="banner">
            <iframe class="banner-anh" src="https://www.youtube.com/embed/dQw4w9WgXcQ"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <video id="banner-video" class="banner-anh" style="display: none;" controls></video>
        </div>

        <div id="phim">
        <?php foreach ($nhomPhim as $tenNhom => $danhSach): ?>
            <?php $phimMau = reset($danhSach); ?>
            <div class="danh-sach-the-loai">
                <div class="the-loai"><?php echo esc($phimMau['tieuDeNho'] ?? ($tenNhom === 'Gợi ý' ? 'Gợi ý' : 'Thể loại')); ?></div>
                <div class="ten-loai"><?php echo esc($phimMau['tieuDe'] ?? ($tenNhom === 'Gợi ý' ? 'Có thể bạn chưa xem' : $tenNhom)); ?></div>
            </div>
            <div class="danh-sach-phim">
                <div class="phim">
                    <?php foreach ($danhSach as $phim): ?>
                        <?php if ($phim['poster'] !== ''): ?>
                            <img src="<?php echo esc($phim['poster']); ?>" alt="<?php echo esc($phim['ten']); ?>" title="<?php echo esc($phim['moTa']); ?>" class="phim-poster" onclick="chonPhim(<?php echo (int) $phim['id']; ?>)">
                        <?php else: ?>
                            <div class="phim-poster" title="<?php echo esc($phim['moTa']); ?>" onclick="chonPhim(<?php echo (int) $phim['id']; ?>)" style="display:flex;align-items:flex-end;padding:8px;box-sizing:border-box;font-size:13px;cursor:pointer;"><?php echo esc($phim['ten']); ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="danh-sach-the-loai" id="nhan-vat">
            <div class="the-loai">Yêu thích</div>
            <div class="ten-loai">Nhân vật</div>
        </div>
        <div class="danh-sach-phim">
            <div class="nhan-vat">
                <?php foreach ($nhanVat as $nguoi): ?>
                    <a href="../Bai13/index.php?page=phim" class="the-nhan-vat">
                        <?php if ($nguoi['anh'] !== ''): ?>
                            <img src="<?php echo esc($nguoi['anh']); ?>" alt="<?php echo esc($nguoi['ten']); ?>" class="anh-nhan-vat <?php echo esc($nguoi['mau']); ?>">
                        <?php else: ?>
                            <div class="anh-nhan-vat <?php echo esc($nguoi['mau']); ?>"></div>
                        <?php endif; ?>
                        <div class="ten-nhan-vat"><?php echo esc($nguoi['ten']); ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <ul class="chan-trang-lien-ket">
            <li><a href="../Bai13/dangnhap.php">Đăng nhập quản trị</a></li>
            <li><a href="../Bai13/index.php?page=phim">Quản lý phim</a></li>
            <li><a href="../Bai13/index.php?page=danhmuc">Quản lý danh mục</a></li>
            <li><a href="../Bai13/index.php?page=taikhoan">Quản lý tài khoản</a></li>
            <li><a href="#">Mô tả âm thanh</a></li>
            <li><a href="#">Thẻ quà tặng</a></li>
            <li><a href="#">Trung tâm đa phương tiện</a></li>
            <li><a href="#">Quan hệ với nhà đầu tư</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Điều khoản sử dụng</a></li>
            <li><a href="#">Quyền riêng tư</a></li>
            <li><a href="#">Liên hệ với chúng tôi</a></li>
        </ul>
        <p class="ban-quyen">© 1997-2026 Netflix, Inc.</p>
    </footer>
    <script>
        var danhSachPhim = <?php echo json_encode(['phim' => $duLieuJs], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    </script>
    <script src="script.js"></script>
</body>
</html>
