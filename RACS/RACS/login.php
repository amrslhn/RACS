<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Assuming your database connection is established already
include("dbConnection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get email and password from the form
  $email = $_POST['Email'];
  $password = $_POST['userPassword'];

  // Prepare the SQL query using prepared statements for admins
  $queryAdmin = "SELECT admin_id, password FROM admins WHERE email = ?";
  $stmtAdmin = mysqli_prepare($conn, $queryAdmin);

  // Bind the parameters for admins
  mysqli_stmt_bind_param($stmtAdmin, 's', $email);
  mysqli_stmt_execute($stmtAdmin);

  // Get the result for admins
  $resultAdmin = mysqli_stmt_get_result($stmtAdmin);

  if (mysqli_num_rows($resultAdmin) == 1) {
    // If credentials match for admins, fetch admin_id and hashed password
    $row = mysqli_fetch_assoc($resultAdmin);
    $hashedPassword = $row['password'];

    // Verify hashed password
    if (password_verify($password, $hashedPassword)) {
      // Store admin_id in session
      $_SESSION['admin_id'] = $row['admin_id'];

      // Redirect to appropriate admin page based on admin_id
      if ($row['admin_id'] == 1) {
        header('Location: admin.php');
      } elseif ($row['admin_id'] == 2) {
        header('Location: guard-admin.php');
      }
      exit();
    } else {
      // If password does not match, display an error message
      echo 'Invalid email or password';
    }
  } else {
    // Prepare the SQL query using prepared statements for residents
    $queryResident = "SELECT resident_id, password FROM residents WHERE email = ?";
    $stmtResident = mysqli_prepare($conn, $queryResident);

    // Bind the parameters for residents
    mysqli_stmt_bind_param($stmtResident, 's', $email);
    mysqli_stmt_execute($stmtResident);

    // Get the result for residents
    $resultResident = mysqli_stmt_get_result($stmtResident);

    if (mysqli_num_rows($resultResident) == 1) {
      // If credentials match for residents, fetch resident_id and hashed password
      $row = mysqli_fetch_assoc($resultResident);
      $hashedPassword = $row['password'];

      // Verify hashed password
      if (password_verify($password, $hashedPassword)) {
        // If password matches, store resident_id in session
        $_SESSION['resident_id'] = $row['resident_id'];
        // Redirect to resident.php (or whatever the resident page is)
        header('Location: resident.php');
        exit();
      } else {
        // If password does not match, display an error message
        echo 'Invalid email or password';
      }
    } else {
      // If credentials do not match either admins or residents, display an error message
      echo 'Invalid email or password';
    }
  }
}
?>


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
</head>

<body style="background-image: url('assets/images/photo-1642148516325-ee2ba0a07e61.jpeg'); background-size: cover;">




  <section class="menu menu2 cid-u5GGPVPcVj" once="menu" id="menu-5-u5GGPVPcVj">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
      <div class="container">
        <div class="navbar-brand">
          <span class="navbar-caption-wrap">
            <a class="navbar-caption text-black display-4">RACS</a>
          </span>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
            <li class="nav-item">
              <a class="nav-link link text-black display-4" href="index.php">Home</a>
            </li>
            <?php
            // Check if admin or user ID is saved in session
            if (isset($_SESSION['admin_id']) || isset($_SESSION['resident_id'])) {
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="logout.php">Logout</a></li>';
            } else {
              echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="login.php" aria-expanded="false">Login</a></li>';
            }
            ?>
            <!-- <li class="nav-item">
              <a class="nav-link link text-black display-4" href="#visitor-form">Visit</a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <div class="wrapper" style="margin-top:10%">
    <div class="inner-warpper text-center">
      <h2 class="title">Login to your account</h2>
      <form action="login.php" id="formvalidate" method="POST">
        <div class="input-group">
          <label class="palceholder" for="Email">Email</label>
          <input class="form-control" name="Email" id="Email" type="text" placeholder="" />
          <span class="lighting"></span>
        </div>
        <div class="input-group">
          <label class="palceholder" for="userPassword">Password</label>
          <input class="form-control" name="userPassword" id="userPassword" type="password" placeholder="" />
          <span class="lighting"></span>
        </div>

        <button type="submit" id="login" style="color:firebrick">Login</button>

      </form>
    </div>
  </div>

  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'></script>
  <script src="./script.js"></script>
</body>

</html>