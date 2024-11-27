<?php
include '../db.php'; // File untuk koneksi ke database

// Pastikan data diterima dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari request body
    $idBooking = $_POST['id_booking'];
    $tanggalPerpanjangan = $_POST['tanggal_perpanjangan'];
    $alasan = $_POST['alasan'];

    // Cek apakah id_booking sudah ada di tabel perpanjangan
    $checkQuery = "SELECT COUNT(*) FROM perpanjangan WHERE id_booking = :idBooking";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':idBooking', $idBooking);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    // Jika id_booking sudah ada, kirim pesan error
    if ($count > 0) {
        echo json_encode(["status" => "error", "message" => "ID Booking sudah ada, tidak dapat diperpanjang lagi."]);
        exit;
    }

    // Jika id_booking belum ada, lanjutkan dengan perpanjangan
    $query = "INSERT INTO perpanjangan (id_booking, tanggal_perpanjangan, alasan) 
              VALUES (:idBooking, :tanggalPerpanjangan, :alasan)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idBooking', $idBooking);
    $stmt->bindParam(':tanggalPerpanjangan', $tanggalPerpanjangan);
    $stmt->bindParam(':alasan', $alasan);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Perpanjangan berhasil diperbarui"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal memperbarui perpanjangan"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
