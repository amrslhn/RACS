<?php
include("dbConnection.php");

// Initialize response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $visitor_name = $_POST['visitor_name'];
    $visitor_address = $_POST['visitor_address'];
    $visitor_car_no_plate = $_POST['visitor_car_no_plate'];
    $visitor_ic_number = $_POST['visitor_ic_number'];

    // Check if the address exists in the database
    $queryCheckAddress = "SELECT * FROM residents WHERE address = ?";
    $stmtCheckAddress = mysqli_prepare($conn, $queryCheckAddress);
    mysqli_stmt_bind_param($stmtCheckAddress, 's', $visitor_address);
    mysqli_stmt_execute($stmtCheckAddress);
    $resultCheckAddress = mysqli_stmt_get_result($stmtCheckAddress);

    if (mysqli_num_rows($resultCheckAddress) > 0) {
        // Address exists, proceed with saving data
        // Save form data to database
        $query = "INSERT INTO visitors (visitor_name, visitor_address, visitor_car_plate, visitor_ic_number) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssss', $visitor_name, $visitor_address, $visitor_car_no_plate, $visitor_ic_number);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Save IC photo directory path to the database
            $target_dir = "ic_photos/" . $visitor_address . "/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory recursively
            }

            $photo_paths = array();
            foreach ($_FILES['visitor_ic_photo']['tmp_name'] as $key => $tmp_name) {
                $target_file = $target_dir . basename($_FILES['visitor_ic_photo']['name'][$key]);
                if (move_uploaded_file($_FILES['visitor_ic_photo']['tmp_name'][$key], $target_file)) {
                    $photo_paths[] = $target_file; // Store the directory path
                } else {
                    // Handle file upload failure
                    $response['status'] = "error";
                    $response['message'] = "Failed to move uploaded file";
                    echo json_encode($response);
                    exit();
                }
            }

            // Construct the photo paths string
            $photo_paths_string = implode(",", $photo_paths);

            // Update the database with the directory paths of the uploaded photos
            $update_query = "UPDATE visitors SET visitor_ic_photo = ? WHERE visitor_address = ?";
            $stmt_update = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt_update, 'ss', $photo_paths_string, $visitor_address);

            // Execute the update query
            if (mysqli_stmt_execute($stmt_update)) {
                // Retrieve resident's email from the database
                $resident_email_query = "SELECT email FROM residents WHERE address = ?";
                $stmt_resident_email = mysqli_prepare($conn, $resident_email_query);
                mysqli_stmt_bind_param($stmt_resident_email, 's', $visitor_address);
                mysqli_stmt_execute($stmt_resident_email);
                $result_resident_email = mysqli_stmt_get_result($stmt_resident_email);
                $row_resident_email = mysqli_fetch_assoc($result_resident_email);
                $resident_email = $row_resident_email['email'];

                // Include residents_notification.php and send email
                require_once("residents_notification.php");
                sendNotificationEmail($resident_email, $visitor_name, $visitor_address);

                // Return success response
                $response['status'] = "success";
                $response['message'] = "Submitted successfully";
            } else {
                // If update fails, return error response
                $response['status'] = "error";
                $response['message'] = "Failed to update photo paths in the database";
            }
        } else {
            // If insertion fails, return error response
            $response['status'] = "error";
            $response['message'] = "Failed to insert data into the database";
        }
    } else {
        // Address not found in the database, return error response
        $response['status'] = "error";
        $response['message'] = "Address not found. Please check the address.";
    }
} else {
    // Invalid request method, return error response
    $response['status'] = "error";
    $response['message'] = "Invalid request method.";
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
