<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';
header('Content-Type: application/json');

if (isset($_POST['nrp'], $_POST['nama'], $_POST['id_buku'], $_POST['tanggal_booking'], $_POST['tanggal_pengembalian'])) {
    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    $id_buku = $_POST['id_buku']; // Pastikan menerima id_buku, bukan judul_buku
    $tanggal_booking = $_POST['tanggal_booking'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

    if (empty($nrp) || empty($nama) || empty($id_buku) || empty($tanggal_booking) || empty($tanggal_pengembalian)) {
        echo json_encode(["status" => "error", "message" => "Semua parameter harus diisi."]);
        exit;
    }

    try {
        // Mulai transaksi
        $conn->beginTransaction();

        // Cek apakah buku tersedia
        $checkQuery = "SELECT status FROM buku WHERE id_buku = :id_buku";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindValue(':id_buku', $id_buku, PDO::PARAM_INT);
        $checkStmt->execute();
        $book = $checkStmt->fetch();

        if (!$book || $book['status'] != 'Tersedia') {
            echo json_encode(["status" => "error", "message" => "Buku tidak tersedia untuk dipinjam."]);
            $conn->rollBack();
            exit;
        }

        // Tambahkan data booking
        $insertQuery = "INSERT INTO booking (nrp, nama, id_buku, tanggal_booking, tanggal_pengembalian) 
                        VALUES (:nrp, :nama, :id_buku, :tanggal_booking, :tanggal_pengembalian)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindValue(':nrp', $nrp, PDO::PARAM_STR);
        $insertStmt->bindValue(':nama', $nama, PDO::PARAM_STR);
        $insertStmt->bindValue(':id_buku', $id_buku, PDO::PARAM_INT);
        $insertStmt->bindValue(':tanggal_booking', $tanggal_booking, PDO::PARAM_STR);
        $insertStmt->bindValue(':tanggal_pengembalian', $tanggal_pengembalian, PDO::PARAM_STR);
        $insertStmt->execute();

        // Perbarui status buku
        $updateQuery = "UPDATE buku SET status = 'Di Pinjam' WHERE id_buku = :id_buku";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindValue(':id_buku', $id_buku, PDO::PARAM_INT);
        $updateStmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Booking berhasil."]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["status" => "error", "message" => "Terjadi kesalahan: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
}
?>
