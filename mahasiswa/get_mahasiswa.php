<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';
header('Content-Type: application/json');

// Query untuk mengambil data mahasiswa
$query = "SELECT * FROM data_mahasiswa";
$stmt = $conn->prepare($query);
$stmt->execute();

// Ambil semua data mahasiswa
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cek apakah ada data mahasiswa
if ($mahasiswa) {
    try {
        // Mulai transaksi
        $conn->beginTransaction();

        // Proses setiap mahasiswa untuk menghitung semester
        foreach ($mahasiswa as &$mhs) {
            // Hitung selisih bulan antara tgl_tambah dan sekarang
            $currentDate = new DateTime();  // Tanggal sekarang
            $tglTambah = new DateTime($mhs['tgl_tambah']); // Tanggal tambah mahasiswa

            // Hitung selisih bulan antara tgl_tambah dan tanggal sekarang
            $interval = $tglTambah->diff($currentDate);
            $months = $interval->m + ($interval->y * 12); // Menghitung bulan total

            // Menentukan semester berdasarkan bulan
            $semester = intdiv($months, 6) + 1; // Semester setiap 6 bulan
            $mhs['semester'] = $semester; // Set semester baru

            // Update semester di database
            $updateQuery = "UPDATE data_mahasiswa SET semester = :semester WHERE id_mahasiswa = :id_mahasiswa";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindValue(':semester', $semester, PDO::PARAM_INT);
            $updateStmt->bindValue(':id_mahasiswa', $mhs['id_mahasiswa'], PDO::PARAM_INT);
            $updateStmt->execute();
        }

        // Commit transaksi
        $conn->commit();

        // Kembalikan hasil dalam bentuk JSON
        echo json_encode([
            'status' => 'success',
            'data' => $mahasiswa
        ]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data mahasiswa tidak ditemukan.'
    ]);
}
?>
