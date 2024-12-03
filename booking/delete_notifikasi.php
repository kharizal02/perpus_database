<?php
header('Content-Type: application/json');
include '../db.php'; // Ensure path to db.php is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get notification ID from POST
    $id_notifikasi = $_POST['id_notifikasi'] ?? '';
    
    if (empty($id_notifikasi)) {
        echo json_encode(['status' => 'error', 'message' => 'ID notifikasi tidak ditemukan.']);
        exit;
    }
    
    try {
        // Check if notification ID exists in the table
        $getNotifikasi = "SELECT id_notifikasi FROM notifikasi WHERE id_notifikasi = :id_notifikasi";
        $stmt = $conn->prepare($getNotifikasi);
        $stmt->execute([':id_notifikasi' => $id_notifikasi]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            // Delete notification based on notification ID
            $deleteNotifikasi = "DELETE FROM notifikasi WHERE id_notifikasi = :id_notifikasi";
            $stmt = $conn->prepare($deleteNotifikasi);
            $stmt->execute([':id_notifikasi' => $id_notifikasi]);
            
            if ($stmt->rowCount()) {
                echo json_encode(['status' => 'success', 'message' => 'Notifikasi berhasil dihapus.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus notifikasi.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data notifikasi tidak ditemukan.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>