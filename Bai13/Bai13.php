<?php
    // Bắt đầu session và gán một giá trị mẫu
    session_start();
    $_SESSION['Name'] = "User";

    include_once __DIR__ . '/conmect.php';

    // Danh sách phim mẫu, chỉ thêm vào database nếu tên chưa có
    $danhSachPhim = [
        "Hải Mộ Tầm Long",
        "Những Ngả Đường Ước Mơ",
        "Đứa Con Của Riêng Tôi",
        "Vạn Dặm Hẹn Ước",
        "Ký Sinh Trùng",
        "Hồn Ma Không Chân 2",
        "Hồn Ma Không Chân",
        "Lời Mời",
        "Trò chơi con mực",
        "Stranger Things",
        "Wednesday",
        "The Witcher",
        "Phi vụ triệu đô",
        "One Piece",
        "John Wick",
        "Mad Max: Fury Road",
        "Nhiệm vụ bất khả thi",
        "Kỵ sĩ bóng đêm",
        "Avengers: Endgame",
        "Gladiator",
        "Top Gun: Maverick",
        "Furiosa",
        "Ám ảnh kinh hoàng",
        "It",
        "Hereditary",
        "Get Out",
        "Vùng đất câm lặng",
        "Vòng tròn tử thần",
        "Insidious",
        "Smile",
        "Titanic",
        "La La Land",
        "The Notebook",
        "Kiêu hãnh và định kiến",
        "Before Sunrise",
        "Crazy Rich Asians",
        "Me Before You",
        "Your Name",
        "Deadpool",
        "Superbad",
        "The Hangover",
        "Free Guy",
        "Jumanji",
        "Mrs. Doubtfire",
        "Grand Budapest Hotel",
        "Ted",
        "Frozen",
        "Encanto",
        "Spider-Verse",
        "Inside Out",
        "Toy Story",
        "Moana",
    ];

    // Danh sách diễn viên mẫu
    $danhSachNhanVat = [
        "Scooby-Doo",
        "Doraemon",
        "Jinx",
        "Shrek",
        "Pikachu",
        "SpongeBob",
        "Mickey Mouse",
        "Sonic",
        "Wednesday",
        "Po",
    ];

    // Kiểm tra từng tên phim, chưa có thì thêm mới
    $kiemTraPhim = $conn->prepare("SELECT id FROM phim WHERE ten_phim = ?");
    $themPhim = $conn->prepare("INSERT INTO phim (ten_phim) VALUES (?)");
    foreach ($danhSachPhim as $tenPhim) {
        $kiemTraPhim->bind_param("s", $tenPhim);
        $kiemTraPhim->execute();
        $kiemTraPhim->store_result();
        if ($kiemTraPhim->num_rows === 0) {
            $themPhim->bind_param("s", $tenPhim);
            $themPhim->execute();
        }
        $kiemTraPhim->free_result();
    }
    $kiemTraPhim->close();
    $themPhim->close();

    // Kiểm tra từng diễn viên, chưa có thì thêm mới
    $kiemTraNhanVat = $conn->prepare("SELECT id FROM dien_vien WHERE ho_ten = ?");
    $themNhanVat = $conn->prepare("INSERT INTO dien_vien (ho_ten) VALUES (?)");
    foreach ($danhSachNhanVat as $tenNhanVat) {
        $kiemTraNhanVat->bind_param("s", $tenNhanVat);
        $kiemTraNhanVat->execute();
        $kiemTraNhanVat->store_result();
        if ($kiemTraNhanVat->num_rows === 0) {
            $themNhanVat->bind_param("s", $tenNhanVat);
            $themNhanVat->execute();
        }
        $kiemTraNhanVat->free_result();
    }
    $kiemTraNhanVat->close();
    $themNhanVat->close();

    echo "Session Name: ", $_SESSION['Name'];

    // cookieName: tên cookie, dùng lại bằng $_COOKIE[$cookieName]
    // cookieValue: nội dung muốn lưu, luôn là chuỗi
    // time() + 86400: cookie hết hạn sau 86400 giây, tức 1 ngày
    // "/": cookie có hiệu lực trên toàn bộ website
    $cookieName = "user";
    $cookieValue = "kien";

    setcookie($cookieName, $cookieValue, time() + 86400, "/");
    // Cookie vừa set chỉ đọc được từ lần tải trang sau
    if(isset($_COOKIE[$cookieName])){
        echo "cookie đã tồn tại";

    }else{
        echo "cookie chưa đc thiết lập !";
    }
?>
