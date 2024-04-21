<?php
// Include the file for your database connection
include_once('dbConnection.php');

// Initialize variables for error handling
$errorMessage = "";
$errorMessageAddress = "";
$residentAddedSuccessfully = false; // Flag to track successful resident addition

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $address = $_POST['address'];

    $query_check_email = "SELECT * FROM residents WHERE email = ?";
    $stmt_check_email = $conn->prepare($query_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    $query_check_address = "SELECT * FROM residents WHERE LOWER(address) = LOWER(?)";
    $stmt_check_address = $conn->prepare($query_check_address);
    $stmt_check_address->bind_param("s", $address);
    $stmt_check_address->execute();
    $result_check_address = $stmt_check_address->get_result();

    if ($result_check_email->num_rows > 0) {
        echo "emailExists";
    } elseif ($result_check_address->num_rows > 0) {
        echo "addressExists";
    } else {
        echo "notExists";
    }

    $stmt_check_email->close();
    $stmt_check_address->close();
}
// Get visitor count
$query_visitor_confirmed_count = "SELECT COUNT(*) AS visitor_confirmed_count FROM visitors WHERE status = 'confirmed'";
$result_visitor_confirmed_count = $conn->query($query_visitor_confirmed_count);
$visitor_confirmed_count = $result_visitor_confirmed_count->fetch_assoc()['visitor_confirmed_count'];

$query_visitor_declined_count = "SELECT COUNT(*) AS visitor_declined_count FROM visitors WHERE status = 'declined'";
$result_visitor_declined_count = $conn->query($query_visitor_declined_count);
$visitor_declined_count = $result_visitor_declined_count->fetch_assoc()['visitor_declined_count'];

// Get resident count
$query_resident_count = "SELECT COUNT(*) AS resident_count FROM residents";
$result_resident_count = $conn->query($query_resident_count);
$resident_count = $result_resident_count->fetch_assoc()['resident_count'];

// Close the database connection
// $conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="Experience the luxury of gated community living with our secure and exclusive housing community. Request permission to visit today!">

    <title>Admin Dashboard - Secure Gated Community</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preload" as="style" href="assets/style/css/additional.css">
    <link rel="stylesheet" href="assets/style/css/additional.css" type="text/css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .password-container {
            position: sticky;
        }

        #togglePassword {
            position: absolute;
            right: 5px;
            /* Adjust as needed */
            bottom: 30%;
            transform: translateY(50%);
            z-index: 1;
            background-color: transparent;
            border: none;
        }
    </style>
</head>

<body style="background-image: linear-gradient(to right top, #0765f1, #007de8, #0087c2, #008995, #208872);">
    <?php include_once('header.php') ?>

    <div class="dashboard" style="margin-top: 15%;">
        <h3>Admin Dashboard</h3>
        <div>
            <h4>Confirmed Visitor Count: <span id="confirmedVisitorCount"><?php echo $visitor_confirmed_count; ?></span></h4>
            <h4>Declined Visitor Count: <span id="declinedVisitorCount"><?php echo $visitor_declined_count; ?></span></h4>
            <h4>Resident Count: <span id="residentCount"><?php echo $resident_count; ?></span></h4>
        </div>
    </div>

    <div id="residentTable">
        <center style="margin-bottom:-3%; margin-top:2%;">
            <h2>Residents</h2>
        </center>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                include("dbConnection.php");

                // Pagination setup
                $limit = 50;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Query to fetch residents
                $query = "SELECT * FROM residents ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

                // Execute SQL query
                $result = mysqli_query($conn, $query);

                // Fetch and display resident details
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                        echo "<td><button onclick=\"deleteResident(" . $row['resident_id'] . ")\">Delete</button></td>"; // Delete button with resident ID as parameter
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No Residents found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteResident(resident_id) {
            if (confirm("Are you sure you want to delete this resident?")) {
                // Send an AJAX request to delete the resident
                $.ajax({
                    url: 'delete_resident.php', // Assuming delete operation is handled in this file
                    type: 'POST',
                    data: {
                        resident_id: resident_id
                    },
                    success: function(response) {
                        // Handle success response
                        alert("Resident deleted successfully.");
                        location.reload(); // Refresh the page to reflect changes
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error("Error deleting resident:", error);
                        alert("An error occurred while deleting the resident. Please try again later.");
                    }
                });
            }
        }
    </script>

    <br>

    <div id="visitorTable">
        <center style="margin-bottom:-3%; margin-top:2%;">
            <h2>Visitors</h2>
        </center>
        <table border="1">
            <thead>
                <tr>
                    <th>Visitor Photo</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Car Plate Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch visitor data from the database
                $query_visitors = "SELECT * FROM visitors";
                $result_visitors = $conn->query($query_visitors);
                if ($result_visitors->num_rows > 0) {
                    while ($row = $result_visitors->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img src='" . htmlspecialchars($row['visitor_ic_photo']) . "' alt='Visitor Photo' style='width: 100px; height: auto;'></td>";
                        echo "<td>" . htmlspecialchars($row['visitor_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['visitor_ic_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['visitor_address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['visitor_car_plate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No visitors found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <center>
        <h2 style="margin-top: 20px; padding:2%;">Add Resident</h2>
    </center>
    <form id="addResidentForm" action="save_resident.php" method="POST" onsubmit="return validateForm()">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <div id="emailError" style="color: red;"><?php echo $errorMessage; ?></div>
        <label for="phoneNumber">Phone Number:</label><br>
        <input type="text" id="phoneNumber" name="phoneNumber" required><br>
        <div id="phoneNumberError" style="color: red;"></div>
        <label for="address">Address:</label><br>
        <textarea id="address" name="address" required></textarea><br>
        <div id="addressError" style="color: red;"><?php echo $errorMessageAddress; ?></div>

        <label for="password">Password:</label><br>
        <div class="password-container">
            <input type="password" id="password" name="password" class="form-control" required>
            <button type="button" id="togglePassword" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></button>
        </div>
        <div id="passwordError" style="color: red;"></div>



        <input type="submit" value="Submit">
    </form>


    <!-- Success Modal -->
    <div class="modal fade" id="successModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding:20%">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color: green;" id="successMessage"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true" style="padding:20%">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color: red;" id="errorMessage"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                var passwordField = $('#password');
                var passwordToggle = $(this).find('i');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    passwordToggle.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    passwordToggle.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
        // Form validation function
        function validateForm() {
            var email = document.getElementById("email").value;
            var phoneNumber = document.getElementById("phoneNumber").value;
            var password = document.getElementById("password").value;
            var passwordError = document.getElementById("passwordError");
            var emailError = document.getElementById("emailError");
            var phoneNumberError = document.getElementById("phoneNumberError");
            var regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            var regexPhoneNumber = /^\d{3}-\d{4}\s\d{3}$/;
            var regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_])[A-Za-z\d@_]{8,}$/;

            var isValid = true;

            if (!regexEmail.test(email)) {
                emailError.innerText = "Invalid email format.";
                isValid = false;
            } else {
                emailError.innerText = "";
            }

            if (!regexPhoneNumber.test(phoneNumber)) {
                phoneNumberError.innerText = "Invalid phone number format. Please enter in the format 011-1111 111.";
                isValid = false;
            } else {
                phoneNumberError.innerText = "";
            }

            if (!regexPassword.test(password)) {
                passwordError.innerText = "Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one digit, and one special character (@ or _).";
                isValid = false;
            } else {
                passwordError.innerText = "";
            }

            return isValid;
        }

        $(document).ready(function() {
            // Submit form using AJAX
            $('form').submit(function(event) {
                event.preventDefault();
                if (!validateForm()) {
                    // Form validation failed, do not submit
                    return;
                }
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: 'save_resident.php',
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        try {
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === 'success') {
                                $('#successMessage').text(jsonResponse.message); // Set success message
                                $('#successModal').modal('show'); // Show the success modal
                            } else if (jsonResponse.status === 'error') {
                                console.error('Error: ' + jsonResponse.message);
                                $('#errorMessage').text(jsonResponse.message); // Set error message
                                $('#errorModal').modal('show'); // Show the error modal
                            } else {
                                // throw new Error('Unexpected response format');
                            }
                        } catch (error) {
                            console.error('Unexpected response format: ' + response);
                            $('#errorMessage').text('Unexpected response from the server.'); // Set error message
                            $('#errorModal').modal('show'); // Show the error modal
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error: ' + textStatus, errorThrown);
                        $('#errorMessage').text('AJAX Error: ' + textStatus); // Set error message
                        $('#errorModal').modal('show'); // Show the error modal
                    }
                });
                return false;
            });

            // Close the modal when the close button is clicked
            $('.modal .close').click(function() {
                $('.modal').modal('hide');
                location.reload(); // Reload the page after modal is closed
            });
        });
    </script>
    <br>


    <br>


</body>

</html>