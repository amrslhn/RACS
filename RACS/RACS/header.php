<?php session_start(); ?>

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
  <link rel="preload" as="style" href="assets/style/css/additional.css">
  <link rel="stylesheet" href="assets/style/css/additional.css" type="text/css">
  <link rel="stylesheet" href="style.css">
  <!-- Include Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>


  <style>
    .navbar-nav {
      display: flex;
      align-items: center;
      /* Align items vertically */
    }

    .search-container {
      margin-left: auto;
      /* Move search container to the right */
      display: flex;
      align-items: center;
      /* Align items vertically */
    }

    .search-container input[type="text"] {
      padding: 10px;
      width: 200px;
      /* Adjust width as needed */
      border: none;
      border-radius: 5px;
      margin-right: 5px;
    }

    .search-container button {
      padding: 10px;
      background: #ddd;
      font-size: 19px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .search-container button:hover {
      background: white;
    }

    /* Hide scroll bar */
    ::-webkit-scrollbar {
      display: none;
    }

    /* Adjust alignment for smaller screens */
    @media (max-width: 768px) {
      .search-container {
        margin-top: 10px;
        margin-left: 0;
        /* Reset margin */
      }

      .search-container input[type="text"] {
        width: calc(100% - 40px);
        /* Adjust width to fill the available space */
        margin-right: 0;
        /* Remove margin for better alignment */
      }
    }
  </style>


</head>

<body>
  <section class="menu menu2 cid-u5GGPVPcVj" once="menu" id="menu-5-u5GGPVPcVj">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
      <div class="container">
        <div class="navbar-brand">
          <span class="navbar-caption-wrap">
            <a class="navbar-caption text-black display-4">RACS</a>
          </span>
        </div>
        <!-- Toggle Button for Collapsible Navbar -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
            <?php
            if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == 1) {
              // For Admin Users
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="admin.php">Home</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="#addResidentForm">Add Resident</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="#residentTable">View Residents</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="#visitorTable">View Visitors</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="logout.php">Logout</a></li>';
            }elseif (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == 2) {
              // For Guard Admin Users
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="guard-admin.php">Home</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="logout.php">Logout</a></li>';
              // Move the search container here
              echo '<div class="search-container">
                        <form action="guard-admin.php">
                            <input type="text" placeholder="Search.." name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>';          
            } elseif (isset($_SESSION['resident_id'])) {
              // For Resident Users
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="resident.php">Home</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="logout.php">Logout</a></li>';
            } else {
              // For Non-Logged-in Users
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="index.php">Home</a></li>';
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="login.php" aria-expanded="false">Login</a></li>';
              echo ' <li class="nav-item"><a class="nav-link link text-black display-4" href="#visitor-form">Visit</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <!-- Your Content Goes Here -->

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Script for Toggle Button -->
  <script>
    $(document).ready(function() {
      // Select the navbar-toggler element and attach a click event handler
      $(".navbar-toggler").click(function(event) {
        // Prevent default behavior of the anchor link
        event.preventDefault();
        // Toggle the 'show' class on the navbar-collapse element
        $("#navbarSupportedContent").toggleClass("show");
      });

      // Close the collapsed navbar when a nav-item is clicked
      $(".navbar-nav .nav-link").click(function() {
        // Check if the navbar-collapse is open
        if ($("#navbarSupportedContent").hasClass("show")) {
          // Collapse the navbar
          $("#navbarSupportedContent").collapse('hide');
        }
      });
    });
  </script>

</body>

</html>