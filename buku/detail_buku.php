<?php
// Impor file db.php untuk koneksi database
include '../db.php'; // Ganti path ini jika db.php berada di lokasi berbeda

// Mendapatkan ID buku dari query string
$id_buku = isset($_GET['id_buku']) ? $_GET['id_buku'] : '';

// Validasi ID buku
if (empty($id_buku)) {
    echo json_encode(['error' => 'ID Buku tidak ditemukan']);
    exit;
}

// Menyiapkan query SQL untuk mengambil detail buku berdasarkan ID
$sql = "SELECT judul_buku, penulis, prodi, tahun_terbit, deskripsi, jumlah_halaman, tag, status 
        FROM buku WHERE id_buku = :id_buku";

// Menyiapkan statement
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_buku', $id_buku, PDO::PARAM_INT);

// Menjalankan query
$stmt->execute();

// Mengambil hasilnya
$book = $stmt->fetch(PDO::FETCH_ASSOC);

// Cek jika buku ditemukan
if ($book) {
    echo json_encode($book); // Mengembalikan detail buku dalam format JSON
} else {
    echo json_encode(['error' => 'Buku tidak ditemukan']);
}

// Menutup koneksi
$conn = null;
?>
