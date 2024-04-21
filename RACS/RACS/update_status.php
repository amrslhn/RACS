<?php
// Include database connection
include("dbConnection.php");

// Check if visitor_id and confirmation status are provided
if (isset($_POST['visitor_id'], $_POST['confirmed'])) {
    // Get visitor_id and confirmation status
    $visitor_id = $_POST['visitor_id'];
    $confirmed = $_POST['confirmed'];

    // Define the status based on confirmation status
    $status = $confirmed ? 'confirmed' : 'declined';

    // Update status in the database
    $query = "UPDATE visitors SET status = ? WHERE visitor_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $visitor_id);
    if (mysqli_stmt_execute($stmt)) {
        // If update is successful, return success response
        header('Content-Type: application/json');
        echo json_encode(array("status" => "success"));
        exit();
    } else {
        // If update fails, return error response
        header('Content-Type: application/json');
        echo json_encode(array("status" => "error", "message" => "Failed to update status in the database"));
        exit();
    }
} else {
    // If visitor_id or confirmation status is not provided, return error response
    header('Content-Type: application/json');
    echo json_encode(array("status" => "error", "message" => "Visitor ID or confirmation status not provided"));
    exit();
}
?>
