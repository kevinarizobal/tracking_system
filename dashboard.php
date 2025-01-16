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
<head>
<?php include('link/header.php'); ?>
</head>
<body>
<?php include('link/navbar.php');?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>DASHBOARD</h3>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>DATE AND TIME</h6>
                            <h5 id="current-date-time" class="mt-2 mb-0"></h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-9 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-primary p-3 bg-white">
                            <h6>NEWLY ADDED GENERATE QR CODE</h6>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-striped mt-1">
                                    <thead>
                                        <tr>
                                            <th>Serial No.</th>
                                            <th>Property No.</th>
                                            <th>Item Name</th>
                                            <th>Property Custodian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM `qr_tb` LIMIT 10";
                                            $result = mysqli_query($conn,$sql);
                                            if($result->num_rows > 0){
                                                while($row = $result->fetch_assoc()) {
                                                    $sno = $row['serial_id'];
                                                    $pno = $row['property_id'];
                                                    $article = $row['article'];
                                                    $property_cus = $row['property_cus'];
                                        ?>
                                        <tr>
                                            <td><?=$sno?></td>
                                            <td><?=$pno?></td>
                                            <td><?=$article?></td>
                                            <td><?=$property_cus?></td>
                                        </tr>
                                        <?php
                                                }    
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF ICS</h6>
                            <?php
                                $sql = "SELECT COUNT(ics_no) as total FROM `ics_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF INVENTORY ITEMS</h6>
                            <?php
                                $sql = "SELECT COUNT(item_no) as total FROM `ics_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF QR CODES</h6>
                            <?php
                                $sql = "SELECT COUNT(serial_id) as total FROM `qr_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF PAR</h6>
                            <?php
                                $sql = "SELECT COUNT(par_no) as total FROM `par_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF PROPERTY</h6>
                            <?php
                                $sql = "SELECT COUNT(property_number) as total FROM `par_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center text-white p-3 bg-primary">
                            <h6>NO. OF ACTIVITY LOG</h6>
                            <?php
                                $sql = "SELECT COUNT(lastlogin) as total FROM `user_tb`";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()) {
                                        $total = $row['total'];
                                        echo '<h1 class="mt-2 mb-0">'.$total.'</h1>';
                                        }    
                                }else{
                                    echo '<h1 class="mt-2 mb-0">0</h1>';
                                }   
                            ?>
                            <!-- <h1 class="mt-2 mb-0">5</h1> -->
                        </div>
                    </a>
                </div>
            </div>                   
        </div>
    </div>
</div>

<?php include('link/script.php');?>

<script>
    // Function to format the current date and time
    function formatDateTime() {
        const options = {
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true
        };
        const currentDate = new Date().toLocaleDateString('en-US', options);
        document.getElementById("current-date-time").textContent = currentDate;
    }

    // Call the function to display the date and time on page load
    formatDateTime();
    
    // Optionally, update every second
    setInterval(formatDateTime, 1000);
</script>
</body>
</html>