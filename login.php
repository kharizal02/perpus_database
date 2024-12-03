<?php
include 'db.php'; 

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(["success" => false, "message" => "Email and password are required"]);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Cek login sebagai admin
    $stmtAdmin = $conn->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");
    $stmtAdmin->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtAdmin->bindParam(':password', $password, PDO::PARAM_STR); 
    $stmtAdmin->execute();
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo json_encode([
            "success" => true,
            "message" => "Login berhasil sebagai Admin!",
            "data" => [
                "email" => $admin['email'],
                "role" => 'admin',
                "notifikasi" => [] // Kosong karena admin tidak memiliki notifikasi
            ]
        ]);
        exit;
    }

    // Cek login sebagai user
    $stmtUser = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $id_mahasiswa = (int)$user['id_mahasiswa'];

        // Ambil data mahasiswa
        $stmt = $conn->prepare("SELECT * FROM data_mahasiswa WHERE id_mahasiswa = :id_mahasiswa");
        $stmt->bindParam(':id_mahasiswa', $id_mahasiswa, PDO::PARAM_INT);
        $stmt->execute();
        $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mahasiswa) {
            if ($mahasiswa['status'] === 'Tidak Aktif') {
                echo json_encode([
                    "success" => false,
                    "message" => "Maaf, Anda Sudah Tidak Terdaftar Di Kampus Ini."
                ]);
                exit;
            }

            // Ambil notifikasi untuk mahasiswa
            $query = "SELECT id_notifikasi, pesan
                      FROM notifikasi 
                      WHERE id_mahasiswa = :id_mahasiswa";
            $stmtNotif = $conn->prepare($query);
            $stmtNotif->execute([':id_mahasiswa' => $id_mahasiswa]);
            $notifikasi = $stmtNotif->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                "success" => true,
                "message" => "Login berhasil sebagai User!",
                "data" => [
                    "email" => $user['email'],
                    "nama" => $mahasiswa['nama'],
                    "nrp" => (string)$mahasiswa['nrp'],
                    "prodi" => $mahasiswa['prodi'],
                    "role" => 'user',
                    "notifikasi" => $notifikasi // Notifikasi dengan status unread
                ]
            ]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Data mahasiswa tidak ditemukan"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email atau password salah"]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
