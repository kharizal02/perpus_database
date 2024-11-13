<?php
include '../db.php'; // sesuaikan path ini jika file db.php berada di lokasi berbeda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $prodi = $_POST['prodi'];
    $deskripsi = $_POST['deskripsi'];
    $tag = $_POST['tag'];
    $status = $_POST['status'];

    // Mengelola file gambar yang diunggah
    if (isset($_FILES['gambar'])) {
        $gambar = $_FILES['gambar']['name'];
        $targetDir = "uploads/";
        
        // Membuat folder 'uploads' jika belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($gambar);

        // Pindahkan file yang diunggah ke folder server
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            // Simpan data buku ke database beserta path gambar
            $sql = "INSERT INTO buku (judul_buku, penulis, penerbit, prodi, deskripsi, tag, status, gambar) 
                    VALUES (:judul_buku, :penulis, :penerbit, :prodi, :deskripsi, :tag, :status, :gambar)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':judul_buku' => $judul_buku,
                ':penulis' => $penulis,
                ':penerbit' => $penerbit,
                ':prodi' => $prodi,
                ':deskripsi' => $deskripsi,
                ':tag' => $tag,
                ':status' => $status,
                ':gambar' => $targetFile,
            ]);

            echo json_encode(["message" => "Buku berhasil ditambahkan."]);
        } else {
            echo json_encode(["message" => "Gagal mengunggah gambar."]);
        }
    } else {
        echo json_encode(["message" => "Gambar tidak ditemukan."]);
    }
} else {
    echo json_encode(["message" => "Invalid request"]);
}
?>
