<?php
include('config.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('link/header.php');?>
<body>
<?php include('link/navbar.php');?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>User Management</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="userTable2" class="display">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Date Last Login</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM `user_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $email = $row['email'];
                                        $fname = $row['fullname'];
                                        $role = $row['role'];
                                        $lastlogin = $row['lastlogin'];
                            ?>
                            <tr>
                                <td><?=$email?></td>
                                <td><?=$fname?></td>
                                <td><?=$role?></td>
                                <td><?=$lastlogin?></td>
                            </tr>
                            <?php
                                    }    
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('link/script.php');?>
</body>
</html>
