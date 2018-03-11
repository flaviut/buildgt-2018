<html>
<title>Customer Insights</title>
<?php ini_set('display_errors', 1); error_reporting(-1);
$servername = 'localhost'; $username = '...'; $password = '...';
$conn = mysqli_connect($servername, $username, $password);
if(!$conn) {
        die('Could not connect: ' . mysql_error());
}
$sqlMale = "SELECT custID from curedb.customers_calc where gender=1";
$sqlFemale = "SELECT custID from curedb.customers_calc where gender=0";
$maleResult = $conn->query($sqlMale);
$femaleResult = $conn->query($sqlFemale);
$numberMale = $maleResult->num_rows;
$numberFemale = $femaleResult->num_rows;
echo "<h1>Demographics</h1>";
echo "<h2>Gender Demographics</h2>";
echo $numberMale/($numberFemale+$numberMale)*100 . "% of your customers are male. <br>";
echo $numberFemale/($numberFemale+$numberMale)*100 . "% of your customers are female.";

$sqlAge = "SELECT age from curedb.customers_calc";
$ageResult = $conn->query($sqlAge);
$numberAge = $ageResult->num_rows;

echo "<h2>Age Demographics</h2>";
$avg = 0;
while($ageResult->num_rows > 0 && $row=$ageResult->fetch_assoc()){
	$avg = $avg + $row["age"];
}
$avg = $avg/($numberAge);
echo "Your average customer is " . round($avg) . " years old.";

?>
</html>
