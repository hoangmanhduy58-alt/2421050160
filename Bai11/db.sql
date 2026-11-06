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
-- 11. XOA DATABASE
DROP DATABASE quanlyphim;
-- 12. XOA BANG
DROP TABLE nguoi_dung;
DROP TABLE the_loai;
DROP TABLE dien_vien;
DROP TABLE dao_dien;
DROP TABLE quoc_gia;
DROP TABLE phim;
DROP TABLE phim_the_loai;
DROP TABLE phim_dien_vien;
-- 13. XOA DU LIEU
DELETE FROM nguoi_dung;
DELETE FROM the_loai;
DELETE FROM dien_vien;
DELETE FROM dao_dien;
DELETE FROM quoc_gia;
DELETE FROM phim;
DELETE FROM phim_the_loai;
DELETE FROM phim_dien_vien;
-- 14. XOA DU LIEU
DELETE FROM nguoi_dung;
DELETE FROM the_loai;
DELETE FROM dien_vien;
DELETE FROM dao_dien;
DELETE FROM quoc_gia;
DELETE FROM phim;
DELETE FROM phim_the_loai;
DELETE FROM phim_dien_vien;
-- 15. UPDATE DU LIEU
UPDATE nguoi_dung SET ten_dang_nhap = 'user1' WHERE id = 1;
UPDATE the_loai SET ten_the_loai = 'The Loai 1' WHERE id = 1;
UPDATE dien_vien SET ten_dien_vien = 'Dien Vien 1' WHERE id = 1;
UPDATE dao_dien SET ten_dao_dien = 'Dao Vien 1' WHERE id = 1;
UPDATE quoc_gia SET ten_quoc_gia = 'Quoc Gia 1' WHERE id = 1;
UPDATE phim SET ten_phim = 'Phim 1' WHERE id = 1;
UPDATE phim_the_loai SET phim_id = 1 WHERE id = 1;
UPDATE phim_dien_vien SET phim_id = 1 WHERE id = 1;
-- 16. SELECT DU LIEU
SELECT * FROM nguoi_dung;
SELECT * FROM the_loai;
SELECT * FROM dien_vien;
SELECT * FROM dao_dien;
SELECT * FROM quoc_gia;
SELECT * FROM phim;
SELECT * FROM phim_the_loai;
SELECT * FROM phim_dien_vien;
-- 17. DELETE DU LIEU
DELETE FROM nguoi_dung WHERE id = 1;
DELETE FROM the_loai WHERE id = 1;
DELETE FROM dien_vien WHERE id = 1;
DELETE FROM dao_dien WHERE id = 1;
--dien_vien
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Duy', 0, '2006-10-31', 'VietNam');
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Anh', 1, '2006-10-31', 'VietNam');
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Thuan', 0, '2006-10-31', 'VietNam');
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Quyen', 0, '2006-10-31', 'VietNam');
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Tung', 0, '2006-10-31', 'VietNam');
INSERT INTO dien_vien ('dien_vien', 'gioi_tinh', 'ngay_sinh', 'quoc_tich') VALUES ('Hoang Manh Khoa', 0, '2006-10-31', 'VietNam');
--dao_dien
INSERT INTO dao_dien (ten_dao_dien, gioi_tinh, ngay_sinh, quoc_tich) VALUES ('Nguyen Van A', 0, '1990-01-01', 'VietNam');
INSERT INTO dao_dien (ten_dao_dien, gioi_tinh, ngay_sinh, quoc_tich) VALUES ('Nguyen Van B', 0, '1990-01-01', 'VietNam');
INSERT INTO dao_dien (ten_dao_dien, gioi_tinh, ngay_sinh, quoc_tich) VALUES ('Nguyen Van C', 0, '1990-01-01', 'VietNam');
INSERT INTO dao_dien (ten_dao_dien, gioi_tinh, ngay_sinh, quoc_tich) VALUES ('Nguyen Van D', 0, '1990-01-01', 'VietNam');
--the_loai
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('1,2');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('1,3');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('1,4');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('1,5');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('2,3');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('2,4');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('2,5');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('3,4');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('3,5');
INSERT INTO the_loai (phim_id, ten_the_loai) VALUES ('4,5');
--phim
INSERT INTO phim (ten_phim, quoc_gia_id, dao_dien_id, nam_san_xuat, do_tuoi, mo_ta) VALUES ('Phim 1', 1, 1, '2020-01-01', 18, 'Mo Ta 1');
INSERT INTO phim (ten_phim, quoc_gia_id, dao_dien_id, nam_san_xuat, do_tuoi, mo_ta) VALUES ('Phim 2', 2, 2, '2020-01-01', 18, 'Mo Ta 2');
INSERT INTO phim (ten_phim, quoc_gia_id, dao_dien_id, nam_san_xuat, do_tuoi, mo_ta) VALUES ('Phim 3', 3, 3, '2020-01-01', 18, 'Mo Ta 3');
INSERT INTO phim (ten_phim, quoc_gia_id, dao_dien_id, nam_san_xuat, do_tuoi, mo_ta) VALUES ('Phim 4', 4, 4, '2020-01-01', 18, 'Mo Ta 4');
INSERT INTO phim (ten_phim, quoc_gia_id, dao_dien_id, nam_san_xuat, do_tuoi, mo_ta) VALUES ('Phim 5', 5, 5, '2020-01-01', 18, 'Mo Ta 5');
--
SELECT p.ten_phim, d.ten_dao_dien, t.ten_the_loai FROM 'phim'p
join 'dao_dien' d on p.dao_dien_id = dd.id
join 'the_loai' t on p.the_loai_id = t.id
