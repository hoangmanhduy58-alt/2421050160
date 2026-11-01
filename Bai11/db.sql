create database netflix;
-- phim
-- the_loai
-- quoc_gia
-- dao_dien
-- tap-phim
-- nguoi_dung

--table users
id int
ten_dang_nhap varchar(30),
mat_khau varchar(30),
email varchar(30),
ho_ten varchar(50),
ngay_sinh date,
so_dien_thoai varchar(10),
gioi_tinh boolean--0: nam, 1: nu
-- the_loai
id key primary auto increment int,
ten_the_loai varchar(50),
-- dien_vien
id key primary auto increment int,
ten_dien_vien varchar(50),
gioi_tinh boolean--0: nam, 1: nu
ngay_sinh date,
quoc_tich varchar(50),
-- dao_dien
id key primary auto increment int,
ten_dao_dien varchar(50),
gioi_tinh boolean--0: nam, 1: nu
ngay_sinh date,
quoc_tich varchar(50),
-- quoc_gia
id key primary auto increment int,
ten_quoc_gia varchar(50),
-- phim
id key primary auto increment int,
ten_phim varchar(50),
quoc_gia varchar(50),
dao_dien id int,
nam_san_xuat datetime,
do_tuoi int,
mo_ta varchar(255),
-- phim_the_loai
id key primary auto increment int,
phim_id int,
the_loai_id int,
-- phim_dien_vien
id key primary auto increment int,
phim_id int,
dien_vien_id int,

-- 1. TAO DATABASE
CREATE DATABASE IF NOT EXISTS quanlyphim
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE quanlyphim;

-- 2. BANG NGUOI DUNG
CREATE TABLE nguoi_dung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dang_nhap VARCHAR(30) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    ho_ten VARCHAR(50),
    ngay_sinh DATE,
    so_dien_thoai VARCHAR(10),
    gioi_tinh BOOLEAN COMMENT '0: Nam, 1: Nu'
) ENGINE=InnoDB;

-- 3. BANG THE LOAI
CREATE TABLE the_loai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_the_loai VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- 4. BANG DIEN VIEN
CREATE TABLE dien_vien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dien_vien VARCHAR(50) NOT NULL,
    gioi_tinh BOOLEAN COMMENT '0: Nam, 1: Nu',
    ngay_sinh DATE,
    quoc_tich VARCHAR(50)
) ENGINE=InnoDB;

-- 5. BANG DAO DIEN
CREATE TABLE dao_dien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dao_dien VARCHAR(50) NOT NULL,
    gioi_tinh BOOLEAN COMMENT '0: Nam, 1: Nu',
    ngay_sinh DATE,
    quoc_tich VARCHAR(50)
) ENGINE=InnoDB;

-- 6. BANG QUOC GIA
CREATE TABLE quoc_gia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_quoc_gia VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- 7. BANG PHIM
CREATE TABLE phim (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_phim VARCHAR(50) NOT NULL,
    quoc_gia_id INT,
    dao_dien_id INT,
    nam_san_xuat DATETIME,
    do_tuoi INT,
    mo_ta VARCHAR(255),

    FOREIGN KEY (quoc_gia_id)
        REFERENCES quoc_gia(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    FOREIGN KEY (dao_dien_id)
        REFERENCES dao_dien(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 8. BANG PHIM THE LOAI
CREATE TABLE phim_the_loai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phim_id INT NOT NULL,
    the_loai_id INT NOT NULL,

    FOREIGN KEY (phim_id)
        REFERENCES phim(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (the_loai_id)
        REFERENCES the_loai(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    UNIQUE (phim_id, the_loai_id)
) ENGINE=InnoDB;

-- 9. BANG PHIM DIEN VIEN
CREATE TABLE phim_dien_vien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phim_id INT NOT NULL,
    dien_vien_id INT NOT NULL,

    FOREIGN KEY (phim_id)
        REFERENCES phim(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (dien_vien_id)
        REFERENCES dien_vien(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    UNIQUE (phim_id, dien_vien_id)
) ENGINE=InnoDB;

-- 10. KIEM TRA CAC BANG
SHOW TABLES;
