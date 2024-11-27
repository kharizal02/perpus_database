<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';
header('Content-Type: application/json');

if (isset($_POST['nama'], $_POST['nrp'], $_POST['status'], $_POST['prodi'], $_POST['semester'], $_POST['tgl_lahir'])) {
    $nama = $_POST['nama'];
    $nrp = $_POST['nrp'];
    $status = $_POST['status'];
    $prodi = $_POST['prodi'];
    $semester = $_POST['semester'];
    $tgl_lahir = $_POST['tgl_lahir'];

    if (empty($nama) || empty($nrp) || empty($status) || empty($prodi) || empty($semester) || empty($tgl_lahir)) {
        echo json_encode(["status" => "error", "message" => "Semua parameter harus diisi."]);
        exit;
    }

    try {
        // Periksa apakah NRP sudah ada
        $checkQuery = "SELECT COUNT(*) FROM data_mahasiswa WHERE nrp = :nrp";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindValue(':nrp', $nrp, PDO::PARAM_STR);
        $checkStmt->execute();
        $nrpCount = $checkStmt->fetchColumn();

        if ($nrpCount > 0) {
            echo json_encode(["status" => "error", "message" => "NRP ini sudah terdaftar."]);
            exit;
        }

        // Mulai transaksi
        $conn->beginTransaction();
        // Tambahkan data mahasiswa
        $insertQuery = "INSERT INTO data_mahasiswa (nama, nrp, status, prodi, semester, tgl_lahir) 
                        VALUES (:nama, :nrp, :status, :prodi, :semester, :tgl_lahir)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindValue(':nama', $nama, PDO::PARAM_STR);
        $insertStmt->bindValue(':nrp', $nrp, PDO::PARAM_STR);
        $insertStmt->bindValue(':status', $status, PDO::PARAM_STR);
        $insertStmt->bindValue(':prodi', $prodi, PDO::PARAM_STR);
        $insertStmt->bindValue(':semester', $semester, PDO::PARAM_INT);
        $insertStmt->bindValue(':tgl_lahir', $tgl_lahir, PDO::PARAM_STR);
        $insertStmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Mahasiswa berhasil ditambahkan."]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["status" => "error", "message" => "Terjadi kesalahan: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
}
?>
