var danhSachPhim = 
    {
        phim:[
            {
                id:1,
                ten:"Hải Mộ Tầm Long",
                thoiLuong:20,
                banner: ".../Anh/phim01.jpg",
                trailer:"../Anh/phim01.mp4"
            },
            {
                id:2,
                ten:"Những Ngả Đường Ước Mơ",
                thoiLuong:15,
                banner: "../Anh/phim02.jpg",
                trailer:"../Anh/phim02.mp4"
            },
            {
                id:3,
                ten:"Đứa Con Của Riêng Tôi",
                thoiLuong:2,
                banner: "../Anh/phim03.jpg",
                trailer:"../anh/chimsau.mp4"
            },
            {
                id:4,
                ten:"Vạn Dặm Hẹn Ước",
                thoiLuong:4,
                banner: "../Anh/phim04.jpg",
                trailer:"../Anh/phim04.mp4"
            },
            {
                id:5,
                ten:"Ký Sinh Trùng",
                thoiLuong:5,
                banner: "../Anh/phim05.jpg",
                trailer:"../Anh/phim05.mp4"
            },
            {
                id:6,
                ten:"Hồn Ma Không Chân 2",
                thoiLuong:15,
                banner: "../Anh/phim06.jpg",
                trailer:"../Anh/phim06.mp4"
            },
            {
                id:7,
                ten:"Hồn Ma Không Chân",
                thoiLuong:15,
                banner: "../Anh/phim07.jpg",
                trailer:"../Anh/phim07.mp4"
            }
        ]
    }
function hienThiBannerVideo() {
    document.getElementsByClassName("banner")[0].style= "display: block";
    document.getElementsByClassName("banner")[1].style= "display: none";
}
function chonPhim(id){
    for(var i = 0; i < danhSachPhim.length; i++){
        if(danhSachPhim[i].id==id){
            var banner = danhSachPhim[i].banner;
            var trailer = danhSachPhim[i].trailer;
            document.getElementsByClassName("banner")[0].src=banner + ".png";
            var videoTag = document.getElementsByClassName("video-banner")[0];
            videoTag.src = trailer;
            videoTag.load();
            hienThiBannerVideo();
            flag=false;
        }
    }
}