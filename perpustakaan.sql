-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 12 Nov 2024 pada 05.17
-- Versi server: 8.3.0
-- Versi PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin1', '12345678');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nrp` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id`, `nrp`, `nama`, `judul_buku`, `tanggal_booking`, `tanggal_pengembalian`) VALUES
(1, '3223600035', 'Mohamad kharizal firdaus', 'Data Science dengan Python', '2024-11-12', '2024-11-26'),
(2, '3223600035', 'Mohamad kharizal firdaus', 'Pemrograman Dart untuk Pemula', '2024-11-12', '2024-11-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

DROP TABLE IF EXISTS `buku`;
CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) NOT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `deskripsi` text,
  `jumlah_halaman` int DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_buku`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `penulis`, `prodi`, `tahun_terbit`, `deskripsi`, `jumlah_halaman`, `tag`, `status`) VALUES
(1, 'Pemrograman IoT untuk Pemula', 'Ali', 'Teknik Informatika', '2020', 'Buku ini membahas dasar-dasar IoT.', 200, 'iot', 1),
(2, 'Flutter untuk Pemula', 'Budi', 'Sistem Informasi', '2021', 'Panduan lengkap tentang Flutter.', 300, 'flutter, mobile', 1),
(3, 'Pemrograman Web Lanjut', 'Citra', 'Teknik Komputer', '2019', 'Membahas pemrograman web tingkat lanjut.', 250, 'web, programming', 1),
(4, 'Pemrograman Dart untuk Pemula', 'Andi', 'Teknik Informatika', '2021', 'Buku ini mengajarkan dasar-dasar pemrograman dengan Dart.', 250, 'dart, programming', 1),
(5, 'Flutter dan Firebase', 'Rina', 'Sistem Informasi', '2022', 'Panduan mengintegrasikan Flutter dengan Firebase.', 300, 'flutter, firebase, mobile', 1),
(6, 'Belajar Python secara Praktis', 'Joko', 'Teknik Komputer', '2020', 'Buku ini mengajarkan Python dengan studi kasus langsung.', 200, 'python, programming', 1),
(7, 'Data Science dengan Python', 'Siti', 'Matematika', '2021', 'Menggunakan Python untuk analisis data dan pembelajaran mesin.', 350, 'python, data science, machine learning', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_mahasiswa`
--

DROP TABLE IF EXISTS `data_mahasiswa`;
CREATE TABLE IF NOT EXISTS `data_mahasiswa` (
  `id_mahasiswa` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nrp` int UNSIGNED NOT NULL,
  `status` varchar(10) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `semester` int NOT NULL,
  `tgl_lahir` date NOT NULL,
  PRIMARY KEY (`id_mahasiswa`),
  UNIQUE KEY `nrp` (`nrp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `data_mahasiswa`
--

INSERT INTO `data_mahasiswa` (`id_mahasiswa`, `nama`, `nrp`, `status`, `prodi`, `semester`, `tgl_lahir`) VALUES
(1, 'Mohamad kharizal firdaus', 3223600035, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-02'),
(3, 'Paulus Windi Kurniawan', 3223600033, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-02'),
(4, 'Kenzie Nararya', 3223600031, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perpanjangan`
--

DROP TABLE IF EXISTS `perpanjangan`;
CREATE TABLE IF NOT EXISTS `perpanjangan` (
  `id_perpanjangan` int NOT NULL AUTO_INCREMENT,
  `alasan` varchar(255) NOT NULL,
  `tgl_baru` date NOT NULL,
  PRIMARY KEY (`id_perpanjangan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

DROP TABLE IF EXISTS `riwayat`;
CREATE TABLE IF NOT EXISTS `riwayat` (
  `id_riwayat` int NOT NULL AUTO_INCREMENT,
  `id_pinjam` int NOT NULL,
  `id_buku` int NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  PRIMARY KEY (`id_riwayat`),
  KEY `fk_riwayat` (`id_pinjam`),
  KEY `fk_pinjam_buku` (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nrp` int UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nrp` (`nrp`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nrp`, `email`, `password`) VALUES
(7, 3223600035, 'kharizal@gmail.com', '$2y$10$XN6JAfe.IKE.kalkezsrJejLTYBSaqU7Ak4Jlb.koO/JCkosbuY5K'),
(8, 3223600033, 'paulus@gmail.com', '$2y$10$t7sVFojUXEnV4guZ/rKbeORDjTFAHFKBI9HAdph3QNwmjQdK/mSDC'),
(9, 3223600031, 'kenzie@gmail.com', '$2y$10$.WiLU0zT.Sk.ZeKja06lke0Y3LCDI.xInCSNcqJqbdzq131Q2ZniO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
