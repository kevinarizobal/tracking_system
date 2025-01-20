<?php
session_start();  // Start the session
include("config.php");

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);  // Hash the password

    // Check if the student ID exists and password matches
    $login_sql = "SELECT * FROM `user_tb` WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'Active'";
    $result = $conn->query($login_sql);

    if ($result->num_rows > 0) {
        // If login is successful, fetch user data and store in session
        $user = $result->fetch_assoc();
        $_SESSION['UID'] = $user['userid'];
        $_SESSION['Email'] = $user['email'];
        $_SESSION['Name'] = $user['fullname'];
        $_SESSION['Role'] = $user['role'];
        $_SESSION['login'] = true;

        // Update the lastlogin field to the current timestamp
        $update_lastlogin_sql = "UPDATE `user_tb` SET `lastlogin` = NOW() WHERE `userid` = '" . $user['userid'] . "'";
        $conn->query($update_lastlogin_sql);

        // Redirect Student to dashboard
        echo "<script>alert('Login successful! Redirecting to dashboard...');</script>";
        echo "<script>window.location.href='dashboard.php';</script>";

    } else {
        // If login fails, show an error message
        echo "<script>alert('Invalid email or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEMSU-SUPTRACK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8efef;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .login-container img {
            width: 120px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0d47a1;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b3b82;
        }
        .forgot-password {
            margin-top: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="image/2.png" alt="University Logo">
        <h5 class="mb-4">Sign in to start your session</h5>
        
        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                <input type="email" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
            </div>

            <div class="input-group mb-3">
                <button class="btn btn-lg btn-primary w-100 fs-6" type="submit" name="login">Login</button>
            </div>
        </form>

        <div class="input-group mb-3 justify-content-center text-secondary">
            <div class="forgot">
                <small><i>&copy;&nbsp;2024 NEMSU Cantilan All Right Reserved</i></small>
            </div>
        </div>
    </div>

</body>
</html>

