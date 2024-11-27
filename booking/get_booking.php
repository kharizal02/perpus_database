<?php
include '../db.php'; // Masukkan file konfigurasi database Anda

// Ambil nrp dari parameter query string
$nrp = isset($_GET['nrp']) ? $_GET['nrp'] : '';

// Validasi jika nrp kosong
if (empty($nrp)) {
    echo json_encode(['status' => 'error', 'message' => 'NRP tidak diberikan.']);
    exit();
}

// Query untuk mengambil data peminjaman berdasarkan nrp, termasuk nama dan nrp dari tabel booking
$query = "SELECT b.id_booking, b.tanggal_booking, b.id_buku, buku.judul_buku, 
                 b.tanggal_pengembalian, b.nama, b.nrp
          FROM booking b
          JOIN buku ON b.id_buku = buku.id_buku
          WHERE b.nrp = :nrp";

$stmt = $conn->prepare($query);
$stmt->bindValue(':nrp', $nrp, PDO::PARAM_STR); // Menggunakan bindValue untuk parameter PDO
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$peminjamanData = [];

if ($result) {
    foreach ($result as $row) {
        // Menyusun data peminjaman, termasuk nama dan nrp
        $peminjamanData[] = [
            'id_booking' => $row['id_booking'],
            'judul_buku' => $row['judul_buku'],
            'tanggal_booking' => $row['tanggal_booking'],
            'tanggal_pengembalian' => $row['tanggal_pengembalian'],
            'nama' => $row['nama'], // Menambahkan nama
            'nrp' => $row['nrp'],   // Menambahkan nrp
        ];
    }
    echo json_encode(['status' => 'success', 'data' => $peminjamanData]);
} else {
    echo json_encode(['status' => 'success', 'data' => []]); // Tidak ada data
}

// Tidak perlu memanggil metode :close()
// Hanya setel objek statement ke null
$stmt = null;
$conn = null; // Menutup koneksi
?>
