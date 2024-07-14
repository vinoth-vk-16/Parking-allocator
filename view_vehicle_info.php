<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicle Info</title>
    <link rel="icon" href="car-icon.jpg" type="image/x-icon">
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
    <table>
        <thead>
            <tr>
                <th>Vehicle Number</th>
                <th>In Time</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "park";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch vehicle information from the database
            $sql = "SELECT vehicle_number, in_time FROM vehicles";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display the information in a table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["vehicle_number"] . "</td><td>" . $row["in_time"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No vehicle information available.</td></tr>";
            }

            $conn->close();
            ?>

        </tbody>
    </table>
</body>

</html>
