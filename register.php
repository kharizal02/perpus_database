<?php
include 'db.php'; // Koneksi ke database Anda

$nrp = $_POST['nrp'];
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Cek apakah NRP sudah terdaftar di tabel data_mahasiswa
    $stmt = $conn->prepare("SELECT * FROM data_mahasiswa WHERE nrp = :nrp");
    $stmt->bindParam(':nrp', $nrp);
    $stmt->execute();

    // Jika NRP tidak ditemukan, tampilkan pesan error
    if ($stmt->rowCount() == 0) {
        echo json_encode(["success" => false, "message" => "NRP tidak terdaftar di database mahasiswa"]);
    } else {
        // Cek apakah NRP sudah terdaftar di tabel users
        $stmt = $conn->prepare("SELECT * FROM users WHERE nrp = :nrp");
        $stmt->bindParam(':nrp', $nrp);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => false, "message" => "NRP sudah terdaftar."]);
        } else {
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan pengguna baru ke database
            $stmt = $conn->prepare("INSERT INTO users(nrp, email, password) VALUES (:nrp, :email, :password)");
            $stmt->bindParam(':nrp', $nrp);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Registrasi berhasil!"]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
