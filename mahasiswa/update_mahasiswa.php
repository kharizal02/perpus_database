<?php
include '../db.php';

try {
    if (isset($_POST['id_mahasiswa']) && isset($_POST['status']) && isset($_POST['semester'])) {
        $id_mahasiswa = $_POST['id_mahasiswa'];
        $status = $_POST['status'];
        $semester = $_POST['semester'];

        // Tambahkan logging atau var_dump untuk debug
        error_log("Received data: ID=$id_mahasiswa, Status=$status, Semester=$semester");

        $query = "UPDATE data_mahasiswa SET status = :status, semester = :semester WHERE id_mahasiswa = :id_mahasiswa";
        
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
        $stmt->bindParam(':id_mahasiswa', $id_mahasiswa, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Tambahkan pengecekan jumlah baris yang terpengaruh
            $rowCount = $stmt->rowCount();
            error_log("Rows affected: $rowCount");

            if ($rowCount > 0) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data berhasil diperbarui'
                ]);
            } else {
                echo json_encode([
                    'status' => 'warning',
                    'message' => 'Tidak ada data yang diperbarui. Mungkin ID tidak ditemukan.'
                ]);
            }
        } else {
            // Tambahkan informasi error
            $errorInfo = $stmt->errorInfo();
            error_log("SQL Error: " . print_r($errorInfo, true));

            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui data',
                'error_details' => $errorInfo[2]
            ]);
        }

        $stmt->closeCursor();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data tidak lengkap'
        ]);
    }
    
    $conn = null;
} catch (Exception $e) {
    // Tangkap dan log semua exception
    error_log("Caught exception: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>