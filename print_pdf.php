<?php
include('config.php');

// Get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch data for the given ID
$sql = "SELECT `id`, `serial_id`, `property_id`, `article`, `office`, `service_status`, `unit`, `cost`, `date_acquired`, `date_counted`, `coa_rep`, `property_cus` 
        FROM `qr_tb` WHERE `id` = $id LIMIT 1";
$result = $conn->query($sql);

// Initialize variables with default values
$office = $article = $property_no = $serial_no = $service_status = $unit_quantity = $acquisition_cost = $date_acquired = $date_counted = $coa_representative = $property_custodian = "";
$serviceable = $unserviceable = false;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Assign fetched values to variables
    $office = $row['office'];
    $article = $row['article'];
    $property_no = $row['property_id'];
    $serial_no = $row['serial_id'];
    $service_status = $row['service_status'];
    $unit_quantity = $row['unit'];
    $acquisition_cost = $row['cost'];
    $date_acquired = $row['date_acquired'];
    $date_counted = $row['date_counted'];
    $coa_representative = $row['coa_rep'];
    $property_custodian = $row['property_cus'];

    // Determine checkbox status
    $serviceable = $service_status === 'Serviceable';
    $unserviceable = $service_status === 'Unserviceable';
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('link/header.php'); ?>
<body>
<?php include('link/navbar.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>QR Code Management</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="qrcode.php" class="btn btn-primary mb-3">Return QR</a>
                    </div>
                    <form method="POST" action="generate_sticker.php">
                        <div class="row align-items-end">
                            <div class="col-lg-6 mb-1">
                                <label class="form-label" style="font-weight: 500;">Office/Location</label>
                                <input type="text" id="office" name="office" class="form-control" value="<?= htmlspecialchars($office); ?>" readonly>
                            </div>
                            <div class="col-lg-6 mb-1">
                                <label class="form-label" style="font-weight: 500;">Article</label>
                                <input type="text" id="article" name="article" class="form-control" value="<?= htmlspecialchars($article); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">Property No.</label>
                                <input type="text" id="property_no" name="property_no" class="form-control" value="<?= htmlspecialchars($property_no); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">Serial No.</label>
                                <input type="text" id="serial_no" name="serial_no" class="form-control" value="<?= htmlspecialchars($serial_no); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <div class="form-check">
                                    <input type="checkbox" id="serviceable" name="condition" class="form-check-input" <?= $serviceable ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="serviceable">Serviceable</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="unserviceable" name="condition" class="form-check-input" <?= $unserviceable ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="unserviceable">Unserviceable</label>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label for="copies">Number of Copies:</label><br>
                                <input type="number" id="copies" name="copies" min="1" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mb-1">
                                <label class="form-label" style="font-weight: 500;">Unit/Quantity</label>
                                <input type="text" id="unit_quantity" name="unit_quantity" class="form-control" value="<?= htmlspecialchars($unit_quantity); ?>" readonly>
                            </div>
                            <div class="col-lg-6 mb-1">
                                <label class="form-label" style="font-weight: 500;">Acquisition Cost</label>
                                <input type="number" id="acquisition_cost" name="acquisition_cost" class="form-control" value="<?= htmlspecialchars($acquisition_cost); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">Date Acquired</label>
                                <input type="text" id="date_acquired" name="date_acquired" class="form-control" value="<?= htmlspecialchars($date_acquired); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">Date Counted</label>
                                <input type="text" id="date_counted" name="date_counted" class="form-control" value="<?= htmlspecialchars($date_counted); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">COA Representative</label>
                                <input type="text" id="coa_representative" name="coa_representative" class="form-control" value="<?= htmlspecialchars($coa_representative); ?>" readonly>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <label class="form-label" style="font-weight: 500;">Property Custodian</label>
                                <input type="text" id="property_custodian" name="property_custodian" class="form-control" value="<?= htmlspecialchars($property_custodian); ?>" readonly>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-success mt-2" value="Generate Stickers">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('link/script.php'); ?>
</body>
</html>
