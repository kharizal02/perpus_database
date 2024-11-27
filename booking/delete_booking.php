<?php
header('Content-Type: application/json');
include '../db.php'; // Pastikan path ke db.php sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_booking = $_POST['id_booking'] ?? '';

    if (empty($id_booking)) {
        echo json_encode(['status' => 'error', 'message' => 'ID booking tidak ditemukan.']);
        exit;
    }

    try {
        // Ambil detail booking berdasarkan ID booking
        $getBooking = "SELECT id_buku, nrp, nama, tanggal_booking FROM booking WHERE id_booking = :id_booking";
        $stmt = $conn->prepare($getBooking);
        $stmt->execute([':id_booking' => $id_booking]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $id_buku = $result['id_buku'];
            $nrp = $result['nrp'];
            $nama = $result['nama'];
            $tanggal_booking = $result['tanggal_booking'];

            // Hapus booking dari tabel booking
            $deleteBooking = "DELETE FROM booking WHERE id_booking = :id_booking";
            $stmt = $conn->prepare($deleteBooking);
            $stmt->execute([':id_booking' => $id_booking]);

            // Jika penghapusan berhasil, ubah status buku menjadi "tersedia"
            if ($stmt->rowCount()) {
                // Update status buku
                $updateStatus = "UPDATE buku SET status = 'tersedia' WHERE id_buku = :id_buku";
                $stmt = $conn->prepare($updateStatus);
                $stmt->execute([':id_buku' => $id_buku]);

                // Masukkan data ke tabel riwayat_peminjaman
                $insertRiwayat = "INSERT INTO riwayat_peminjaman (id_buku, id_booking, nrp, nama, tanggal_booking, tanggal_kembali) 
                                  VALUES (:id_buku, :id_booking, :nrp, :nama, :tanggal_booking, CURRENT_TIMESTAMP)";
                $stmt = $conn->prepare($insertRiwayat);
                $stmt->execute([
                    ':id_buku' => $id_buku,
                    ':id_booking' => $id_booking,
                    ':nrp' => $nrp,
                    ':nama' => $nama,
                    ':tanggal_booking' => $tanggal_booking
                ]);

                echo json_encode(['status' => 'success', 'message' => 'Booking berhasil dihapus dan data masuk ke riwayat.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus booking.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data booking tidak ditemukan.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
