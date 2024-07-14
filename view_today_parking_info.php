<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Parking Info</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Light gray color for the background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            opacity: 0;
            animation: fadeIn 1s ease forwards; /* Fade-in animation */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            background-color: #fff; /* White background for cells */
        }

        th {
            background-color: #f2f2f2;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-box">
            <h1 class="title">Today's Parking Info</h1>

            <?php
            // Establish a database connection (modify the connection details accordingly)
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "park";

            $conn = new mysqli($host, $username, $password, $database);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from both tables using UNION
            $sql = "SELECT vehicle_number, vehicle_type, DATE_FORMAT(in_time, '%Y-%m-%d') AS vehicle_in_time
                    FROM vehicles
                    WHERE DATE_FORMAT(in_time, '%Y-%m-%d') = CURDATE()
                    
                    UNION

                    SELECT vehicle_number, vehicle_type, DATE_FORMAT(in_time, '%Y-%m-%d') AS vehicle_in_time
                    FROM bookings
                    WHERE DATE_FORMAT(in_time, '%Y-%m-%d') = CURDATE()";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>Vehicle Number</th>
                            <th>Vehicle Type</th>
                            <th>In Time</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['vehicle_number']}</td>
                            <td>{$row['vehicle_type']}</td>
                            <td>{$row['vehicle_in_time']}</td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "No records found for today's parking.";
            }

            // Close the database connection
            $conn->close();
            ?>

        </div>
    </div>
</body>

</html>
