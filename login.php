<?php
include 'db.php'; // Koneksi ke database Anda

// Pastikan parameter email dan password sudah diisi
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(["success" => false, "message" => "Email and password are required"]);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Cek apakah email ada di tabel users
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek apakah data user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        // Ambil data mahasiswa berdasarkan NRP
        $nrp = $user['nrp'];
        $stmt = $conn->prepare("SELECT * FROM data_mahasiswa WHERE nrp = :nrp");
        $stmt->bindParam(':nrp', $nrp);
        $stmt->execute();
        $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cek apakah data mahasiswa ditemukan
        if ($mahasiswa) {
            echo json_encode([
                "success" => true,
                "message" => "Login berhasil!",
                "data" => [
                    "nrp" => $nrp,
                    "nama" => $mahasiswa['nama'],
                    "prodi" => $mahasiswa['prodi']
                ]
            ]);
        } else {
            // Jika data mahasiswa tidak ditemukan
            echo json_encode(["success" => false, "message" => "Data mahasiswa tidak ditemukan"]);
        }
    } else {
        // Jika email atau password salah
        echo json_encode(["success" => false, "message" => "Email atau password salah"]);
    }
} catch (PDOException $e) {
    // Tangani error jika terjadi masalah pada query atau koneksi database
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
