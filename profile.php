<?php
session_start();

include('connect.php'); // Assuming this file contains your database connection

if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit(); // Ensure that script execution stops here
}

$errorMessage = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle data update
    $customer_id = $_SESSION['user']['customer_id'];
    $email = $_POST['email'];
    
    // Check if 'new_password' key exists in the $_POST array
    if (isset($_POST['new_password'])) {
        $new_password = $_POST['new_password']; // Change variable name to distinguish from the existing password field

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update email and password in the database
        $sql = "UPDATE users SET email = :email, password = :password WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
    } else {
        // Update email only if no new password is provided
        $sql = "UPDATE users SET email = :email WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
    }
}

if(isset($_POST['logout'])){
    // Destroy the session
    session_unset();
    session_destroy();
    
    // Redirect the user to the login page
    header("Location: index.php");
    exit(); // Ensure that script execution stops here
  }

// Fetch user data from the session
$customer_id = $_SESSION['user']['customer_id']; // Changed variable name
$stmt = $conn->prepare("SELECT * FROM users WHERE customer_id = :customer_id"); // Fixed column name
$stmt->bindParam(':customer_id', $customer_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-image: url('kape.png');
            background-size: cover;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            background-color: #d2b48c; /* Coffee color */
        }
        .exit-button {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 9999; /* Ensure the button stays on top of other elements */
            background-color: #8b4513; /* Brown color */
            border-color: #8b4513; /* Brown color */
        }
        .card-header.bg-primary {
            background-color: #8b4513 !important; /* Brown color */
        }
        .card-header.bg-primary.text-white {
            color: #fff !important; /* White color */
        }
        .card-body {
            background-color: #d2b48c; /* Coffee color */
        }
        .btn-success {
            background-color: #8b4513; /* Brown color */
            border-color: #8b4513; /* Brown color */
        }
        .btn-success:hover {
            background-color: #8b4513; /* Brown color */
            border-color: #8b4513; /* Brown color */
        }
        .btn-secondary {
            background-color: #6c757d; /* Gray color */
            border-color: #6c757d; /* Gray color */
        }
        .btn-primary {
            background-color: #8b4513; /* Brown color */
            border-color: #8b4513; /* Brown color */
        }
        .btn-danger {
            background-color: #dc3545; /* Red color */
            border-color: #dc3545; /* Red color */
        }
        .form-label {
            color: #4b3a2a; /* Dark brown color */
        }
        .form-control {
            background-color: #f8f9fa; /* Light gray color */
        }
    </style>
</head>
<body>
<a href="scratch.php" class="btn btn-danger exit-button">Exit</a>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Account Information</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($user['firstnme']) ? $user['firstnme'] : ''; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($user['lasttnme']) ? $user['lasttnme'] : ''; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="region" class="form-label">Region:</label>
                                <input type="text" class="form-control" id="region" name="region" value="<?php echo isset($user['region']) ? $user['region'] : ''; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="province" class="form-label">Province:</label>
                                <input type="text" class="form-control" id="province" name="province" value="<?php echo isset($user['province']) ? $user['province'] : ''; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City:</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($user['city']) ? $user['city'] : ''; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="barangay" class="form-label">Barangay:</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo isset($user['barangay']) ? $user['barangay'] : ''; ?>" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Email & Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="editEmailBtn">Edit</button>
                                <button type="button" class="btn btn-secondary cancel-btn" style="display: none;">Cancel</button>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="editPasswordBtn">Edit</button>
                                <button type="button" class="btn btn-secondary cancel-btn" style="display: none;">Cancel</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        // Store original values
        let originalEmail = "<?php echo $user['email']; ?>";
        let originalPassword = "<?php echo $user['password']; ?>";

        document.getElementById('editEmailBtn').addEventListener('click', function() {
            document.getElementById('email').removeAttribute('readonly');
            toggleCancelBtnVisibility(this);
        });

        document.getElementById('editPasswordBtn').addEventListener('click', function() {
            document.getElementById('password').removeAttribute('readonly');
            toggleCancelBtnVisibility(this);
        });

        // Function to toggle Cancel button visibility
        function toggleCancelBtnVisibility(editBtn) {
            const cancelBtn = editBtn.nextElementSibling;
            cancelBtn.style.display = 'inline-block';
            editBtn.style.display = 'none';
        }

        // Add event listeners for Cancel buttons
        const cancelButtons = document.querySelectorAll('.cancel-btn');
        cancelButtons.forEach(cancelBtn => {
            cancelBtn.addEventListener('click', function() {
                const editBtn = this.previousElementSibling;
                const inputField = editBtn.parentElement.previousElementSibling.querySelector('input');
                
                if (inputField.id === 'email') {
                    inputField.value = originalEmail;
                } else if (inputField.id === 'password') {
                    inputField.value = originalPassword;
                }
                
                inputField.setAttribute('readonly', true);
                this.style.display = 'none';
                editBtn.style.display = 'inline-block';
            });
        });
    </script>
</body>
</html>