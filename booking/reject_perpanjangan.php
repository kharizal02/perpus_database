<?php
header('Content-Type: application/json');
include '../db.php'; // Pastikan path ke db.php sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID booking dan alasan dari POST
    $id_booking = $_POST['id_booking'] ?? '';
    $alasan = $_POST['alasan'] ?? '';  // Alasan penghapusan perpanjangan

    if (empty($id_booking) || empty($alasan)) {
        echo json_encode(['status' => 'error', 'message' => 'ID booking atau alasan tidak ditemukan.']);
        exit;
    }

    try {
        // Cek apakah ID booking ada di tabel perpanjangan
        $getPerpanjangan = "SELECT id_perpanjangan, id_booking FROM perpanjangan WHERE id_booking = :id_booking";
        $stmt = $conn->prepare($getPerpanjangan);
        $stmt->execute([':id_booking' => $id_booking]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Ambil NRP dari tabel booking berdasarkan id_booking
            $getBooking = "SELECT nrp FROM booking WHERE id_booking = :id_booking";
            $stmt = $conn->prepare($getBooking);
            $stmt->execute([':id_booking' => $id_booking]);
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($booking) {
                // Ambil NRP dari hasil query
                $nrp = $booking['nrp'];

                // Ambil id_mahasiswa berdasarkan nrp dari tabel data_mahasiswa
                $getMahasiswa = "SELECT id_mahasiswa FROM data_mahasiswa WHERE nrp = :nrp";
                $stmt = $conn->prepare($getMahasiswa);
                $stmt->execute([':nrp' => $nrp]);
                $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($mahasiswa) {
                    // Ambil id_mahasiswa
                    $id_mahasiswa = $mahasiswa['id_mahasiswa'];

                    // Hapus data perpanjangan berdasarkan ID booking
                    $deletePerpanjangan = "DELETE FROM perpanjangan WHERE id_booking = :id_booking";
                    $stmt = $conn->prepare($deletePerpanjangan);
                    $stmt->execute([':id_booking' => $id_booking]);

                    if ($stmt->rowCount()) {
                        // Kirim notifikasi setelah menghapus perpanjangan
                        $pesan = "Perpanjangan Anda untuk ID Booking $id_booking ditolak. Alasan: " . $alasan;
                        $insertNotifikasi = "INSERT INTO notifikasi (id_mahasiswa, pesan) VALUES (:id_mahasiswa, :pesan)";
                        $stmt = $conn->prepare($insertNotifikasi);
                        $stmt->execute([
                            ':id_mahasiswa' => $id_mahasiswa,
                            ':pesan' => $pesan
                        ]);

                        if ($stmt->rowCount()) {
                            // Jika berhasil mengirim notifikasi, kirim respons sukses
                            echo json_encode(['status' => 'success', 'message' => 'Perpanjangan berhasil ditolak dan dihapus. Notifikasi telah dikirim.']);
                        } else {
                            // Jika gagal mengirim notifikasi
                            echo json_encode(['status' => 'error', 'message' => 'Perpanjangan berhasil dihapus, namun gagal mengirim notifikasi.']);
                        }
                    } else {
                        // Jika gagal menghapus, kirim respons error
                        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus perpanjangan.']);
                    }
                } else {
                    // Jika id_mahasiswa tidak ditemukan
                    echo json_encode(['status' => 'error', 'message' => 'ID mahasiswa tidak ditemukan untuk NRP tersebut.']);
                }
            } else {
                // Jika NRP tidak ditemukan di tabel booking
                echo json_encode(['status' => 'error', 'message' => 'NRP tidak ditemukan di tabel booking.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data perpanjangan tidak ditemukan.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
