<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "park";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicleNumber = $_POST['vehicleNumber'];
    $vehicleType = $_POST['vehicleType'];

    // Check if the vehicle number already exists in the database
    $checkDuplicateSql = "SELECT * FROM vehicles WHERE vehicle_number = '$vehicleNumber'";
    $duplicateResult = $conn->query($checkDuplicateSql);

    if ($duplicateResult->num_rows > 0) {
        echo "DUPLICATE ENTRY"; // Output message for duplicate entry
    } else {
        // Insert new entry if the vehicle number is not a duplicate
        $sql = "INSERT INTO vehicles (vehicle_number, vehicle_type, in_time) VALUES ('$vehicleNumber', '$vehicleType', NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "Vehicle details added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
