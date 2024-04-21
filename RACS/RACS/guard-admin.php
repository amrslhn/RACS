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
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php include("header.php") ?>

<body style="background-image: linear-gradient(to right top, #0765f1, #007de8, #0087c2, #008995, #208872);">
    <?php include_once('header.php'); ?>
    <h2 style="margin-top: 15%; padding-left:6%;">Visitor List</h2>


    <script>
        const input = document.getElementById("search-input");
        const searchBtn = document.getElementById("search-btn");

        const expand = () => {
            searchBtn.classList.toggle("close");
            input.classList.toggle("square");
        };

        searchBtn.addEventListener("click", expand);
    </script>

    <table style="background-color: lightgrey;">
        <thead>
            <tr>
                <th>Visitor IC Image</th>
                <th>Visitor Name</th>
                <th>Visitor Car Number Plate</th>
                <th>Visit Date</th>
                <!-- <th>Status</th> -->
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

            // Initialize search variable
            $search = "";

            // Check if search query parameter is set
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $query = "SELECT * FROM visitors WHERE status = 'confirmed' AND visitor_car_plate LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
            } else {
                $query = "SELECT * FROM visitors WHERE status = 'confirmed' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
            }


            // Execute SQL query
            $result = mysqli_query($conn, $query);

            // Fetch and display visitor details
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($row['visitor_ic_photo']) . "' alt='Visitor Photo' style='width: 150px; height: auto;'></td>";
                    echo "<td>" . htmlspecialchars($row['visitor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['visitor_car_plate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No confirmed visitors found.</td></tr>";
            }
            ?>

        </tbody>
    </table>

    <!-- Pagination -->
    <div style="text-align: center; margin-top: 20px;">
        <?php
        // Calculate total number of pages
        $query_total = "SELECT COUNT(*) AS total FROM visitors WHERE status = 'confirmed'";
        $result_total = mysqli_query($conn, $query_total);
        $data_total = mysqli_fetch_assoc($result_total);
        $total_pages = ceil($data_total['total'] / $limit);

        // Render pagination links
        if ($total_pages > 1) {
            echo "<ul class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $page ? "active" : "";
                echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
            echo "</ul>";
        }
        ?>
    </div>

</body>

</html>