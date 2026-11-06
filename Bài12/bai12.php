<?php
// nội dung in ra màn hình 
echo "Hello World <br>";
//khai báo biến $name = "John";
$hoten ="Hoang Duy";
$tuoi = 20;
// để in ra 2 biến trên thì dùng .=
echo $hoten." ".$tuoi."<br>";

// strlen() để đếm số lượng ký tự trong chuỗi
echo strlen($hoten)."<br>";
// đếm số lượng từ trong chuỗi
echo str_word_count($hoten)."<br>";
// tìm kiếm ký tự trong chuỗi
echo strpos($hoten, "o")."<br>";
// thay thế ký tự trong chuỗi
echo str_replace("o", "a", $hoten)."<br>";
$soThuNhat = 10;
$soThuHai = 20;
// tính tổng 2 số
echo $soThuNhat + $soThuHai."<br>";
// tính hiệu 2 số
echo $soThuNhat - $soThuHai."<br>";
// tính tích 2 số
echo $soThuNhat * $soThuHai."<br>";
// tính thương 2 số
echo $soThuNhat / $soThuHai."<br>";
// tính phần dư 2 số
echo $soThuNhat % $soThuHai."<br>";
// toán tử gán +=, -=, *=, /=, %=
$soThuNhat += $soThuHai  ; // tương đương với $soThuNhat = $soThuNhat + $soThuHai;
echo $soThuNhat."<br>";
$soThuNhat -= $soThuHai  ; // tương đương với $soThuNhat = $soThuNhat - $soThuHai;
echo $soThuNhat."<br>";
$soThuNhat *= $soThuHai  ; // tương đương với $soThuNhat = $soThuNhat * $soThuHai;
echo $soThuNhat."<br>";
$soThuNhat /= $soThuHai  ; // tương đương với $soThuNhat = $soThuNhat / $soThuHai;
echo $soThuNhat."<br>";
$soThuNhat %= $soThuHai  ; // tương đương với $soThuNhat = $soThuNhat % $soThuHai;
echo $soThuNhat."<br>";
// toán tử so sánh ==, !=, >, <, >=, <=,===
$soThuNhat = 10;
$soThuHai = 20;
echo $soThuNhat == $soThuHai ? "Bằng nhau" : "Không bằng nhau";
echo "<br>";
echo $soThuNhat != $soThuHai ? "Khác nhau" : "Bằng nhau";
echo "<br>";
echo $soThuNhat > $soThuHai ? "Lớn hơn" : "Không lớn hơn";
echo "<br>";
echo $soThuNhat < $soThuHai ? "Nhỏ hơn" : "Không nhỏ hơn";
echo "<br>";
echo $soThuNhat >= $soThuHai ? "Lớn hơn hoặc bằng" : "Không lớn hơn hoặc bằng";
echo "<br>";
echo $soThuNhat <= $soThuHai ? "Nhỏ hơn hoặc bằng" : "Không nhỏ hơn hoặc bằng";
echo "<br>";
// câu điều kiện if else
if($soThuNhat > $soThuHai){
    echo "Số thứ nhất lớn hơn số thứ hai"; 
} else {
    echo "Số thứ nhất không lớn hơn số thứ hai.<br>";
}
// kiểm tra tổng số của 2 số có lớn hơn 30 hay không nếu = 30
$tong = $soThuNhat + $soThuHai;
if($tong > 30){
    echo "Tổng của 2 số lớn hơn 30";
} elseif($tong == 30) {
    echo "Tổng của 2 số bằng 30";
} else {
    echo "Tổng của 2 số không lớn hơn 30";
}
// câu điều kiện switch case
$color="red";
switch($color){
    case "red":
        echo "<br> Màu đỏ";
        break;
    case "blue":
        echo "<br> Màu xanh dương";
        break;
    case "green":
        echo "<br> Màu xanh lá cây";
        break;
    default:
        echo "<br> Không có màu nào";
}
// vòng lặp for
echo "<br>";
for($i = 0; $i <= 1; $i++){
    echo "Giá trị của i là: $i <br>";
}
// mảng 
$mang= ["Hoang Duy", "Nguyen Van A", "Le Thi B"];
// đếm phần tử
echo count ($mang)."<br>";
echo $mang[0]."<br>";
$mang[]= "Nguyen Van C";
print_r($mang);
//xóa 
unset($mang[1]);
print_r($mang);
?>