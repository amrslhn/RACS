<?php
include_once('dbConnection.php');

// Initialize variables for error handling
$errorMessage = "";
$errorMessageAddress = "";

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract email and address from POST data
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Prepare and execute query to check if email already exists
    $query_check_email = "SELECT * FROM residents WHERE email = ?";
    $stmt_check_email = $conn->prepare($query_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    // Prepare and execute query to check if address already exists
    $query_check_address = "SELECT * FROM residents WHERE LOWER(address) = LOWER(?)";
    $stmt_check_address = $conn->prepare($query_check_address);
    $stmt_check_address->bind_param("s", $address);
    $stmt_check_address->execute();
    $result_check_address = $stmt_check_address->get_result();

    // Check if email or address already exists
    if ($result_check_email->num_rows > 0) {
        // Email already exists, return error response
        echo json_encode(array("status" => "error", "message" => "Email already exists."));
        exit();
    } elseif ($result_check_address->num_rows > 0) {
        // Address already exists, return error response
        echo json_encode(array("status" => "error", "message" => "Address already exists."));
        exit();
    } else {
        // Close prepared statements for email and address checking
        $stmt_check_email->close();
        $stmt_check_address->close();

        // Extract additional data from POST
        $name = $_POST['name'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute query to insert new resident
        $query_insert_resident = "INSERT INTO residents (name, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert_resident = $conn->prepare($query_insert_resident);
        $stmt_insert_resident->bind_param("sssss", $name, $email, $phoneNumber, $address, $hashedPassword);

        // Execute query to insert new resident
        if ($stmt_insert_resident->execute()) {
            // Resident added successfully, return success response
            echo json_encode(array("status" => "success", "message" => "Resident added successfully."));
            exit();
        } else {
            // Failed to add resident, return error response
            echo json_encode(array("status" => "error", "message" => "Failed to add resident."));
            exit();
        }
    }
}

// Close the database connection
$conn->close();
?>
