<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$nrp = $_POST['nrp']; 

try {
    $stmt = $conn->prepare("SELECT id_mahasiswa FROM data_mahasiswa WHERE nrp = :nrp");
    $stmt->bindParam(':nrp', $nrp);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo json_encode(["success" => false, "message" => "NRP tidak terdaftar di database mahasiswa"]);
    } else {
        $id_mahasiswa = $result['id_mahasiswa'];

        // Periksa apakah email sudah digunakan
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => false, "message" => "Email sudah digunakan."]);
        } else {
            // Periksa apakah NRP sudah digunakan
            $stmt = $conn->prepare("SELECT * FROM users WHERE id_mahasiswa = :id_mahasiswa");
            $stmt->bindParam(':id_mahasiswa', $id_mahasiswa);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => false, "message" => "NRP sudah terdaftar."]);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(email, password, id_mahasiswa) VALUES (:email, :password, :id_mahasiswa)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':id_mahasiswa', $id_mahasiswa);
                $stmt->execute();

                echo json_encode(["success" => true, "message" => "Registrasi berhasil!"]);
            }
        }
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
