<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../db.php';

// Set response content type to JSON
header('Content-Type: application/json');

// Check if all required POST parameters are provided
if (isset($_POST['nrp']) && isset($_POST['nama']) && isset($_POST['judul_buku']) && isset($_POST['tanggal_booking']) && isset($_POST['tanggal_pengembalian'])) {
    // Get data from POST request
    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    $judul_buku = $_POST['judul_buku'];
    $tanggal_booking = $_POST['tanggal_booking'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

    // First, check if the book is already borrowed (the book should not be in the booking table with a return date in the future)
    $checkQuery = "SELECT * FROM booking WHERE judul_buku = :judul_buku AND tanggal_pengembalian > NOW()";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // If the book is already borrowed, return error message
        echo json_encode(array("status" => "error", "message" => "Maaf, buku ini sudah terpinjam"));
    } else {
        // Proceed with booking the book if it's available
        $sql = "INSERT INTO booking (nrp, nama, judul_buku, tanggal_booking, tanggal_pengembalian) 
                VALUES (:nrp, :nama, :judul_buku, :tanggal_booking, :tanggal_pengembalian)";
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bindValue(':nrp', $nrp, PDO::PARAM_STR);
        $stmt->bindValue(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindValue(':judul_buku', $judul_buku, PDO::PARAM_STR);
        $stmt->bindValue(':tanggal_booking', $tanggal_booking, PDO::PARAM_STR);
        $stmt->bindValue(':tanggal_pengembalian', $tanggal_pengembalian, PDO::PARAM_STR);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Booking successful"));
        } else {
            // If query fails, return error message
            echo json_encode(array("status" => "error", "message" => "Booking failed: " . $stmt->errorInfo()[2]));
        }

        // Close the statement
        $stmt = null;
    }
} else {
    // If missing parameters, return error message
    echo json_encode(array("status" => "error", "message" => "Missing required parameters"));
}

// Close the database connection
$conn = null;
?>
