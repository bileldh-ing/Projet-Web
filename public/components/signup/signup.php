<?php
session_start();
require_once '../../../config/config.php';
require_once '../../../app/models/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    
    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $full_name, $phone]);
        
        // Set session variables
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['username'] = $username;
        
        // Redirect to main.php
        header('Location: ../../../public/main.php');
        exit();
    } catch (PDOException $e) {
        $error_message = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <style>
      body {
        background: #27292a;
        color: #fff;
        font-family: "Arial", sans-serif;
      }
      .form-container {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
        background: #343a40;
      }
      .form-container h3 {
        margin-bottom: 30px;
        font-weight: bold;
        font-size: 26px;
      }
      .form-control {
        border-radius: 12px;
        margin-bottom: 20px;
        padding: 18px;
        font-size: 18px;
        background-color: #495057;
        border: 2px solid #495057;
        color: #fff;
      }
      .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
      }
      .form-control.valid {
        border-color: #28a745;
      }
      .form-control.invalid {
        border-color: #dc3545;
      }
      .input-group {
        position: relative;
      }
      .input-group-text {
        background-color: #495057;
        border: 2px solid #495057;
        color: #fff;
        font-size: 20px;
        height: 50px;
        line-height: 50px;
        border-radius: 12px;
      }
      .input-group .form-control {
        height: 50px;
        font-size: 18px;
        border-radius: 12px;
      }
      .btn {
        font-size: 18px;
        padding: 14px;
        border-radius: 12px;
        width: 100%;
      }
      .btn-primary {
        background-color: #007bff;
        border: none;
      }
      .btn-primary:hover {
        background-color: #0056b3;
      }
      .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
      }
    </style>
  </head>
  <body>
    <div class="form-container">
      <h3 class="text-center">Sign Up</h3>
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
      <?php endif; ?>
      <form id="signup-form" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required />
          </div>
          <div id="username-error" class="error-message"></div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
          </div>
          <div id="email-error" class="error-message"></div>
        </div>

        <div class="mb-3">
          <label for="full_name" class="form-label">Full Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required />
          </div>
          <div id="full_name-error" class="error-message"></div>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone (optional)</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" />
          </div>
          <div id="phone-error" class="error-message"></div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required />
          </div>
          <div id="password-error" class="error-message"></div>
        </div>

        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
      <p class="text-center mt-3">
        Already have an account? <a href="login.html" style="color: #007bff;">Login</a>
      </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.getElementById("signup-form").addEventListener("submit", function(event) {
        event.preventDefault();
        
        const username = document.getElementById("username");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const fullName = document.getElementById("full_name");
        
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
        
        // Validate Username
        const usernamePattern = /^[A-Za-z]{3,}[A-Za-z0-9]*$/;
        if (!usernamePattern.test(username.value.trim())) {
          isValid = false;
          document.getElementById("username-error").textContent = 
            "Username must start with at least 3 letters and contain no special characters.";
        }
        
        // Validate Email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value.trim())) {
          isValid = false;
          document.getElementById("email-error").textContent = 
            "Please enter a valid email address.";
        }
        
        // Validate Password
        if (password.value.length < 6) {
          isValid = false;
          document.getElementById("password-error").textContent = 
            "Password must be at least 6 characters long.";
        }
        
        // Validate Full Name
        if (fullName.value.trim().length < 2) {
          isValid = false;
          document.getElementById("full_name-error").textContent = 
            "Please enter your full name.";
        }
        
        if (isValid) {
          this.submit();
        }
      });
    </script>
  </body>
</html>