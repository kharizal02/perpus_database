<?php
include '../db.php'; 

// Ambil query dari parameter URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Query SQL untuk mengambil data dari tabel buku
$sql = "SELECT id_buku, judul_buku, penulis, prodi, tahun_terbit, status, tag FROM buku";

// Tambahkan klausa WHERE jika query tidak kosong
if (!empty($query)) {
    $sql .= " WHERE judul_buku LIKE :query 
              OR penulis LIKE :query 
              OR prodi LIKE :query 
              OR tahun_terbit LIKE :query 
              OR tag LIKE :query";
}

$stmt = $conn->prepare($sql);

// Bind parameter jika query tidak kosong
if (!empty($query)) {
    $searchParam = "%" . $query . "%";
    $stmt->bindParam(':query', $searchParam);
}

$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kirimkan response JSON
header('Content-Type: application/json');
echo json_encode($books);

// Tutup koneksi database
$conn = null;
?>
