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
<?php include("link/header.php"); ?>
<body>
    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box ----------------------------->  
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="image/2.png" class="img-fluid mt-2" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">SUPTRACK</p>
                <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Design By @OnaisYaj</small>
            </div> 
            <!-------------------- ------ Right Box ---------------------------->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2><i class="bi bi-person-circle"></i>&nbsp;Login</h2>
                    </div>
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
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
                        <div class="input-group mb-3 justify-content-center text-secondary">
                            <div class="forgot">
                                <small><i>&copy;&nbsp;2024 NEMSU Cantilan All Right Reserved</i></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>
