<!DOCTYPE html>
<html>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Include Bootstrap library for modal functionality -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="preload" as="style" href="assets/style/css/additional.css">
  <link rel="stylesheet" href="assets/style/css/additional.css" type="text/css">
  <link rel="stylesheet" href="style.css" type="text/css">

</head>

<body>
  <section class="menu menu2 cid-u5GGPVPcVj" once="menu" id="menu-5-u5GGPVPcVj">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
      <div class="container">
        <div class="navbar-brand">
          <span class="navbar-caption-wrap">
            <img src="assets/images/Racs.png" style="height:fit-content;">
            <!-- <a class="navbar-caption text-black display-4">RACS</a> -->
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
            // For Non-Logged-in Users
            echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="index.php">Home</a></li>';
            echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="login.php" aria-expanded="false">Login</a></li>';
            echo '<li class="nav-item"><a class="nav-link link text-black display-4" href="#visitor-form">Visit</a></li>';
            ?>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <section class="header16 cid-u5GGPVPj7f mbr-fullscreen mbr-parallax-background" id="hero-17-u5GGPVPj7f">
    <div class="mbr-overlay" style="opacity: 0.3; background-color: rgb(0, 0, 0);"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="content-wrap col-12 col-md-10">
          <h1 class="mbr-section-title mbr-fonts-style mbr-white mb-4 display-1">
            <strong>RACS</strong>
          </h1>
          <p class="mbr-fonts-style mbr-text mbr-white mb-4 display-7">Step into a world of exclusivity and charm in our
            gated community. Experience luxury living like never before!</p>
        </div>
      </div>
    </div>

    <div class="container" style="margin-bottom:-3%; margin-top:3%; color:white;">
      <div class="row justify-content-center">
        <!-- <div class="col-12 col-lg-8">
          <h2 class="mbr-section-title mbr-fonts-style align-center mb-4 display-2">Visitor Form</h2> -->
          <?php
          // Include database connection
          include("dbConnection.php");

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the inserted address
            $visitor_address = $_POST['visitor_address'];

            // Prepare and execute SQL query to check if the address exists
            $queryCheckAddress = "SELECT * FROM residents WHERE address = ?";
            $stmtCheckAddress = mysqli_prepare($conn, $queryCheckAddress);
            mysqli_stmt_bind_param($stmtCheckAddress, 's', $visitor_address);
            mysqli_stmt_execute($stmtCheckAddress);
            $resultCheckAddress = mysqli_stmt_get_result($stmtCheckAddress);

            // If address exists, display a message
            if (mysqli_num_rows($resultCheckAddress) > 0) {
              echo "<script>document.getElementById('visitor-address').placeholder = 'Address exists in the database.';</script>";
            } else {
              // If address not found, display an error message
              echo "<script>document.getElementById('visitor-address').placeholder = 'Address not found . Please confirm the address.';</script>";
            }
          }
          ?>
          <section id="visitor-form" class="header16 cid-u5GGPVPj7f mbr-fullscreen mbr-parallax-background">
          <div class="col-12 col-lg-8">
          <h2 class="mbr-section-title mbr-fonts-style align-center mb-4 display-2">Visitor Form</h2>
            <form action="save.php" id="#visitor-form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="form-group">
                <label for="visitor-name" class="mbr-fonts-style display-7">Name</label>
                <input type="text" class="form-control" id="visitor-name" name="visitor_name" required>
              </div>
              <div class="form-group">
                <label for="visitor-address" class="mbr-fonts-style display-7">Visiting Address</label>
                <input type="text" class="form-control" id="visitor-address" name="visitor_address" required>
              </div>
              <div class="form-group">
                <label for="visitor-car-no-plate" class="mbr-fonts-style display-7">Car No Plate</label>
                <input type="text" class="form-control" id="visitor-car-no-plate" name="visitor_car_no_plate" required>
              </div>
              <div class="form-group">
                <label for="visitor-ic-number" class="mbr-fonts-style display-7">IC Number</label>
                <input type="text" class="form-control" id="visitor-ic-number" name="visitor_ic_number" required>
              </div>
              <div class="form-group">
                <label for="visitor-ic-photo" class="mbr-fonts-style display-7">Upload IC Photo</label>
                <input type="file" class="form-control-file" id="visitor-ic-photo" name="visitor_ic_photo[]" accept="image/*" multiple required onchange="previewImages(event)">
                <div id="image-preview"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </section>
        </div>
      </div>
    </div>
  </section>

  <script>
    function previewImages(event) {
      var preview = document.getElementById('image-preview');
      preview.innerHTML = '';
      var files = event.target.files;

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function(e) {
          var img = document.createElement('img');
          img.src = e.target.result;
          img.style.maxWidth = '200px';
          img.style.marginRight = '10px';
          preview.appendChild(img);
        }

        reader.readAsDataURL(file);
      }
    }

    function validateForm() {
      var name = document.getElementById('visitor-name').value;
      var carPlate = document.getElementById('visitor-car-no-plate').value;
      var icNumber = document.getElementById('visitor-ic-number').value;

      if (name.length < 4) {
        alert("Name must be at least 4 characters long");
        return false;
      }

      if (carPlate.replace(/\s/g, '').length !== 7) {
        alert("Car number plate must have 7 characters excluding spaces");
        return false;
      }

      if (!/^(\d{6}-\d{2}-\d{4})$/.test(icNumber)) {
        alert("Invalid IC Number format. Correct format: 012233-01-0455");
        return false;
      }

      return true;
    }

    $(document).ready(function() {
      // Submit form using AJAX
      $('form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
          url: 'save.php',
          type: 'POST',
          data: formData,
          async: true,
          cache: false,
          contentType: false,
          processData: false,
          success: function(response) {
            try {
              // Check if response is in JSON format
              if (typeof response === 'object' && response !== null) {
                if (response.status === 'success') {
                  $('#successMessage').css('color', 'green').text(response.message);
                  $('#successModal').modal('show');
                } else {
                  $('#errorMessage').css('color', 'red').text(response.message);
                  $('#errorModal').modal('show');
                }
              } else {
                // Handle unexpected response format
                console.error('Unexpected response format:', response);
                $('#errorMessage').css('color', 'red').text('Unexpected response format');
                $('#errorModal').modal('show');
              }
            } catch (e) {
              console.error('Error parsing JSON response:', e);
              $('#errorMessage').css('color', 'red').text('Error parsing JSON response');
              $('#errorModal').modal('show');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            $('#errorMessage').css('color', 'red').text('AJAX Error: ' + textStatus);
            $('#errorModal').modal('show');
          }
        });
        return false;
      });

      // Close the modal when the close button is clicked
      $('.modal .close').click(function() {
        $('.modal').modal('hide');
      });
    });
  </script>



  <!-- Success Modal -->
  <center>
    <div class="modal fade" id="successModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding:15%" ;>
      <div class="modal-dialog modal-sm" role="document"> <!-- Changed class to modal-sm -->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Success</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p style="color: green;">Submitted successfully</p>
          </div>
        </div>
      </div>
    </div>


    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true" style="padding:15%;">
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

  </center>

  <section class="article8 cid-u5GGPVPopg" id="about-us-8-u5GGPVPopg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="card col-md-12 col-lg-10">
          <div class="card-wrapper">
            <div class="image-wrapper d-flex justify-content-center mb-4">
              <img src="assets/images/photo-1491438590914-bc09fcaaf77a.jpeg">
            </div>
            <div class="card-content-text">
              <h3 class="card-title mbr-fonts-style mbr-white mt-3 mb-4 display-2">
                <strong>Our Story Unveiled</strong>
              </h3>
              <div class="row card-box align-left">
                <div class="item features-without-image col-12">
                  <div class="item-wrapper">
                    <p class="mbr-text mbr-fonts-style display-7">Embark on a journey through time and discover the rich
                      history behind our prestigious community.</p>
                  </div>
                </div>
                <div class="item features-without-image col-12">
                  <div class="item-wrapper">
                    <p class="mbr-text mbr-fonts-style display-7">Immerse yourself in our core values of unity, respect,
                      and unparalleled elegance.</p>
                  </div>
                </div>
                <div class="item features-without-image col-12">
                  <div class="item-wrapper">
                    <p class="mbr-text mbr-fonts-style display-7">Join us in creating unforgettable memories and forging
                      lifelong friendships within our gated haven.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="gallery07 cid-u5GGPVQlSf" id="gallery-16-u5GGPVQlSf">
    <div class="container-fluid gallery-wrapper">
      <div class="row justify-content-center">
        <div class="col-12 content-head">
          <div class="mbr-section-head mb-5">
            <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
              <strong>Discover Our Oasis</strong>
            </h4>
          </div>
        </div>
      </div>
      <div class="grid-container">
        <div class="grid-container-3" style="transform: translate3d(-200px, 0px, 0px);">
          <div class="grid-item">
            <img src="assets/images/photo-1556484687-30636164638b.jpeg">
          </div>
          <div class="grid-item">
            <img src="assets/images/photo-1624279885560-e51bb6229243.jpeg">
          </div>
          <div class="grid-item">
            <img src="assets/images/photo-1469571486292-0ba58a3f068b.jpeg">
          </div>
          <div class="grid-item">
            <img src="assets/images/photo-1520857014576-2c4f4c972b57.jpeg">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="features15 cid-u5GGPVQ46X" id="features-30-u5GGPVQ46X">
    <div class="container">
      <div class="row">
        <div class="item features-without-image col-12 col-lg-4 active">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1529209076408-5a115ec9f1c6.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>Secure Community</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                <div>Exclusive access with resident confirmation</div>
              </h5>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-lg-4">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1461354464878-ad92f492a5a0.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>Login Portal</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                Residents only, no trespassers allowed
              </h5>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-lg-4">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1474649107449-ea4f014b7e9f.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>Visitor Form</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                Request permission to enter the community
              </h5>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-lg-4">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1664169507606-5e474cd27331.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>Luxury Homes</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                Elegant houses for the privileged few
              </h5>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-lg-4">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1553073520-80b5ad5ec870.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>Community Events</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                Exciting gatherings for residents and guests
              </h5>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-lg-4">
          <div class="item-wrapper">
            <div class="img-wrapper">
              <img src="assets/images/photo-1495474472287-4d71bcdd2085.jpeg">
            </div>
            <div class="card-box">
              <h4 class="card-title mbr-fonts-style mb-0 display-7">
                <strong>24/7 Security</strong>
              </h4>
              <h5 class="card-text mbr-fonts-style mt-2 display-7">
                Peace of mind with round-the-clock protection
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <style>

  </style>
  <section class="gallery09 cid-u5GGPVQamR" id="gallery-9-u5GGPVQamR">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-4 main-text">
          <div class="">
            <h5 class="mbr-section-title mbr-fonts-style mt-0 mb-4 display-2">
              <strong>Exclusive Views</strong>
            </h5>
            <h6 class="mbr-section-subtitle mbr-fonts-style mt-0 mb-4 display-7">
              Discover the breathtaking landscapes and stunning architecture of our gated community. See where luxury
              meets nature in perfect harmony.
            </h6>
          </div>
        </div>
        <div class="col-lg-8 side-features row">
          <div class="item features-image col-12 col-md-6 col-lg-6 active">
            <div class="item-wrapper">
              <div class="item-img">
                <img src="assets/images/photo-1468939332388-0f822117daad.jpeg">
              </div>
            </div>
          </div>
          <div class="item features-image col-12 col-md-6 col-lg-6 active">
            <div class="item-wrapper">
              <div class="item-img">
                <img src="assets/images/photo-1508785166660-30ce4484f45c.jpeg">
              </div>
            </div>
          </div>
          <div class="item features-image col-12 col-md-6 col-lg-6 active">
            <div class="item-wrapper">
              <div class="item-img">
                <img src="assets/images/photo-1528605248644-14dd04022da1.jpeg">
              </div>
            </div>
          </div>
          <div class="item features-image col-12 col-md-6 col-lg-6 active">
            <div class="item-wrapper">
              <div class="item-img">
                <img src="assets/images/photo-1624279869228-29323b002b54.jpeg">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="features10 cid-u5GGPVQgpI" id="metrics-2-u5GGPVQgpI">
    <div class="container">
      <div class="row justify-content-center">
        <div class="item features-without-image col-12 col-md-6 col-lg-4">
          <div class="item-wrapper">
            <div class="card-box align-left">
              <h5 class="card-title mbr-fonts-style display-1">
                <strong>1000+</strong>
              </h5>
              <p class="card-text mbr-fonts-style mb-3 display-7">
                Happy Residents
              </p>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-md-6 col-lg-4">
          <div class="item-wrapper">
            <div class="card-box align-left">
              <h5 class="card-title mbr-fonts-style display-1">
                <strong>500+</strong>
              </h5>
              <p class="card-text mbr-fonts-style mb-3 display-7">
                Exciting Events
              </p>
            </div>
          </div>
        </div>
        <div class="item features-without-image col-12 col-md-6 col-lg-4">
          <div class="item-wrapper">
            <div class="card-box align-left">
              <h5 class="card-title mbr-fonts-style display-1">
                <strong>99%</strong>
              </h5>
              <p class="card-text mbr-fonts-style mb-3 display-7">
                Visitor Approval Rate
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="list1 cid-u5GGPVQ8qb" id="faq-1-u5GGPVQ8qb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-10 m-auto">
          <div class="content">
            <div class="mbr-section-head align-left mb-5">
              <h3 class="mbr-section-title mb-2 mbr-fonts-style display-2">
                <strong>Curious Minds Ask</strong>
              </h3>
            </div>
            <div id="bootstrap-accordion_0" class="panel-group accordionStyles accordion" role="tablist" aria-multiselectable="true">
              <div class="card mb-3">
                <div class="card-header" role="tab" id="headingOne">
                  <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapse1_0" aria-expanded="false" aria-controls="collapse1">
                    <h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">
                      How to Visit?
                    </h6>
                    <span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
                  </a>
                </div>
                <div id="collapse1_0" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_0">
                  <div class="panel-body">
                    <p class="mbr-fonts-style panel-text display-7">
                      To visit our exclusive gated community, simply fill out the permission form and await approval
                      from our residents.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card mb-3">
                <div class="card-header" role="tab" id="headingOne">
                  <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapse2_0" aria-expanded="false" aria-controls="collapse2">
                    <h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">
                      What to Expect?
                    </h6>
                    <span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
                  </a>
                </div>
                <div id="collapse2_0" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_0">
                  <div class="panel-body">
                    <p class="mbr-fonts-style panel-text display-7">
                      Expect a world of luxury, security, and vibrant community living within our gates.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card mb-3">
                <div class="card-header" role="tab" id="headingOne">
                  <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapse3_0" aria-expanded="false" aria-controls="collapse3">
                    <h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">
                      Why Choose Us?
                    </h6>
                    <span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
                  </a>
                </div>
                <div id="collapse3_0" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_0">
                  <div class="panel-body">
                    <p class="mbr-fonts-style panel-text display-7">
                      Choose us for a lifestyle that blends privacy, elegance, and a sense of belonging like no other.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card mb-3">
                <div class="card-header" role="tab" id="headingOne">
                  <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapse4_0" aria-expanded="false" aria-controls="collapse4">
                    <h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">
                      Community Rules?
                    </h6>
                    <span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
                  </a>
                </div>
                <div id="collapse4_0" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_0">
                  <div class="panel-body">
                    <p class="mbr-fonts-style panel-text display-7">
                      Our community thrives on respect, harmony, and a shared commitment to creating unforgettable
                      memories.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card mb-3">
                <div class="card-header" role="tab" id="headingOne">
                  <a role="button" class="panel-title collapsed" data-toggle="collapse" data-bs-toggle="collapse" data-core="" href="#collapse5_0" aria-expanded="false" aria-controls="collapse5">
                    <h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">
                      Any Restrictions?
                    </h6>
                    <span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
                  </a>
                </div>
                <div id="collapse5_0" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" data-bs-parent="#bootstrap-accordion_0">
                  <div class="panel-body">
                    <p class="mbr-fonts-style panel-text display-7">
                      While we embrace diversity, we prioritize safety and harmony to ensure every resident feels at
                      home.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="image02 cid-u5GGPVQk7Q mbr-fullscreen mbr-parallax-background" id="image-13-u5GGPVQk7Q">
    <div class="container">
      <div class="row"></div>
    </div>
  </section>

  <section class="footer2 cid-u5GGPVRid3" id="footer-5-u5GGPVRid3">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 center mt-2 mb-3">
          <p class="mbr-fonts-style copyright mb-0 display-7">
            © 2024 RACS. All Rights Reserved.
          </p>
        </div>
        <div class="col-12 col-lg-6 center">
          <div class="row-links mt-2 mb-3">
            <ul class="row-links-soc">
              <li class="row-links-soc-item mbr-fonts-style display-7">
                <a href="index.php" class="text-white">Home</a>
              </li>
              <li class="row-links-soc-item mbr-fonts-style display-7">
                <a href="#gallery-16-u5GGPVQlSf" class="text-white">About</a>
              </li>
              <!-- <li class="row-links-soc-item mbr-fonts-style display-7">
                <a href="#" class="text-white">Contact</a>
              </li> -->
              <li class="row-links-soc-item mbr-fonts-style display-7">
                <a href="#faq-1-u5GGPVQ8qb" class="text-white">FAQ</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="assets/parallax/jarallax.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/dropdown/js/navbar-dropdown.js"></script>
  <script src="assets/scrollgallery/scroll-gallery.js"></script>
  <script src="assets/mbr-switch-arrow/mbr-switch-arrow.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/ytplayer/index.js"></script>
  <script src="assets/theme/js/script.js"></script>
  <script src="assets/formoid/formoid.min.js"></script>

  <script>
    (function() {
      var animationInput = document.createElement('input');
      animationInput.setAttribute('name', 'animation');
      animationInput.setAttribute('type', 'hidden');
      document.body.append(animationInput);
    })();
  </script>
</body>

</html>