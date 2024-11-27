<?php
include '../db.php';

$id_buku = isset($_GET['id_buku']) ? $_GET['id_buku'] : '';
if (empty($id_buku)) {
    echo json_encode(['error' => 'ID Buku tidak ditemukan']);
    exit;
}

$sql = "SELECT id_buku, judul_buku, penulis, prodi, tahun_terbit, deskripsi, jumlah_halaman, tag, status 
        FROM buku WHERE id_buku = :id_buku";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_buku', $id_buku, PDO::PARAM_INT);

$stmt->execute();

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($book) {
    echo json_encode($book);
} else {
    echo json_encode(['error' => 'Buku tidak ditemukan']);
}

$conn = null;
?>
