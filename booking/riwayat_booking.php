<?php
header('Content-Type: application/json');
include '../db.php'; // Pastikan untuk mengubah path sesuai dengan file db.php yang Anda miliki

// Query untuk mengambil riwayat peminjaman dengan judul buku
$query = "SELECT r.id_riwayat, r.id_buku, r.id_booking, r.nrp, r.nama, r.tanggal_booking, r.tanggal_kembali, b.judul_buku 
          FROM riwayat_peminjaman r
          JOIN buku b ON r.id_buku = b.id_buku";

// Eksekusi query
try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Ambil hasil query dalam bentuk array
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cek apakah ada data
    if ($riwayat) {
        // Kirimkan data dalam format JSON
        echo json_encode($riwayat);
    } else {
        // Jika tidak ada data, kirimkan pesan error
        echo json_encode(['status' => 'error', 'message' => 'Tidak ada riwayat peminjaman']);
    }
} catch (PDOException $e) {
    // Jika terjadi kesalahan, tampilkan pesan error
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
?>
