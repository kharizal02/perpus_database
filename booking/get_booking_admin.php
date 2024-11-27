<?php
include '../db.php'; // Masukkan file konfigurasi database Anda

try {
    // Query untuk mengambil semua data booking, termasuk informasi buku yang dipinjam
    $query = "SELECT b.id_booking, b.tanggal_booking, b.id_buku, buku.judul_buku, 
                     b.tanggal_pengembalian, b.nama, b.nrp
              FROM booking b
              JOIN buku ON b.id_buku = buku.id_buku";

    // Menyiapkan query
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Mengambil hasil
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $bookingData = [];

    // Jika ada data, proses dalam array
    if ($result) {
        foreach ($result as $row) {
            // Hitung denda jika tanggal pengembalian sudah melebihi hari ini
            $tanggalPengembalian = new DateTime($row['tanggal_pengembalian']);
            $tanggalHariIni = new DateTime();
            $denda = 0;

            if ($tanggalPengembalian < $tanggalHariIni) {
                $jumlahHariTerlambat = $tanggalPengembalian->diff($tanggalHariIni)->days;
                $denda = $jumlahHariTerlambat * 5000; // Denda Rp 5000 per hari terlambat
            }

            $bookingData[] = [
                'id_booking' => $row['id_booking'],
                'judul_buku' => $row['judul_buku'],
                'tanggal_booking' => $row['tanggal_booking'],
                'tanggal_pengembalian' => $row['tanggal_pengembalian'],
                'nama' => $row['nama'],
                'nrp' => $row['nrp'],
                'denda' => $denda, // Tambahkan denda ke array hasil
            ];
        }

        // Kirim response dengan status sukses dan data booking
        echo json_encode(['status' => 'success', 'data' => $bookingData]);
    } else {
        // Jika tidak ada data booking, kirim status sukses dan data kosong
        echo json_encode(['status' => 'success', 'data' => []]);
    }
} catch (PDOException $e) {
    // Tangani error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Menutup koneksi
$stmt = null;
$conn = null;
?>
