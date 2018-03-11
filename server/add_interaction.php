<?php
ini_set('display_errors', 1);
ini_set('display_start_errors', 1);
error_reporting(E_ALL);
function updater($jsonData)
{
    // Create connection
    $conn = new mysqli('localhost', '...', '...', 'curedb');

    $custID = mysqli_real_escape_string($conn, $jsonData['custID']);
    $faceID = mysqli_real_escape_string($conn, $jsonData['faceID']);
    $happiness = mysqli_real_escape_string($conn, $jsonData['happiness']);
    $gender = mysqli_real_escape_string($conn, $jsonData['gender']);
    $age = mysqli_real_escape_string($conn, $jsonData['age']);
    $glasses = mysqli_real_escape_string($conn, $jsonData['glasses']);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query(
            "INSERT INTO log (custID, faceID, happiness, gender, age, glasses)" .
            "VALUES ('$custID', '$faceID', '$happiness', '$gender', '$age', '$glasses')") === TRUE) {
        echo "Record updated successfully";
    } else {
        http_response_code(500);
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

$data = json_decode(file_get_contents('php://input'), true);
updater($data);
