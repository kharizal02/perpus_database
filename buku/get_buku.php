<?php
include '../db.php'; 
$query = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT id_buku, judul_buku, penulis, tahun_terbit, status, tag, gambar FROM buku";
if (!empty($query)) {
    $sql .= " WHERE tag LIKE :query OR judul_buku LIKE :query";
}

$stmt = $conn->prepare($sql);

if (!empty($query)) {
    $searchParam = "%" . $query . "%";
    $stmt->bindParam(':query', $searchParam);
}
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($books);

$conn = null;
?>
