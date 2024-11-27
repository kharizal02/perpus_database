<?php
include '../db.php'; // Memuat koneksi ke database

header('Content-Type: application/json'); // Mengirimkan response dalam format JSON

try {
    // Mendapatkan data dari request POST
    $id_booking = $_POST['id_booking']; // ID booking yang akan diupdate
    $tanggal_pengembalian = $_POST['tanggal_pengembalian']; // Tanggal pengembalian baru yang diminta admin

    // Query SQL untuk memperbarui tanggal pengembalian
    $query = "UPDATE booking SET tanggal_pengembalian = :tanggal_pengembalian WHERE id_booking = :id_booking";
    
    // Menyiapkan query dan bind parameter
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tanggal_pengembalian', $tanggal_pengembalian);
    $stmt->bindParam(':id_booking', $id_booking);
    $stmt->execute(); // Menjalankan query

    // Mengecek apakah ada perubahan yang berhasil dilakukan
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Tanggal pengembalian berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui tanggal pengembalian.']);
    }
} catch (Exception $e) {
    // Jika terjadi error, tangani dan kirimkan pesan error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Menutup koneksi ke database
$stmt = null;
$conn = null;
?>
