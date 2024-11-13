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
    // Cek apakah email ada di tabel admin (tanpa password hashing)
    $stmtAdmin = $conn->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");
    $stmtAdmin->bindParam(':email', $email);
    $stmtAdmin->bindParam(':password', $password); // Tanpa password_verify
    $stmtAdmin->execute();
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    // Jika ditemukan di tabel admin, login berhasil sebagai admin
    if ($admin) {
        echo json_encode([
            "success" => true,
            "message" => "Login berhasil sebagai Admin!",
            "data" => [
                "email" => $admin['email'],
                "role" => 'admin'
            ]
        ]);
        exit;
    }

    // Cek apakah email ada di tabel users
    $stmtUser = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmtUser->bindParam(':email', $email);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    // Jika ditemukan di tabel user dan password cocok (dengan hashing)
    if ($user && password_verify($password, $user['password'])) {
        // Ambil data mahasiswa berdasarkan NRP
        $nrp = $user['nrp'];
        $stmt = $conn->prepare("SELECT * FROM data_mahasiswa WHERE nrp = :nrp");
        $stmt->bindParam(':nrp', $nrp);
        $stmt->execute();
        $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika data mahasiswa ditemukan
        if ($mahasiswa) {
            echo json_encode([
                "success" => true,
                "message" => "Login berhasil sebagai User!",
                "data" => [
                    "email" => $user['email'],
                    "nrp" => $nrp,
                    "nama" => $mahasiswa['nama'],
                    "prodi" => $mahasiswa['prodi'],
                    "role" => 'user'
                ]
            ]);
            exit;
        } else {
            // Jika data mahasiswa tidak ditemukan
            echo json_encode(["success" => false, "message" => "Data mahasiswa tidak ditemukan"]);
        }
    }

    // Jika email tidak ditemukan di kedua tabel
    echo json_encode(["success" => false, "message" => "Email atau password salah"]);

} catch (PDOException $e) {
    // Tangani error jika terjadi masalah pada query atau koneksi database
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
