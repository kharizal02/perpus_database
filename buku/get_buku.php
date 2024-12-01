<?php
include '../db.php'; 

// Ambil query dari parameter URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Query SQL untuk mengambil data dari tabel buku dan menghitung jumlah peminjaman
$sql = "SELECT 
            b.id_buku, 
            b.judul_buku, 
            b.penulis, 
            b.prodi, 
            b.tahun_terbit, 
            b.status, 
            b.tag,
            COUNT(r.id_riwayat) AS total_peminjaman
        FROM buku b
        LEFT JOIN riwayat_peminjaman r ON b.id_buku = r.id_buku";

// Tambahkan klausa WHERE jika query tidak kosong
if (!empty($query)) {
    $sql .= " WHERE b.judul_buku LIKE :query 
              OR b.penulis LIKE :query 
              OR b.prodi LIKE :query 
              OR b.tahun_terbit LIKE :query 
              OR b.tag LIKE :query";
}

// Tambahkan klausa GROUP BY dan ORDER BY
$sql .= " GROUP BY b.id_buku
          ORDER BY total_peminjaman DESC, 
                   CASE WHEN b.status = 'tersedia' THEN 1 ELSE 2 END ASC";

// Siapkan statement
$stmt = $conn->prepare($sql);

// Bind parameter jika query tidak kosong
if (!empty($query)) {
    $searchParam = "%" . $query . "%";
    $stmt->bindParam(':query', $searchParam);
}

// Eksekusi statement
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kirimkan response JSON
header('Content-Type: application/json');
echo json_encode($books);

// Tutup koneksi database
$conn = null;
?>
