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
<?php
include('config.php');

// Generate random Property No and Serial No
$random_property_id = rand(100, 999);  // Generates a random property number between 100 and 999
$random_serial_id = rand(100, 999);  // Generates a random serial number between 100 and 999

// Format Property No and Serial No with prefixes and leading zeros
$formatted_property_id = "PN-" . str_pad($random_property_id, 3, "0", STR_PAD_LEFT);
$formatted_serial_id = "SN-" . str_pad($random_serial_id, 3, "0", STR_PAD_LEFT);

if(isset($_POST['save'])){
    $serial_id = $_POST['serial_id'];
    $property_id = $_POST['property_id'];
    $article = $_POST['article'];
    $office = $_POST['office'];
    // Check if the 'status' is set and assign a default value if not
    $service_status = isset($_POST['status']) ? $_POST['status'] : 'Unserviceable'; // Default to 'Unserviceable'
    $unit = $_POST['unit'];
    $cost = $_POST['cost'];
    $date_acquired = $_POST['date_acquired'];
    $date_counted = $_POST['date_counted'];
    $coa_rep = $_POST['coa_rep'];
    $property_cus = $_POST['property_cus'];
    
    $sql = "INSERT INTO qr_tb (serial_id, property_id, article, office, service_status, unit, cost, date_acquired, date_counted, coa_rep, property_cus) 
            VALUES ('$serial_id', '$property_id', '$article', '$office', '$service_status', '$unit', '$cost', '$date_acquired', '$date_counted', '$coa_rep', '$property_cus')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Added Successfully!!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $office = $_POST['office'];
    $article = $_POST['article'];
    $service_status = isset($_POST['status']) ? $_POST['status'] : 'Unserviceable';
    $unit = $_POST['unit'];
    $cost = $_POST['cost'];
    $date_acquired = $_POST['date_acquired'];
    $date_counted = $_POST['date_counted'];
    $coa_rep = $_POST['coa_rep'];
    $property_cus = $_POST['property_cus'];

    $sql = "UPDATE qr_tb SET office='$office', article='$article', service_status='$service_status', unit='$unit', 
            cost='$cost', date_acquired='$date_acquired', date_counted='$date_counted', coa_rep='$coa_rep', property_cus='$property_cus' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Updated Successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $sql = "DELETE FROM qr_tb WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Deleted Successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
                <h3>QR Code Management</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title">QR Generate Property Sticker</h5>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-database-add"></i> Add</button>
                    </div>
                    <table id="qrTable" class="display">
                        <thead>
                            <tr>
                                <th>Serial ID</th>
                                <th>Property ID</th>
                                <th>Article</th>
                                <th>Office</th>
                                <th>Date Counted</th>
                                <th>Property Custodian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM qr_tb";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['serial_id']}</td>
                                        <td>{$row['property_id']}</td>
                                        <td>{$row['article']}</td>
                                        <td>{$row['office']}</td>
                                        <td>{$row['date_counted']}</td>
                                        <td>{$row['property_cus']}</td>
                                        <td>
                                            <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' onclick='loadEditData({$row['id']})'><i class='bi bi-pencil-square'></i></button>
                                            <button class='btn btn-danger btn-sm' onclick='deleteRecord({$row['id']})'><i class='bi bi-trash3'></i></button>
                                            <a href='print_pdf.php?id={$row['id']}' class='btn btn-success btn-sm'><i class='bi bi-printer'></i></a>
                                        </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-card-checklist"></i>&nbsp;Fill Up Property Sticker Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <div class="row align-items-end">
                <div class="col-lg-6 mb-1">
                    <label class="form-label" style="font-weight: 500;">Office/Location</label>
                    <input type="text" id="office" name="office" class="form-control" required>
                </div>
                <div class="col-lg-6 mb-1">
                    <label class="form-label" style="font-weight: 500;">Article</label>
                    <input type="text" id="article" name="article" class="form-control" required>
                </div>
                <div class="col-lg-4 mb-1">
                    <label class="form-label" style="font-weight: 500;">Property No.</label>
                    <input type="text" id="propid" name="property_id" value="<?php echo $formatted_property_id; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-1">
                    <label class="form-label" style="font-weight: 500;">Serial No.</label>
                    <input type="text" id="qrdata" name="serial_id" value="<?php echo $formatted_serial_id; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-1">
                    <div class="form-check">
                        <input type="checkbox" name="status" value="Serviceable" class="form-check-input" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Serviceable</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="status" value="Unserviceable" class="form-check-input" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Unserviceable</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-1">
                    <label class="form-label" style="font-weight: 500;">Unit/Quantity</label>
                    <input type="text" id="unit" name="unit" class="form-control" required>
                </div>
                <div class="col-lg-6 mb-1">
                    <label class="form-label" style="font-weight: 500;">Acquisition Cost</label>
                    <input type="number" id="cost" name="cost" class="form-control" required>
                </div>
                <div class="col-lg-3 mb-1">
                    <label class="form-label" style="font-weight: 500;">Date Acquired</label>
                    <input type="date" id="acquired" name="date_acquired" class="form-control" required>
                </div>
                <div class="col-lg-3 mb-1">
                    <label class="form-label" style="font-weight: 500;">Date Counted</label>
                    <input type="date" id="counted" name="date_counted" class="form-control" required>
                </div>
                <div class="col-lg-3 mb-1">
                    <label class="form-label" style="font-weight: 500;">COA Representative</label>
                    <input type="text" id="coa" name="coa_rep" class="form-control" required>
                </div>
                <div class="col-lg-3 mb-1">
                    <label class="form-label" style="font-weight: 500;">Property Custodian</label>
                    <input type="text" id="custod" name="property_cus" class="form-control" required>
                </div>
            </div>
            <button type="submit" name="save" class="btn btn-primary mt-2">Save Information</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i class="bi bi-pencil"></i>&nbsp;Edit Property Sticker Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row align-items-end">
                        <!-- Office/Location -->
                        <div class="col-lg-6 mb-1">
                            <label class="form-label" style="font-weight: 500;">Office/Location</label>
                            <input type="text" id="office" name="office" class="form-control" required>
                        </div>
                        
                        <!-- Article -->
                        <div class="col-lg-6 mb-1">
                            <label class="form-label" style="font-weight: 500;">Article</label>
                            <input type="text" id="article" name="article" class="form-control" required>
                        </div>
                        
                        <!-- Property No. (Read-only) -->
                        <div class="col-lg-4 mb-1">
                            <label class="form-label" style="font-weight: 500;">Property No.</label>
                            <input type="text" id="propid" name="property_id" class="form-control" readonly>
                        </div>
                        
                        <!-- Serial No. (Read-only) -->
                        <div class="col-lg-4 mb-1">
                            <label class="form-label" style="font-weight: 500;">Serial No.</label>
                            <input type="text" id="qrdata" name="serial_id" class="form-control" readonly>
                        </div>
                        
                        <!-- Service Status (Checkbox) -->
                        <div class="col-lg-4 mb-1">
                            <div class="form-check">
                                <input type="checkbox" name="status" value="Serviceable" class="form-check-input" id="serviceableCheck">
                                <label class="form-check-label" for="serviceableCheck">Serviceable</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="status" value="Unserviceable" class="form-check-input" id="unserviceableCheck">
                                <label class="form-check-label" for="unserviceableCheck">Unserviceable</label>
                            </div>
                        </div>
                        
                        <!-- Unit/Quantity -->
                        <div class="col-lg-6 mb-1">
                            <label class="form-label" style="font-weight: 500;">Unit/Quantity</label>
                            <input type="text" id="unit" name="unit" class="form-control" required>
                        </div>
                        
                        <!-- Acquisition Cost -->
                        <div class="col-lg-6 mb-1">
                            <label class="form-label" style="font-weight: 500;">Acquisition Cost</label>
                            <input type="number" id="cost" name="cost" class="form-control" required>
                        </div>
                        
                        <!-- Date Acquired -->
                        <div class="col-lg-3 mb-1">
                            <label class="form-label" style="font-weight: 500;">Date Acquired</label>
                            <input type="date" id="acquired" name="date_acquired" class="form-control" required>
                        </div>
                        
                        <!-- Date Counted -->
                        <div class="col-lg-3 mb-1">
                            <label class="form-label" style="font-weight: 500;">Date Counted</label>
                            <input type="date" id="counted" name="date_counted" class="form-control" required>
                        </div>
                        
                        <!-- COA Representative -->
                        <div class="col-lg-3 mb-1">
                            <label class="form-label" style="font-weight: 500;">COA Representative</label>
                            <input type="text" id="coa" name="coa_rep" class="form-control" required>
                        </div>
                        
                        <!-- Property Custodian -->
                        <div class="col-lg-3 mb-1">
                            <label class="form-label" style="font-weight: 500;">Property Custodian</label>
                            <input type="text" id="custod" name="property_cus" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" name="update" class="btn btn-primary mt-2">Update Information</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('link/script.php');?>
</body>
</html>

