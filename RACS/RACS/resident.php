<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="Experience the luxury of gated community living with our secure and exclusive housing community. Request permission to visit today!">
    <title>Secure Gated Community</title>
    <link rel="stylesheet" href="assets/web/assets/icons/icons2.css">
    <link rel="stylesheet" href="assets/parallax/jarallax.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/animatecss/animate.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&display=swap">
    </noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="preload" as="style" href="assets/style/css/additional.css">
    <link rel="stylesheet" href="assets/style/css/additional.css" type="text/css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 5%;
            margin-left: 15%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body style="background-image: linear-gradient(to right top, #0765f1, #007de8, #0087c2, #008995, #208872);">
    <?php include_once('header.php'); ?>
    <h2 style="margin-top: 15%; padding-left:6%;">Visitor Requests</h2>
    <table style="background-color: lightgrey;">
        <thead style="background-color:ghostwhite;">
            <tr>
                <th style="width: 150px;">Visitor IC Image</th> <!-- Set a fixed width for the column -->
                <th>Visitor Name</th>
                <th>Visitor Car Number Plate</th>
                <th>Visit Date</th>
                <th>Status</th>
                <th>Confirmation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection
            include("dbConnection.php");

            // Get the resident_id from the session
            $resident_id = $_SESSION['resident_id'];

            // Prepare the SQL query with a join on visitors and residents tables
            $query = "SELECT v.*, r.address AS resident_address
            FROM visitors v
            JOIN residents r ON v.visitor_address = r.address
            WHERE r.resident_id = ?
            ORDER BY v.created_at DESC";


            // Prepare the SQL statement
            $stmt = mysqli_prepare($conn, $query);

            // Bind the parameter
            mysqli_stmt_bind_param($stmt, 'i', $resident_id);

            // Execute the query
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if there are any records
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    // Output or process the data as needed
                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($row['visitor_ic_photo']) . "' alt='Visitor Photo'></td>";
                    echo "<td>" . htmlspecialchars($row['visitor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['visitor_car_plate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";

                    // Display confirmation status with check mark or cross mark as buttons
                    echo "<td>";
                    if ($row['status'] == 'confirmed') {
                        echo "<button style=color:dimgray; disabled>&#10004;</button>"; // Check mark
                        echo "<button style=color:dimgray; disabled>&#10008;</button>"; // Cross mark
                    } else if ($row['status'] == 'declined') {
                        echo "<button style=color:dimgray; disabled>&#10004;</button>";
                        echo "<button style=color:dimgray; disabled>&#10008;</button>";
                    } else {
                        // Pass 'true' for confirmation, 'false' for decline
                        echo "<button style=color:green; onclick='confirmVisit(" . $row['visitor_id'] . ", true)'>&#10004;</button>"; // Check mark as confirm button
                        echo "<button style='color:red;' onclick='confirmVisit(" . $row['visitor_id'] . ", false)'>&#10008;</button>"; // Cross mark as decline button
                    }
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No visitor requests found for the resident.</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <script>
        function confirmVisit(visitorId, isConfirmed) {
            // Send AJAX request to update status
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Update UI or provide feedback as needed
                        // For example, change button appearance
                        var button = document.querySelector('#visitor_' + visitorId);
                        button.textContent = isConfirmed ? "&#10004; Confirmed" : "&#10008; Declined";
                        button.disabled = true; // Disable the button after confirmation or decline
                    } else {
                        // Handle error response
                        alert("Error: " + response.message);
                    }
                } else {
                    // Handle HTTP error
                    alert("HTTP Error: " + xhr.status);
                }
            };

            xhr.onerror = function() {
                // Handle network error
                alert("Network Error");
            };

            // Send data as URL-encoded form data
            xhr.send('visitor_id=' + encodeURIComponent(visitorId) + '&confirmed=' + (isConfirmed ? '1' : '0'));
            location.reload();
        }
    </script>
</body>

</html>