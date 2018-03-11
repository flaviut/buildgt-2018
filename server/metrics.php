<?php 
ini_set('display_errors', 1);
error_reporting(-1);
$servername= "localhost";
$username = "...";
$password = "...";
$conn = mysqli_connect($servername, $username, $password);
if(!$conn) {
	die("Could not connect: " . mysql_error());
}
$sql = "SELECT custID, gender, age, glasses, happiness, thief, visitCount, latestVisit as latestVisit FROM curedb.customers_calc";
$logresult = $conn->query("Select custID, time, happiness, gender, age, glasses");
$result = $conn->query($sql);

if($result->num_rows > 0) {
        // output data of each row
        ?>
<!DOCTYPE html>
<html>
<head>
<title>Customer List</title>
</head>
<body>
<h1>Customer List</h1>
        <table border="1" style="width:100%">
        <tr>
                <th>Customer ID</th>
                <th>Visits</th>
                <th>Shoplifter</th>
		<th>Most Recent Visit</th>
		<th>Age</th>
		<th>Happiness</th>
		<th>Gender</th>
		<th>Glasses</th>
        <tr>
 <?php
        while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                        <td><center><?php echo $row["custID"];?></center></td>
                        <td><center><?php echo $row["visitCount"];?></center></td>
			<td><center><?php
				if($row["thief"] == 1) {
					echo "Yes";
				} else {
					echo "No";
				} ?> </center></td>
			<td><center><?php echo $row["latestVisit"];?></center></td>
			<td><center><?php echo sprintf("%d", $row["age"]);?></center></td>
			<td><center><?php echo sprintf("%0.0f%%", $row["happiness"]*100);?></center></td>
                        <td><center><?php
                                if($row["gender"] == 1) {
                                        echo "Male";
                                } else {
                                        echo "Female";
                                } ?></center></td>
			<td><center><?php echo $row["glasses"];?></center></td>
                </tr>
                <?php
        }
}
$conn->close(); ?>
</table>
</body>
</html>
