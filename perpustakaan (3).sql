-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 28 Nov 2024 pada 02.59
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
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '123'),
(2, 'admin1@gmail.com', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id_booking` int NOT NULL AUTO_INCREMENT,
  `nrp` int UNSIGNED NOT NULL,
  `nama` varchar(200) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int DEFAULT '0',
  `id_buku` int NOT NULL,
  `perpanjangan_status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id_booking`),
  UNIQUE KEY `id_buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id_booking`, `nrp`, `nama`, `tanggal_booking`, `tanggal_pengembalian`, `denda`, `id_buku`, `perpanjangan_status`) VALUES
(2, 3223600033, '	Paulus Windi Kurniawan', '2024-11-28', '2024-12-04', 0, 8, '1'),
(3, 3223600033, '	Paulus Windi Kurniawan', '2024-11-28', '2024-12-12', 0, 3, '0'),
(4, 3223600035, '	Mohamad Kharizal Firdaus', '2024-11-28', '2024-12-12', 0, 1, '0');

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
  `status` enum('Tersedia','Di Pinjam') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Tersedia',
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `penulis`, `prodi`, `tahun_terbit`, `deskripsi`, `jumlah_halaman`, `tag`, `status`) VALUES
(1, 'Klasifikasi Jenis Penyakit Paru Berdasarkan Citra X-Ray Menggunakan Metode Extreme Learning Machine(ELM)', 'Nilam Winarti', 'D4 Teknik Komputer', '2022', 'Penyakit paru-paru merupakan penyakit yang berdampak serius terhadap sistem pernapasan pada manusia yang dapat berakibat fatal apabila tidak segera ditangani dengan serius. Penyakit yang dapat menyerang paru-paru diantaranya coronavirus disease 2019 (COVID-19), Pneumonia bacterial, Tuberculosis (TB), dan Kanker paru. Paru-paru merupakan salah satu organ tubuh yang sulit dideteksi dan didiagnosis oleh kebanyakan ahli radiologist. Metode bidang kesehatan yang digunakan untuk menangkap kondisi organ paru-paru salah satunya dengan menggunakan teknologi x-ray (rontgen). Hasil proses dari pemeriksaan x- ray memberikan citra yang berbeda antara paru-paru yang sehat dan yang tidak sehat. Namun, hasil citra x-ray sering nampak kabur, kurang kontras, dan sebagainya, sehingga satu citra yang diamati oleh beberapa pengamat dapat menghasilkan pembacaan yang berbeda-beda. Oleh karena itu, pada tugas akhir ini dibuat suatu sistem yang mampu mengklasifikasi jenis penyakit paru berdasarkan pada hasil citra x-ray pasien COVID-19, Pneumonia bacterial, Tuberculosis, dan Kanker paru secara otomatis. Sistem ini mempunyai 4 tahapan utama, yaitu preprocessing untuk menghilangkan noise pada citra menggunakan metode median filter. Selanjutnya segmentasi untuk memisahkan objek dengan background dan jaringan lain pada paru-paru menggunakan metode Active contour untuk mendapatkan area paru-paru yang menjadi objek, image substraction, thresholding untuk mengubah citra kedalam bentuk citra biner dan morfologi close yang digunakan untuk mengurangi noise pada citra hasil thresholding. Ekstraksi fitur untuk melakukan ekstraksi ciri pada citra, dan klasifikasi untuk menentukan jenis penyakit paru-paru menggunakan metode Extreme Learning Machine (ELM). Pada proyek akhir ini, dilakukan pengujian terhadap 60 data testing, dari hasil pengujian yang dilakukan didapatkan tingkat akurasi sistem sebesar 81% dengan persen error 18%.', 200, 'COVID-i9,Penumonia bacterial,Tubercolosi,Kanker Paru,Citra x-ray,Pre- processing,Segmentasi,Ekstraksi fitur,Klasifikasi', 'Di Pinjam'),
(2, 'Rancang Bangun Sistem Visi Positioning Armour Unit Untuk Breakwater', 'Muhammad Amin Abdullah', 'D4 Teknik Komputer', '2022', 'Penempatan  a r m o u r   u n i t armour unit (batuan beton) untuk  b r e a k w a t e r breakwater (pemecah gelombang) di Indonesia masih dikerjakan dengan teknologi yang sederhana dan bergantung pada penyelam dalam setiap pemosianan  a r m o u r   u n i t s armour units. Penggunaan penyelam ini kurang efektif, karena keterbatasan komunikasi antara penyelam dengan operator ekskavator dan membuat waktu penyelaman di dalam air lama. Sehingga membuat tugas penyelam menjadi berisiko. Tujuan dari proyek akhir ini adalah menggantikan tugas penyelam yang berisiko dengan teknologi  c o m p u t e r   v i s i o n computer vision. Dengan berkembangnya teknologi saat ini,  c o m p u t e r   v i s i o n computer vision bisa diterapkan di dalam air sehingga bisa dijadikan solusi untuk masalah diatas. Pada proyek akhir ini menyajikan sistem visi untuk mengurangi peran penyelaman dalam mengatur posisi sistem  a r m o u r   u n i t s armour units. Sistem visi ini dibangun dengan dua kamera yang berbentuk dengan komputer mini. Pada sistem ini terdapat proses kalibrasi,  i m a g e   e n h a n c e m e n t image enhancement dan  i m a g e   c o l o r   r e s t o r a t i o n image color restoration untuk perbaikan citra. Pada  i m a g e   e n h a n c e m e n t image enhancement dan  i m a g e   c o l o r   r e s t o r a t i o n image color restoration digunakan tiga metode yaitu histogram equalization (HE), contrast limited adaptive histogram equalization (CLAHE), dan multi-scale retinex dengan  i m a g e   e n h a n c e m e n t image enhancement dan  i m a g e   c o l o r   r e s t o r a t i o n image color restoration. Untuk matriks evaluasi  u n d e r w a t e r   c o l o r   i m a g e   q u a l i t y   e v a l u a t i o n underwater color image quality evaluation (UCIQE) dan  u n d e r w a t e r   i m a g e   q u a l i t y   m e a s u r e s underwater image quality measures (UIQM). Pada proyek akhir ini dihasilkan rancangan bangun sistem visi positioning  a r m o u r   u n i t armour unit untuk  b r e a k w a t e r breakwater. Adapun sistem visi tersebut disertai dengan  g r a p h i c a l   u s e r   i n t e r f a c e graphical user interface sebagai sarana interaksi operator ekskavator yang ada di darat. Untuk  f r a m e   p e r   s e c o n d frame per second (FPS) didapatkan hasil dengan empat kondisi yaitu 19 FPS untuk kondisi tanpa metode  i m a g e   e n h a n c e m e n t image enhancement dan  i m a g e   c o l o r   r e s t o r a t i o n image color restoration, 18 FPS untuk kondisi dengan metode HE, 16 FPS untuk kondisi dengan metode CLAHE, dan 0.26 FPS untuk kondisi dengan metode MSRCR. Adapun hasil untuk matriks evaluasi dari metode  i m a g e   e n h a n c e m e n t image enhancement dan  i m a g e   c o l o r   r e s t o r a t i o n image color restoration didapatkan, dari 71 data gambar bawah air yang digunakan matriks evaluasi UCIQE menunjukkan bahwa metode HE menghasilkan 20%, metode CLAHE menghasilkan 8%, dan metode MSRCR 72%. Kemudian untuk matriks evaluasi UIQM menunjukkan bahwa metode CLAHE menghasilkan 100%.', 200, 'breakwater armour units,break water,image enchancement,image color restoration', 'Tersedia'),
(3, 'Pergerakan dan Respon Robot Terhadap Suara Untuk Mendekati dan Mengikuti Sumber Suara', 'Muhammad Firdaus Akmal', 'D4 Teknik Komputer', '2022', 'Pada era teknologi yang sudah sangat maju seperti sekarang, hampir seluruh kegiatan manusia dapat dilakukan oleh mesin. Dengan banyaknya contoh kegiatan yang dapat dilakukan oleh suatu mesin atau robot, maka kemajuan teknologi juga dapat membantu pekerjaan manusia. Mulai dari kegiatan manusia yang paling sederhana hingga yang rumit mampu untuk dikerjakan oleh sebuah robot. Tujuan dari dilakukannya penilitian ini adalah untuk memperbarui teknologi yang sudah ada. Teknologi yang dimaksud adalah sebuah robot yang menggunakan sensor mic dimana sensor tersebut akan berfungsi untuk mendeteksi adanya suara. Terdapat empat sensor mic yang akan dipasang pada bagian kepala robot tersebut. Sensor tersebut terletak pada bagian atas, bawah, kanan, dan kiri dari kepala robot dan akan berfungsi sebagai penunjuk letak sumber suara yang ditangkap oleh robot suara tersebut. Ketika sumber suara tersebut bergerak, maka robot ini akan secara otomatis mengikuti perpindahan sumber suara tersebut. Beberapa hal yang telah dikerjakan pada robot ini adalah melakukan desain dan perakitan pada robot. Bagian robot yang telah didesain berupa base dari robot tersebut. Pada base robot ini juga telah dilakukan pemasangan berupa komponen yang diperlukan. Untuk pengujian yang telah dilakukan, robot tersebut mampu melakukan gerakan sederhana. Gerakan sederhana yang mampu dilakukan oleh robot tersebut berupa maju, mundur, bergerak ke arah kanan dan kiri, serta melakukan gerakan berputar. Selanjutnya adalah melakukan beberapa pergerakan yang akan menunjang fungsi dari robot tersebut. Gerakan yang telah dilakukan pengujian adalah gerakan menuju titik tertentu. Untuk gerakan selanjutnya yaitu gerakan yang dilakukan robot ketika menerima banyak input. Pada gerakan tersebut robot mampu untuk mengikuti input yang diberikan tanpa harus berhenti terlebih dahulu. Dan gerakan terakhir yang telah dilakukan oleh robot tersebut adalah gerakan pada kepala robot yang digunakan untuk menunjuk arah dari datangnya sumber suara. Robot suara ini akan dikendalikan melalui sebuah mini pc berupa Raspberry PI dan Arduino untuk pemrogramannya. Dengan penelitian ini diharapkan mampu untuk meberikan kontribusi pada riset robot di Politeknik Elektronika Negeri Surabaya, apabila dilakukan pengembangan lebih lanjut robot ini dapat pula dijadikan sebagai robot asisten pribadi.', 200, 'microphone array,robot suara,Arduino, Rasberry PI.', 'Di Pinjam'),
(4, 'Search Optimization On E-Commerce Products By Image Deep Features', 'Moch. Ilham Wahyudi', 'D4 Teknik Komputer', '2022', 'Seiring berkembangnya data bertipe gambar maka diperlukan\nsistem pencarian dengan masukan berupa image atau citra untuk\nmendapatkan sistem temu kembali citra yang memiliki kemiripan\ndengan citra masukannya. Cara untuk mengetahui informasi kemiripan\nsuatu citra dengan citra lain diperlukan suatu teknik. Salah satu teknik\npencarian informasi kemiripan sebuah citra bisa dilakukan dengan\nmenganalisis isi sebenarnya dari suatu citra tersebut dengan Content\nBased Image Retrieval (CBIR). Seiring berkembangnya teknologi\ninformasi juga mempengaruhi manusia dalam melakukan aktivitasnya,\nsalah satu hal yang memanfaatkan perkembangan teknologi adalah\ndengan berbelanja secara daring melalui e-commerce. Platform e-\ncommerce pastinya memerlukan fitur sistem pencari yang membantu\npengguna dalam menemukan produk yang diinginkan. Namun,\npencarian berdasarkan keyword terkadang tidak dapat merepresentasikan\nkeseluruhan informasi yang diinginkan oleh pengguna. Sehingga pada\ntugas akhir ini akan dibuat suatu sistem pencarian berdasarkan gambar\nmenggunakan deep feature dengan arsitektur convolutional neural\nnetwork dan filter gabor. Masukan didapatkan dari gambar pakaian yang\ningin dicari oleh pengguna melalui file gambar atau dari tangkapan\nkamera. Masukan tersebut akan diekstraksi fitur menggunakan model\nCNN dan dihitung kemiripannya dengan gambar yang ada pada dataset\nmenggunakan Euclidean distance. Model VGG16 berhasil\ndiimplementasikan pada sistem website pencarian berdasarkan gambar\nyang memiliki hasil precision terbaik dengan nilai 89% pada 10 gambar\ntermirip dan nilai 74.5% pada 20 gambar termirip antara gambar\nmasukan dan gambar pada dataset.\n', 200, 'CBIR, Deep Feature, CNN, Pencarian Berdasarkan gambar , Filter Gabor', 'Tersedia'),
(5, 'Planning, Navigation, And Obstacle Avoidance Using a Given Maps And 3D Visual-Inertial System', 'Dani Rizki Rahmadi', 'D4 Teknik Komputer', '2022', 'Robot humanoid baru-baru ini menjadi bidang penelitian dan\npengembangan yang sangat aktif, serta banyak studi terkait, seperti\nberjalan secara otomatis, menghindari rintangan, melangkahi\nrintangan, dan berjalan naik turun di lereng ataupun tangga.\nAlgoritma World Recognition, global path planning, dan navigation\nstrategies merupakan hal yang sangat penting untuk robot yang\ndiharapkan dapat beroperasi secara otomatis di dunia nyata. Hal ini\njuga dapat membuat humanoid robot dan robot berkaki lainnya dapat\nberjalan diatas permukaan yang tidak rata. Oleh karena itu,\nmengamati permukaan disekitarnya dalam bentuk 3D merupakan hal\nyang sangat penting untuk membuat robot dapat memilih arah dan\nkaki mana yang akan dilangkahkan. Robot seperti ini menggunakan\nRGBD kamera dan sensor IMU untuk input dan menggunakannya\nuntuk mengatur langkah-langkah hingga mencapai ke tujuan,\ntergantung pada jarak antara robot dan rintangan terdekat. Jika\nterdapat rintangan, robot akan menghindari sampai objek tersebut\ntidak terlihat lagi. Keputusan untuk menghindari ke kiri ataupun ke\nkanan merupakan keputusan yang telah diprogram. Program harus\nmengambil langkah yang paling minimal dan kompleks. Dengan\nmemberikan program dan hardware yang sesuai, robot dapat\nmenghitung langkah yang paling optimal untuk mencapai tujuan.\nDari hasil pengujian yang dilakukan pada 7 titik tujuan pengujian\ndidapatkan tingkat akurasi sistem sebesaar 97,5%', 200, 'Citra 3D, Navigasi Robot, Path planning, Menghindari rintangan, Inertial system', 'Tersedia'),
(6, 'Sistem Deteksi Dan Analisa Penyakit Pada Ikan Berbasis Pengolahan Citra', 'Farendza Muta\'ali Muda', 'D4 Teknik Komputer', '2022', 'Ikan merupakan salah satu hal yang penting dalam kehidupan manusia dan dianggap sebagai salah satu penghubung terpenting dalam rantai makanan. Secara keseluruhan ikan merupakan sumber fosfor, kalsium, protein dan lemak baik. Selain itu ikan merupakan salah satu sumber yang paling banyak di budidayakan di Indonesia dan juga menjadi sumber ekspor terbesar di Indonesia. Tetapi ikan sebagai mahluk hidup juga dapat menderita berbagai penyakit karena hampir semua ikan membawa patogen dan parasit. Dalam mendeteksi penyakit pada ikan, banyak dilakukan secara manual oleh pembudidaya ikan yang berpengalaman serta memakan waktu yang lama karena diperlukan untuk meneliti mikroorganismenya. Dengan menggunakan metode ini juga masuh sulit untuk mendeteksi jenis patogen yang menyerang ikan secara akurat. Oleh karena itu, dengan adanya kondisi tersebut pada tugas akhir ini dibuat sebuah sistem untuk mendeteksi penyakit dan patogen yang menyerang pada ikan berdasarkan perubahan kulit berbasis pengolahan citra. Penyakit yang dapat dideteksi oleh sistem ini ada 3 yaitu penyakit red spot, motile aeromonas septicemia, dan white spot serta dapat mendeteksi ikan normal. Sistem ini mempunyai 4 tahapan, yaitu preprocessing untuk memperbaiki kualitas citra dengan menggunakan metode resized image dan adaptive histogram equalization. Selanjutnya segmentasi untuk memisahkan area dari bagian ikan yang terinfeksi dan yang normal dengan menggunakan metode K-Means Clustering. Ektraksi fitur untuk melakukan ekstraksi ciri pada citra, dan klasifikasi untuk menentukan apakah ikan normal ataupun terkena penyakit dengan menggunakan metode Artificial Neural Network. Pada proyek akhir ini, dilakukan pengujian terhadap 34 data testing, dari hasil pengujian yang dilakukan didapatkan tingkat akurasi sistem sebesar 38% dengan persen error sebesar 61%', 150, 'penyakit ikan, patogen, Pengolahan Citra, Artifical Neural Network', 'Tersedia'),
(7, 'Pemodelan Kinematika 7-DOF T-FLOW Humanoid Robot Manipulator untuk Visual Grasping Systems', 'Muhammad Ramadhan Hadi Setyawan', 'D4 Teknik Komputer', '2021', 'Robot manipulator pada robot humanoid difungsikan sebagai lengan dengan tujuan untuk melakukan gerakan menggenggam objek. Untuk melakukan tugas menggenggam, posisi end-effector robot harus diketahui terlebih dahulu. Oleh karena itu, digunakan solusi atau pemodelan kinematika untuk mengetahui posisi dari end-effector robot pada ruang Cartesian. Pada tugas akhir ini menyajika solusi atau pemodelan kinematika dari 7-DOF T-FLOW humanoid robot manipulator dimana terfokus pada solusi inverse kinematics menggunakan metode iteratif Damped Least Squares yang ditingkatkan dengan Joint limits dan Clamps untuk menghindari keterbatasan sendi karena faktor mekanik dan mengurangi kinerja komputasi. Sedangkan, forward kinematics dengan Homogeneous Transformation Matrix digunakan dalam solusi untuk menemukan posisi dari end-effector saat ini dalam ruang Cartesian berdasarkan nilai joints. Metode DLS digunakan karena dapat menghindari kinematic singularity dan berkinerja lebih baik dari formulasi yang berbasis pseudo-inverse. Hasil dalam pengujian menunjukkan bahwa solusi yang ditingkatkan menunjukan hasil yang lebih robust dalam mengatasi joint limits, menghasilkan gerakan yang lebih alami, mengurangi error sebesar 50%, dan mengurangi jumlah iterasi dalam komputasi sebesar 16% dibandingkan dengan DLS original.', 220, 'Humanoid Robot,Grasping Robotic, Kinematics Modelling,Improved Damped Least Squares, Homogenous Transformation Matrix', 'Tersedia'),
(8, 'Deteksi Objek Dinamis Dan Statis Pada Health Care Robot', 'Muhammad Dafa Geraldine Putra Malik', 'D4 Teknik Komputer', '2021', 'Human-Robot Interaction (HRI) telah menjadi fokus penelitian dalam dua dekade terakhir. Sering dengan perkembangan kebutuhan sosial, interaksi antara manusia dengan robot telah diperluas dalam berbagai aplikasi, misalnya pada companion robot dan guide robot. Perilaku robot yangsadarkan aspek sosial manusia dibutuhkan untuk membantu berinteraksi sesama manusia yang berpotensi menimbulkan ancaman. Sebagai contoh adalah dalam penanganan kasus penyakit menular. Seorang tenaga medis akan mengalami keterbatasan saat menangani pasien terlebih jika penularan dapat terjadi akibat adanya kontak fisik secara langsung. Untuk mengurangi risiko penularan dapat digunakan Health care robot yang dapat membantu kinerja tenaga medis dalam penanganan pasien. Dalam menjalankan tugasnya, robot akan sering bertemu dengan penghalang/obstacle. Robot harus dapat memilih mana obstacle dinamis dan mana yang statis. Hal ini berguna untuk membantu system navigasi dalam menentukan langkah atau tujuan antara pada saat mengeksekusi sebuah tugas. Tujuan dari penelitian ini adalah membuat robot dapat mengenali obstacle dan berupa tembok, hal ini obyek dinamis adalah manusia dan obyek statis berupa. Dalam pot, meja, kursi, dll. Dengan menggunakan LiDAR. LiDAR digunakan untuk mendeteksi keberadaan manusia karena dapat bekerja lebih cepat dari pada kamera biasa. Berdasarkan hasil eksperimen yang diperoleh, manusia dapat dideteksi dari jarak 1 hingga 4,25 meter dalam waktu 73 msec.', 300, 'Object Detection, Lidar, Human Foot Signal, Support Vector Machine, Laser Range Finder, Sliding Window, Pyramid scanning', 'Di Pinjam'),
(9, 'Aplikasi Mobile Diagnosis Penyakit Berbasis ICD-11 dengan Menggunakan Natural Language Understanding', 'Dzakiyah Salma Humairra', 'D4 Teknik Komputer', '2021', 'Diagnosis penyakit sangatlah penting untuk mencari tahu penyakit yang sedang diderita oleh pasien sehingga dokter dapat melakukan pencegahan sebelum penyakit menjadi semakin parah. Untuk mendapatkan diagnosis penyakit, maka dokter melakukan identifikasi gejala dengan menggunakan teknik anamnesis. Teknik anamnesis merupakan proses tanya jawab antara pasien dengan dokter untuk mengetahui gejala yang diderita oleh pasien tersebut. Hasil dari anamnesis tersebut, akan disimpan ke dalam Electronic Medical Record (EMR) dalam bentuk narasi. Hasil narasi tersebut akan membantu dalam proses Clinical Decision Support (CDS). Namun, hasil EMR masih kurang akurat dikarenakan tata bahasa yang digunakan masih kurang tepat. Agar komputer dapat memproses diagnosis secara tepat, maka dengan menggunakan Natural Language Understanding komputer dapat mengenali bahasa manusia. Pada penelitian sebelumnya, sistem masih menggunakan Natural Language Processing dan belum bisa mendiagnosis suatu penyakit serta aplikasi masih belum berbasis mobile. Sehingga, pada tugas akhir ini akan dibuat Aplikasi Mobile Diagnosis Penyakit Berbasis ICD-11 dengan Menggunakan Natural Language Understanding. Dimana sistem ini akan bekerja secara mobile dengan masukan suara. Sehingga, pasien tidak perlu bertatap muka dengan dokter secara langsung dan pasien mendapatkan hasil diagnosis yang akurat sesuai dengan gejala yang diderita berdasarkan rujukan ICD-11. Dari hasil pengujian yang dilakukan dengan lima percakapan, didapat nilai akurasi sebesar 93%', 215, 'Natural Language Understanding, International Classification of Diseases and Related Health problems, Diagnosis Penyakit, Anamnesis,Aplikasi Mobile', 'Tersedia'),
(10, 'Sistem Komunikasi Adaptif dan Sinkronisasi Varian Data Sensor Pada Robot Ersow', 'Khoirul Anwar', 'D4 Teknik Komputer', '2021', 'Salah satu studi terkait Cyber Physical System adalah kompetisi bidang robotika, salah satunya adalah Robot Soccer ERSOW yang berkompetisi pada Kontes Robot Sepak Bola Indonesia Beroda, mobilitas yang tinggi dari robot membuat adanya suatu batasan waktu yang ketat terhadap _task_ - _task_ pendukung robot, seperti identifikasi objek, estimasi posisi, serta komunikasi antar robot. Hal ini sangat vital untuk menjaga aliran data tetap sinkron dengan _transfer rate_ tinggi, baik data dari sisi sensor internal robot, maupun data dari komunikasi eksternal. Proyek akhir ini berfokus pada _maintenance_ aliran data agar dapat berjalan secara _real-time_ melalui penggunaan protokol komunikasi _Reconfigureable and Adaptive TDMA_ untuk meminimalisir adanya _lost packets_ dan _delay_ serta sinkronisasi varian data sensor berbasis Robot Operating System. Sehingga mampu memaksimalkan kemampuan Robot ERSOW pada kompetisi Kontes Robot Indonesia kedepannya. Dari hasil pengujian, protokol komunikasi yang sedang dikembangkan dapat membuat _delay_ minimum dengan rata - rata sebesar 3.76 ms, 2.76 ms, dan 1.52 ms, serta membuat persentase _lost packets_ minimum dengan rata - rata sebesar 0.92 %, 0.71 %, dan 0.63 % terhadap masing - masing _node_ robot 1, _node_ robot 2, dan _node_ robot 3. Perancangan dan implementasi ROS _Message_ _Filters_ melakukan sinkronisasi varian sumber data dengan 3.9 % _error_, sehingga mampu mengoptimalkan _main_ kontroler dari Robot ERSOW sebesar 4.05 %.', 180, 'Robot Soccer ERSOW, Komunikasi Adaptif, Sinkronisasi, Middleware Services,Protokol Komunikasi', 'Tersedia'),
(11, 'Human Activity Recognition From Depth Image For Healthcare Robot Application', 'Muflihul Choir', 'D4 Teknik Komputer', '2021', 'Ketika suatu daerah terjadi pandemi dan infeksi wabah penyakit yang dapat mematikan bahkan dapat menular dengan cepat melalui kontak fisik, maka hal ini membuat dokter dan perawat di Rumah Sakit saat menangani pasien yang terinfeksi penyakit tersebut harus lebih berhati-hati agar tidak tertular oleh pasien. Sehingga dapat membuat mobilitas dari tenaga medis ini menjadi berkurang atau tidak leluasa. Oleh karena itu, untuk dapat membantu pekerjaan dari tenaga medis dapat menggunakan Healthcare Robot sehingga meminimalisir untuk penularan penyakit dari pasien. Pada proyek akhir ini membuat salah satu fitur dari robot ini untuk membantu untuk mendeteksi aktifitas yang dilakukan oleh pasien (Human Activity Recognition). Fitur ini akan mendeteksi aktifitas yang sedang dilakukan oleh pasien. Hasil dari pendeteksian aktifitas pasien ini dijadikan acuan robot untuk tindakan apa yang akan dilakukan selanjutnya. Sehingga nantinya akan ada tindakan dari robot ini sesuai dengan aktifitas pasien yang dideteksi. Pendeteksian dilakukan berdasarkan input data depth image dari pasien yang didapatkan dari hasil capture menggunakan kamera kinect. Dari data depth image akan diubah menjadi bentuk skeleton, dimana skeleton ini berisi informasi berupa nilai koordinat x, y, z dari setiap joint yang ada. Lalu dilakukan ekstraksi fitur dengan menghitung nilai sudut setiap joint- nya. Setelah itu, dilakukan proses klasifikasi aktifitas dari pasien menggunakan Support Vector Machine (SVM). Berdasarkan hasil pengujian tingkat akurasi untuk mendeteksi aktifitas berdiri sebesar 88,6%, berjalan sebesar 87%, duduk sebesar 94%, dan tidur sebesar 91,8%.', 204, 'Human Activity Recognition,Depth Image, Skeleton Image, Sudut Joint, Support Vector Machine(SVM)', 'Tersedia'),
(12, 'Rancang Bangun Sistem Kontrol Manajemen Kontrol Dan Monitoring Pada Tanaman Hidroponik Berbasis Internet Of Things', 'Rismano Baharuddin Muhammad', 'D4 Teknik Komputer', '2023', 'Penerapan Internet of Things (IoT) telah memberi banyak manfaat untuk manusia dalam kemudahan mengkontrol dan memonitoring suatu sistem. Contoh penggunaan internet of things adalah pada tanaman hidroponik dimana kebutuhan serta kondisi nutrisi tanaman dapat dikontrol serta dimonitoring. Penelitian terkait hal ini pernah dilakukan dimana suhu dan kelembapan udara dimonitoring dan dikontrol menggunakan pengkabut air dengan metode fuzzy logic. Lalu terdapat penelitian terkait kontrol Ph dan PPM menggunakan telegram. Kemudian juga terdapat penelitian terkait monitoring kondisi tanaman menggunakan protokol pengiriman data yaitu MQTT. Pada penelitian ini, akan dibuat suatu sistem manajemen kontrol dan monitoring pada tanaman hidroponik menggunakan metode fuzzy, kemudian nilai yang akan dimonitoring menggunakan aplikasi mobile diantaranya adalah Ph, Kelarutan(PPM), suhu dan kelembapan udara, serta ketinggian air. Kemudian manajemen kontrol penyiraman nutrisi ke sistem hidroponik akan dibuat dengan waktu yang telah ditentukan sesuai dengan jenis tanaman. Hasil dari penelitian yang telah dilakukan menunjukkan persentase error dari sensor ultrasonik, sensor DHT22, Sensor TDS, dan Sensor Ph adalah masing-masing 0,0164%, 0,0098% & 0,0062%, 0,0842%, 0,0146%. Persentase error yang didapat untuk melakukan kontrol terhadap nilai Kelarutan, Ph Up, Ph Down, dan ketinggian air adalah masing-masing 0,0216%, 0,0238%, 0,0122%, dan 0,0384%. Kontrol Fuzzy Inference System telah berhasil berjalan dengan melakukan kontrol pada pompa pengkabut air menggunakan modul motor driver L298N.', 245, 'Manajemen Kontrol, Monitoring, Internet of Things', 'Tersedia');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `data_mahasiswa`
--

INSERT INTO `data_mahasiswa` (`id_mahasiswa`, `nama`, `nrp`, `status`, `prodi`, `semester`, `tgl_lahir`) VALUES
(1, '	Kenzie Nararya', 3223600031, 'Aktif', 'D4 Teknik Komputer', 3, '2004-12-16'),
(2, '	Ulinnuha Al Kindi Rosyadi', 3223600032, 'Aktif', 'D4 Teknik Komputer', 3, '2005-06-06'),
(3, '	Paulus Windi Kurniawan', 3223600033, 'Aktif', 'D4 Teknik Komputer', 3, '2003-06-20'),
(4, '	Syafi\'Izzudin', 3223600034, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-28'),
(5, '	Mohamad Kharizal Firdaus', 3223600035, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-02'),
(6, 'Faza Dipa Rafsanjani', 3223600036, 'Aktif', 'D4 Teknik Komputer', 3, '2006-04-29'),
(7, '	Alifah H.Q.', 3223600037, 'Aktif', 'D4 Teknik Komputer', 3, '2005-04-22'),
(8, 'Karolus Wira Wicaksana', 3223600038, 'Aktif', 'D4 Teknik Komputer', 3, '2004-11-03'),
(9, 'Nurul Hidayah', 3223600039, 'Aktif', 'D4 Teknik Komputer', 3, '2005-08-02'),
(10, 'Rahmatulloh Syaifudin Fahmi', 3223600040, 'Aktif', 'D4 Teknik Komputer', 3, '2004-10-01'),
(11, 'Akmal Rafiuddin', 3223600041, 'Aktif', 'D4 Teknik Komputer', 3, '2005-03-12'),
(12, 'Julfan Bagas Setyatama', 3223600042, 'Aktif', 'D4 Teknik Komputer', 3, '2004-07-18'),
(13, '	Robby Arsani Fiorentino', 3223600043, 'Aktif', 'D4 Teknik Komputer', 3, '2004-06-07'),
(14, 'Devano Auriza Khairindra Heriyanto', 3223600044, 'Aktif', 'D4 Teknik Komputer', 3, '2005-05-29'),
(15, 'Aulia Rayhan Al Faruq', 3223600045, 'Aktif', 'D4 Teknik Komputer', 3, '2005-05-05'),
(16, 'Hari Tammim Mu\'Izha', 3223600046, 'Aktif', 'D4 Teknik Komputer', 3, '2004-12-11'),
(17, 'Bintang Endra Erlangga', 3223600047, 'Aktif', 'D4 Teknik Komputer', 3, '2006-03-19'),
(18, 'Moch. Faris Afif', 3223600048, 'Aktif', 'D4 Teknik Komputer', 3, '2005-04-18'),
(19, 'Muhammad Labib Alzuhry', 3223600049, 'Aktif', 'D4 Teknik Komputer', 3, '2005-01-04'),
(20, 'Labib Al Afaf', 3223600050, 'Aktif', 'D4 Teknik Komputer', 3, '2004-06-21'),
(21, 'Uzair Ibnul Insan', 3223600051, 'Aktif', 'D4 Teknik Komputer', 3, '2005-01-24'),
(22, '	Noky Alrizqi Pristio Abdi', 3223600052, 'Aktif', 'D4 Teknik Komputer', 3, '2003-04-07'),
(23, '	Putri Nur Aini', 3223600053, 'Aktif', 'D4 Teknik Komputer', 3, '2005-05-12'),
(24, 'Sandy Fradana', 3223600054, 'Aktif', 'D4 Teknik Komputer', 3, '2005-01-21'),
(25, 'Arimbi Kusuma Jati', 3223600055, 'Aktif', 'D4 Teknik Komputer', 3, '2006-03-09'),
(26, 'Mochamad Najib Thariq', 3223600056, 'Aktif', 'D4 Teknik Komputer', 3, '2005-01-26'),
(27, 'Alfonso Mayzart Ojahan Silitonga', 3223600057, 'Aktif', 'D4 Teknik Komputer', 3, '2005-05-16'),
(28, 'Ihsanta Zaki Sanjaya', 3223600058, 'Aktif', 'D4 Teknik Komputer', 3, '2004-11-20'),
(29, 'Rahadyan Rakha Dzakwan Putra', 3223600059, 'Aktif', 'D4 Teknik Komputer', 3, '2004-12-05'),
(30, 'Mochammad Ega Yudhistira', 3223600060, 'Aktif', 'D4 Teknik Komputer', 3, '2004-06-30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perpanjangan`
--

DROP TABLE IF EXISTS `perpanjangan`;
CREATE TABLE IF NOT EXISTS `perpanjangan` (
  `id_perpanjangan` int NOT NULL AUTO_INCREMENT,
  `id_booking` int NOT NULL,
  `tanggal_perpanjangan` date NOT NULL,
  `alasan` text NOT NULL,
  PRIMARY KEY (`id_perpanjangan`),
  KEY `id_booking` (`id_booking`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `perpanjangan`
--

INSERT INTO `perpanjangan` (`id_perpanjangan`, `id_booking`, `tanggal_perpanjangan`, `alasan`) VALUES
(3, 3, '2024-12-15', 'saya belum selesai membacanya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_peminjaman`
--

DROP TABLE IF EXISTS `riwayat_peminjaman`;
CREATE TABLE IF NOT EXISTS `riwayat_peminjaman` (
  `id_riwayat` int NOT NULL AUTO_INCREMENT,
  `id_buku` int NOT NULL,
  `id_booking` int NOT NULL,
  `nrp` int UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_booking` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_riwayat`),
  KEY `id_buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `riwayat_peminjaman`
--

INSERT INTO `riwayat_peminjaman` (`id_riwayat`, `id_buku`, `id_booking`, `nrp`, `nama`, `tanggal_booking`, `tanggal_kembali`) VALUES
(1, 10, 1, 3223600035, '	Mohamad Kharizal Firdaus', '2024-11-28 00:00:00', '2024-11-28 09:17:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mahasiswa` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `id_mahasiswa` (`id_mahasiswa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_mahasiswa`, `email`, `password`) VALUES
(1, 5, 'kharizal@gmail.com', '$2y$10$NMwuszq.8qcdhcODzmRSCe88vlr3WF8EsXrrB0.XpO7Oid0TteHJy'),
(2, 3, 'paulus@gmail.com', '$2y$10$8PJ3AzNQpGhIgXrtU/wpjeCKxOd8tXZWJlUPl8PUHxSKDCKAeqLEe');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `perpanjangan`
--
ALTER TABLE `perpanjangan`
  ADD CONSTRAINT `perpanjangan_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`);

--
-- Ketidakleluasaan untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  ADD CONSTRAINT `riwayat_peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `data_mahasiswa` (`id_mahasiswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
