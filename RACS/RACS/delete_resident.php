<?php
// Include the file for your database connection
include_once('dbConnection.php');

// Check if resident_id is set and not empty
if (isset($_POST['resident_id']) && !empty($_POST['resident_id'])) {
    // Sanitize the input to prevent SQL injection
    $resident_id = $_POST['resident_id'];

    // Prepare a DELETE statement
    $query_delete_resident = "DELETE FROM residents WHERE resident_id = ?";
    $stmt_delete_resident = $conn->prepare($query_delete_resident);
    $stmt_delete_resident->bind_param("i", $resident_id);

    // Execute the DELETE statement
    if ($stmt_delete_resident->execute()) {
        // Deletion successful
        echo json_encode(array('status' => 'success', 'message' => 'Resident deleted successfully.'));
    } else {
        // Deletion failed
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete resident.'));
    }

    // Close the statement
    $stmt_delete_resident->close();
} else {
    // If resident_id is not set or empty
    echo json_encode(array('status' => 'error', 'message' => 'Invalid resident ID.'));
}

// Close the database connection
$conn->close();
?>
