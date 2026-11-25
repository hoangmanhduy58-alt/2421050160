<?php
    //session
    session_start(); //bắt đầu session
    $_SESSION['Name'] = "User";

    include_once __DIR__ . '/conmect.php';

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

    // cookieName: Tên cookie	Tên định danh của cookie (ví dụ: "user", "theme").  
    // sẽ dùng tên này để gọi lại cookie bằng lệnh $_COOKIE[$cookieName].
    // $cookieValue: Giá trị cookie	Nội dung dữ liệu  muốn lưu trữ (ví dụ: "JohnDoe", "dark_mode").
    //  Giá trị này được lưu dưới dạng chuỗi (string).
    //  time() + 86400:	Thời gian hết hạn. Xác định thời điểm cookie tự động xóa. 
    // time() lấy thời gian hiện tại tính bằng giây, cộng thêm 86400 giây (tương đương 24 giờ hoặc 1 ngày). 
    // Nếu không đặt tham số này, cookie sẽ mất ngay khi đóng trình duyệt.
    // "/":	Đường dẫn áp dụng	Đường dẫn trên máy chủ mà cookie có hiệu lực. 
    // Dấu gạch chéo / nghĩa là cookie này sẽ có tác dụng trên toàn bộ trang web (tất cả các thư mục và trang con).

    $cookieName = "user";
    $cookieValue = "kien";

    setcookie($cookieName, $cookieValue, time() + 86400, "/");
    if(isset($_COOKIE[$cookieName])){
        echo "cookie đã tồn tại";

    }else{
        echo "cookie chưa đc thiết lập !";
    }





?>