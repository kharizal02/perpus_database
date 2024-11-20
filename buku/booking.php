<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';

header('Content-Type: application/json');

if (isset($_POST['nrp']) && isset($_POST['nama']) && isset($_POST['judul_buku']) && isset($_POST['tanggal_booking']) && isset($_POST['tanggal_pengembalian'])) {
  
    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    $judul_buku = $_POST['judul_buku'];
    $tanggal_booking = $_POST['tanggal_booking'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

    $checkQuery = "SELECT * FROM booking WHERE judul_buku = :judul_buku AND tanggal_pengembalian > NOW()";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo json_encode(array("status" => "error", "message" => "Maaf, buku ini sudah terpinjam"));
    } else {
        $sql = "INSERT INTO booking (nrp, nama, judul_buku, tanggal_booking, tanggal_pengembalian) 
                VALUES (:nrp, :nama, :judul_buku, :tanggal_booking, :tanggal_pengembalian)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':nrp', $nrp, PDO::PARAM_STR);
        $stmt->bindValue(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
        $stmt->bindValue(':tanggal_booking', $tanggal_booking, PDO::PARAM_STR);
        $stmt->bindValue(':tanggal_pengembalian', $tanggal_pengembalian, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $updateStatusQuery = "UPDATE buku SET status = 'Dipinjam' WHERE judul_buku = :judul_buku";
            $updateStmt = $conn->prepare($updateStatusQuery);
            $updateStmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);

            if ($updateStmt->execute()) {
                echo json_encode(array("status" => "success", "message" => "Booking Sukses"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Gagal memperbarui status buku"));
            }

            $updateStmt = null;
        } else {
            echo json_encode(array("status" => "error", "message" => "Booking gagal: " . $stmt->errorInfo()[2]));
        }
        $stmt = null;
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Missing required parameters"));
}

$conn = null;
?>
