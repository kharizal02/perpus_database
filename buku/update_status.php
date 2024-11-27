<?php
header('Content-Type: application/json');
include '../db.php'; // Pastikan path ke db.php sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_buku = $_POST['id_buku'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validasi input
    if (empty($id_buku) || empty($status)) {
        echo json_encode(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
        exit;
    }

    // Validasi status yang diperbolehkan
    if (!in_array($status, ['Tersedia', 'Di Pinjam'])) {
        echo json_encode(['status' => 'error', 'message' => 'Status tidak valid.']);
        exit;
    }

    try {
        // Gunakan variabel $conn yang didefinisikan di db.php
        $query = "UPDATE buku SET status = :status WHERE id_buku = :id_buku";
        $stmt = $conn->prepare($query); // Gunakan $conn, bukan $pdo
        $stmt->execute([':status' => $status, ':id_buku' => $id_buku]);

        if ($stmt->rowCount()) {
            echo json_encode(['status' => 'success', 'message' => 'Status buku berhasil diubah.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah status buku.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
