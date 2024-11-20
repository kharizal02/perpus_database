<?php
include '../db.php'; 

$id_buku = isset($_POST['id_buku']) ? $_POST['id_buku'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

if ($id_buku != '' && ($status == 'Tersedia' || $status == 'Di Pinjam')) {
    $sql = "UPDATE buku SET status = :status WHERE id_buku = :id_buku";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_buku', $id_buku);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR); 

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status buku berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status buku']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
}

$conn = null;
?>
