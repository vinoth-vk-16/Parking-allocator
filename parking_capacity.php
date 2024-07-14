<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "park";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2WheelerCount = "SELECT COUNT(*) as count FROM vehicles WHERE vehicle_type = '2-wheeler'";
$result2WheelerCount = $conn->query($sql2WheelerCount);
$row2WheelerCount = $result2WheelerCount->fetch_assoc();
$occupied2WheelerSpaces = $row2WheelerCount['count'];

$sql4WheelerCount = "SELECT COUNT(*) as count FROM vehicles WHERE vehicle_type = '4-wheeler'";
$result4WheelerCount = $conn->query($sql4WheelerCount);
$row4WheelerCount = $result4WheelerCount->fetch_assoc();
$occupied4WheelerSpaces = $row4WheelerCount['count'];

$maxCapacity2Wheeler = 40;
$maxCapacity4Wheeler = 30;

$remaining2WheelerSpaces = $maxCapacity2Wheeler - $occupied2WheelerSpaces;
$remaining4WheelerSpaces = $maxCapacity4Wheeler - $occupied4WheelerSpaces;

// Create an associative array to hold the data
$data = array(
    "remaining2WheelerSpaces" => $remaining2WheelerSpaces,
    "remaining4WheelerSpaces" => $remaining4WheelerSpaces,
);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
