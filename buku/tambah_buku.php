<?php
include '../db.php'; // Pastikan db.php di-include

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $prodi = $_POST['prodi'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $tag = $_POST['tag'];

    // Query untuk memasukkan data buku baru
    $sql = "INSERT INTO data_buku (judul_buku, penulis, prodi, tahun_terbit, deskripsi, jumlah_halaman, tag) 
            VALUES ('$judul_buku', '$penulis', '$prodi', '$tahun_terbit', '$deskripsi', '$jumlah_halaman', '$tag')";

    if (mysqli_query($conn, $sql)) {
        echo "Buku berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
