<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';
header('Content-Type: application/json');

// Query untuk mengambil data mahasiswa
$query = "SELECT * FROM data_mahasiswa";
$stmt = $conn->prepare($query);
$stmt->execute();

// Ambil semua data mahasiswa
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cek apakah ada data mahasiswa
if ($mahasiswa) {
    echo json_encode([
        'status' => 'success',
        'data' => $mahasiswa
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data mahasiswa tidak ditemukan.'
    ]);
}
?>
