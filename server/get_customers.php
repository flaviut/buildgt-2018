<?php
ini_set('display_errors', 1); 
error_reporting(-1);
$servername = 'localhost';
$username = '...';
$password = '...';
$conn = mysqli_connect($servername, $username, $password);
if(!$conn) {
	die('Could not connect: ' . mysql_error());
}
$sql = "SELECT custID, faceID, thief from curedb.customers";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo $row["custID"] . "," . $row["faceID"] . "," . $row["thief"] . "\n";
	}
}
$conn->close();
?>
