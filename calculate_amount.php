<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "park";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the time zone to the server's local time zone
date_default_timezone_set('Asia/Kolkata'); // Change 'Asia/Kolkata' to your server's time zone

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicleNumber = $_POST['vehicleNumber'];

    $sql = "SELECT * FROM vehicles WHERE vehicle_number = '$vehicleNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $inTime = strtotime($row['in_time']);
        $outTime = time(); // Get the current time as the out time

        // Ensure out time is a future time
        if ($outTime < $inTime) {
            $outTime = $inTime; // Set out time to in time if it's earlier (to avoid negative duration)
        }
 
        $hours = round(($outTime - $inTime) / 3600, 2);
        $vehicleType = $row['vehicle_type'];

        // Set flat rates for less than 1 hour duration
        $flatRate2Wheeler = 20;
        $flatRate4Wheeler = 40;

        // Calculate parking fee based on time difference and vehicle type
        if ($hours < 1) {
            $parkingFee = ($vehicleType == '2-wheeler') ? $flatRate2Wheeler : $flatRate4Wheeler;
        } else {
            // Calculate parking fee based on regular rates for more than 1 hour duration
            $rate = ($vehicleType == '2-wheeler') ? 20 : 40;
            $parkingFee = $hours * $rate;
        }

        // Output the parking amount
        echo "Vehicle Number: " . $vehicleNumber . "<br>";
        echo "In Time: " . $row['in_time'] . "<br>";
        echo "Out Time: " . date("Y-m-d H:i:s", $outTime) . "<br>";
        echo "Parking Duration: " . $hours . " hours<br>";
        echo "Parking Fee: " . $parkingFee . " rupees<br>";

        // Delete the vehicle data from the database
        $deleteSql = "DELETE FROM vehicles WHERE vehicle_number = '$vehicleNumber'";
        if ($conn->query($deleteSql) === TRUE) {
            echo "successfull";
        } else {
            echo "Error deleting vehicle data: " . $conn->error;
        }
    } else {
        echo "Vehicle not found in the database.";
    }
}

$conn->close();
?>
