<?php
// Masukkan file konfigurasi database Anda
include '../db.php'; 

header('Content-Type: application/json'); // Set response header ke JSON

try {
    // Query untuk mengambil data perpanjangan, termasuk informasi booking yang relevan
    $query = "SELECT p.id_perpanjangan, p.id_booking, p.tanggal_perpanjangan, p.alasan, 
                     b.tanggal_booking, b.tanggal_pengembalian, b.nama, b.nrp, buku.judul_buku
              FROM perpanjangan p
              JOIN booking b ON p.id_booking = b.id_booking
              JOIN buku ON b.id_buku = buku.id_buku";

    // Menyiapkan query
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Mengambil hasil
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $perpanjanganData = [];

    // Jika ada data, simpan dalam array
    if ($result) {
        foreach ($result as $row) {
            $perpanjanganData[] = [
                'id_perpanjangan' => $row['id_perpanjangan'],
                'id_booking' => $row['id_booking'],
                'tanggal_perpanjangan' => $row['tanggal_perpanjangan'],
                'alasan' => $row['alasan'],
                'tanggal_booking' => $row['tanggal_booking'],
                'tanggal_pengembalian' => $row['tanggal_pengembalian'], // Menambahkan tanggal_pengembalian
                'nama' => $row['nama'],
                'nrp' => $row['nrp'],
                'judul_buku' => $row['judul_buku'],
            ];
        }
        // Kirim response dengan status sukses dan data perpanjangan
        echo json_encode(['status' => 'success', 'data' => $perpanjanganData]);
    } else {
        // Jika tidak ada data perpanjangan, kirim status sukses dan data kosong
        echo json_encode(['status' => 'success', 'data' => []]);
    }
} catch (Exception $e) {
    // Menangani error jika terjadi kesalahan dalam proses query
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Menutup koneksi
$stmt = null;
$conn = null;
?>
