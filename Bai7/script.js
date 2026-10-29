var danhSachPhim = 
    {
        phim:[
            {
                id:1,
                ten:"Hải Mộ Tầm Long",
                thoiLuong:20,
                banner: "../Anh/phim01.jpg",
                trailer:"../Anh/phim01.mp4",
                url: "https://www.youtube.com/embed/84PUOZtp4ZI"
            },
            {
                id:2,
                ten:"Những Ngả Đường Ước Mơ",
                thoiLuong:15,
                banner: "../Anh/phim02.jpg",
                trailer:"../Anh/phim02.mp4",
                url: "https://www.youtube.com/embed/xsODpM3Rwdg"
            },
            {
                id:3,
                ten:"Đứa Con Của Riêng Tôi",
                thoiLuong:2,
                banner: "../Anh/phim03.jpg",
                trailer:"../anh/chimsau.mp4",
                url: "https://www.youtube.com/embed/8bggMB_AzEY"
            },
            {
                id:4,
                ten:"Vạn Dặm Hẹn Ước",
                thoiLuong:4,
                banner: "../Anh/phim04.jpg",
                trailer:"../Anh/phim04.mp4",
                url: "https://www.youtube.com/embed/O6ngd5E1MJE"
            },
            {
                id:5,
                ten:"Ký Sinh Trùng",
                thoiLuong:5,
                banner: "../Anh/phim05.jpg",
                trailer:"../Anh/phim05.mp4",
                url: "https://www.youtube.com/embed/5xH0HfJHsaY"
            },
            {
                id:6,
                ten:"Hồn Ma Không Chân 2",
                thoiLuong:15,
                banner: "../Anh/phim06.jpg",
                trailer:"../Anh/phim06.mp4",
                url: "https://www.youtube.com/embed/tFjmeBM41Bg"
            },
            {
                id:7,
                ten:"Hồn Ma Không Chân",
                thoiLuong:15,
                banner: "../Anh/phim07.jpg",
                trailer:"../Anh/phim07.mp4",
                url: "https://www.youtube.com/embed/S7zDTAJi_6g"
            }
        ]
    }
function hienThiBannerVideo() {
    document.getElementsByClassName("banner")[0].style.display = "none";
    document.getElementsByClassName("banner")[1].style.display = "block";
}
function chonPhim(id){
    var ds = danhSachPhim.phim;
    for(var i = 0; i < ds.length; i++){
        if(ds[i].id == id){
            document.getElementsByTagName("iframe")[0].src = ds[i].url;
            hienThiBannerVideo();
        }
    }
}
