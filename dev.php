<?php
session_start();


include('connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit(); // Ensure that script execution stops here
}

// Retrieve the first name from the user information
$firstName = $_SESSION['user']['firstnme']; // Assuming the first name is stored in the 'first_name' field

// Set the page title
$pageTitle = "Welcome, $firstName";

if(isset($_POST['logout'])){
  // Destroy the session
  session_unset();
  session_destroy();
  
  // Redirect the user to the login page
  header("Location: index.php");
  exit(); // Ensure that script execution stops here
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee.com</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    /* Added CSS for fullscreen background image */
    body {
      position: relative;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .background-image {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('kape.png') no-repeat center center;
      background-size: cover;
      z-index: -1;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6); /* Adjust the opacity as needed */
      z-index: -1; /* Set a lower z-index */
    }

    .navbar {
      background-color: rgba(231, 175, 122, 0.9);
      height: 80px;
      margin: 20px;
      border-radius: 16px;
      padding: 0.5rem;
      position: relative;
      z-index: 1;
    }

    .navbar-brand {
      font-family: 'cursive', sans-serif;
    }

    .login-button {
      background-color: brown;
      color: white;
      font-size: 14px;
      padding: 8px 20px;
      border-radius: 50px;
      text-decoration: none;
      transition: 0.3s background-color;
    }

    .login-button:hover {
      background-color: brown;
    }

    .navbar-toggler {
      border: none;
      font-size: 1.25rem;
    }

    .navbar-toggler:focus,
    .btn-close:focus {
      box-shadow: none;
      outline: none;
    }

    .nav-link {
      color: #000000;
      outline: none;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      color: black;
    }

    .nav-link::before {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0%;
      transform: translateX(-50);
      width: 100%;
      height: 2px;
      background-color: brown;
      visibility: hidden;
      transition: 0.3s ease-in-out;
    }

    .nav-link:hover::before,
    .nav-link.active::before {
      width: 100%;
      visibility: visible;
    }

    .about-text {
      padding: 20px; /* Added padding for better spacing */
    }
  </style>
</head>

<body>
  <!-- Background Image -->
  <div class="background-image"></div>

  <!-- Navigation Section -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand me-auto" href="#">
        <img src="logoss.png" alt="Coffee Shop Logo" height="60" class="d-inline-block align-text-top ">
      </a>
      The Coffee Shop
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Welcome!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="scratch.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="scratch.php">Menu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="dev.php">Developers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="login.php">View Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="profile.php">My Profile</a>
            </li>
          </ul>
        </div>
      </div>
      <form action="" method="post">
        <button type="submit" class="login-button" name="logout">Log out</button>
      </form>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Content Section -->
  
  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
