<?php
include '../db.php'; 

// Cek apakah 'id_buku' dikirim melalui request
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Query SQL untuk menghapus buku berdasarkan id_buku
    $sql = "DELETE FROM buku WHERE id_buku = :id_buku";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_buku', $id_buku);

    // Eksekusi query dan cek apakah berhasil
    if ($stmt->execute()) {
        // Jika berhasil, kirim respon success
        echo json_encode(['success' => true, 'message' => 'Buku berhasil dihapus']);
    } else {
        // Jika gagal, kirim respon error
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus buku']);
    }
} else {
    // Jika 'id_buku' tidak ada, kirim respon error
    echo json_encode(['success' => false, 'message' => 'ID buku tidak ditemukan']);
}

// Tutup koneksi database
$conn = null;
?>
