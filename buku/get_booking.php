<?php
include '../db.php'; 

$nrp = isset($_GET['nrp']) ? $_GET['nrp'] : '';

if (!empty($nrp)) {
    $sql = "SELECT id_booking, nrp, nama, judul_buku, tanggal_booking, tanggal_pengembalian FROM booking WHERE nrp = :nrp";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nrp', $nrp, PDO::PARAM_STR);
    $stmt->execute();

    $peminjamanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($peminjamanList) > 0) {
        echo json_encode([
            'status' => 'success',
            'data' => $peminjamanList
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tidak ada data peminjaman'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'NRP tidak ditemukan'
    ]);
}

$conn = null;
?>
