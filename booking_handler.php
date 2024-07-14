<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "park";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicleNumber = $_POST["vehicleNumber"];
    $vehicleType = $_POST["vehicleType"];
    $inTime = $_POST["inTime"];
    $outTime = $_POST["outTime"];

    // Insert booking details into the bookings table
    $sqlInsertBooking = "INSERT INTO bookings (vehicle_number, vehicle_type, in_time, out_time) VALUES ('$vehicleNumber', '$vehicleType', '$inTime', '$outTime')";

    if ($conn->query($sqlInsertBooking) === TRUE) {
        // Booking successful
        echo "Booking Successful!";
    } else {
        // Booking failed
        echo "Booking Failed!";
    }
}

$conn->close();
?>
