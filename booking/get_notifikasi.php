<?php
header('Content-Type: application/json');
include '../db.php';

$id_mahasiswa = $_POST['id_mahasiswa'] ?? '';

if (empty($id_mahasiswa)) {
    echo json_encode(['status' => 'error', 'message' => 'ID mahasiswa tidak ditemukan.']);
    exit;
}

try {
    $query = "SELECT notifikasi FROM users WHERE id_mahasiswa = :id_mahasiswa";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id_mahasiswa' => $id_mahasiswa]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['notifikasi']) {
        // Kosongkan notifikasi setelah ditampilkan
        $clearNotifikasi = "UPDATE users SET notifikasi = NULL WHERE id_mahasiswa = :id_mahasiswa";
        $stmt = $conn->prepare($clearNotifikasi);
        $stmt->execute([':id_mahasiswa' => $id_mahasiswa]);

        echo json_encode(['status' => 'success', 'notifikasi' => $result['notifikasi']]);
    } else {
        echo json_encode(['status' => 'success', 'notifikasi' => null]);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
?>
