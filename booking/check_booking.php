<?php
include '../db.php'; // Menghubungkan ke database

// Ambil NRP dari request
$nrp = $_GET['nrp'];

try {
    // Query untuk menghitung jumlah peminjaman aktif berdasarkan NRP
    $query = "SELECT COUNT(*) as jumlah_booking_aktif
              FROM booking 
              WHERE nrp = :nrp ";  // Anggap kolom 'status' digunakan untuk menandai peminjaman aktif

    // Menyiapkan statement PDO
    $stmt = $conn->prepare($query);

    // Mengikat parameter NRP
    $stmt->bindParam(':nrp', $nrp, PDO::PARAM_STR);

    // Menjalankan query
    $stmt->execute();

    // Mengambil hasil
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kirim status sukses atau error
    if ($data['jumlah_booking_aktif'] >= 2) {
        echo json_encode(['status' => 'error', 'message' => 'Maaf Anda tidak bisa pinjam Dikarenakan anda masih ada tanggungan buku']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Anda dapat melakukan peminjaman']);
    }

} catch (PDOException $e) {
    // Tangani kesalahan jika query gagal
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}

// Menutup koneksi
$conn = null;
?>
