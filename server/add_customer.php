<?php
ini_set('display_errors', 1);
ini_set('display_start_errors', 1);
error_reporting(E_ALL);
function updater($jsonData)
{
    // Create connection
    $conn = new mysqli('localhost', '...', '...', 'curedb');

    $faceID = mysqli_real_escape_string($conn, $jsonData['faceID']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query(
        "INSERT INTO customers (faceID, thief)" .
        "VALUES ('$faceID', 0)");
    $conn->close();
}

$data = json_decode(file_get_contents('php://input'), true);
updater($data);
