<?php
// Impor file db.php untuk koneksi database
include '../db.php'; // Ganti path ini jika db.php berada di lokasi berbeda

// Mendapatkan query pencarian jika ada
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Menyiapkan query SQL untuk mengambil id_buku, judul buku, penulis, tahun terbit, status, dan tag
$sql = "SELECT id_buku, judul_buku, penulis, tahun_terbit, status, tag FROM buku";
if (!empty($query)) {
    $sql .= " WHERE tag LIKE :query OR judul_buku LIKE :query"; // Pencarian berdasarkan tag atau judul
}

$stmt = $conn->prepare($sql);

if (!empty($query)) {
    $searchParam = "%" . $query . "%";
    $stmt->bindParam(':query', $searchParam);
}

// Menjalankan query
$stmt->execute();

// Mengambil hasil dalam bentuk array
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($books);

// Menutup koneksi
$conn = null;
?>
