<?php
include '../db.php'; // File untuk koneksi database

// Memeriksa apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data JSON dari request body
    $input = json_decode(file_get_contents("php://input"), true);

    // Validasi data
    if (
        isset($input['judul_buku'], $input['penulis'], $input['prodi'], $input['tahun_terbit'], 
              $input['deskripsi'], $input['jumlah_halaman'], $input['tag'], $input['status'])
    ) {
        $judul_buku = $input['judul_buku'];
        $penulis = $input['penulis'];
        $prodi = $input['prodi'];
        $tahun_terbit = $input['tahun_terbit'];
        $deskripsi = $input['deskripsi'];
        $jumlah_halaman = $input['jumlah_halaman'];
        $tag = $input['tag'];
        $status = $input['status'];

        // Query untuk memeriksa apakah buku dengan judul yang sama sudah ada
        $checkQuery = "SELECT * FROM buku WHERE judul_buku = :judul_buku";
        
        // Menggunakan PDO untuk prepared statement
        $stmt = $conn->prepare($checkQuery);
        $stmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Buku dengan judul yang sama sudah ada
            echo json_encode(['success' => false, 'message' => 'Buku dengan judul ini sudah ada']);
        } else {
            // Query untuk memasukkan data ke tabel buku
            $query = "INSERT INTO buku (judul_buku, penulis, prodi, tahun_terbit, deskripsi, jumlah_halaman, tag, status) 
                      VALUES (:judul_buku, :penulis, :prodi, :tahun_terbit, :deskripsi, :jumlah_halaman, :tag, :status)";

            // Menggunakan PDO untuk prepared statement
            $stmt = $conn->prepare($query);

            // Mengikat nilai parameter
            $stmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
            $stmt->bindValue(':penulis', $penulis, PDO::PARAM_STR);
            $stmt->bindValue(':prodi', $prodi, PDO::PARAM_STR);
            $stmt->bindValue(':tahun_terbit', $tahun_terbit, PDO::PARAM_INT);
            $stmt->bindValue(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindValue(':jumlah_halaman', $jumlah_halaman, PDO::PARAM_INT);
            $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);

            // Menjalankan query
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Buku berhasil ditambahkan']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan buku']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
}

$conn = null; // Menutup koneksi
?>
