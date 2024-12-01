<?php
header('Content-Type: application/json');
include '../db.php'; // Pastikan path ke db.php sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID booking dari POST
    $id_booking = $_POST['id_booking'] ?? '';

    if (empty($id_booking)) {
        echo json_encode(['status' => 'error', 'message' => 'ID booking tidak ditemukan.']);
        exit;
    }

    try {
        // Cek apakah ID booking ada di tabel perpanjangan
        $getPerpanjangan = "SELECT id_perpanjangan FROM perpanjangan WHERE id_booking = :id_booking";
        $stmt = $conn->prepare($getPerpanjangan);
        $stmt->execute([':id_booking' => $id_booking]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Hapus data perpanjangan berdasarkan ID booking
            $deletePerpanjangan = "DELETE FROM perpanjangan WHERE id_booking = :id_booking";
            $stmt = $conn->prepare($deletePerpanjangan);
            $stmt->execute([':id_booking' => $id_booking]);

            if ($stmt->rowCount()) {
                // Jika berhasil dihapus, kirim respons sukses
                echo json_encode(['status' => 'success', 'message' => 'Perpanjangan berhasil ditolak dan dihapus.']);
            } else {
                // Jika gagal menghapus, kirim respons error
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus perpanjangan.']);
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
