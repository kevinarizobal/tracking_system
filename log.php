<?php
include('config.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

// SQL Query to merge data
$sql = "
SELECT 
    id, entity_name, fund_cluster, ics_no AS reference_no, qty, unit, 
    unit_cost AS cost, total_cost, description, item_no, estimate, 
    receive_by, role1 AS received_role, issue_by, role2 AS issued_role, 
    date_file, NULL AS property_number, NULL AS date_acquired, 
    NULL AS received_by, NULL AS position, NULL AS issued_by, 
    NULL AS serial_id, NULL AS property_id, NULL AS article, 
    NULL AS office, NULL AS service_status, NULL AS date_counted, 
    NULL AS coa_rep, NULL AS property_cus, NULL AS userid, 
    NULL AS email, NULL AS username, NULL AS fullname, 
    NULL AS password, NULL AS role, NULL AS datecreated, NULL AS lastlogin, 
    NULL AS status, 'ICS' AS source_table
FROM ics_tb

UNION ALL

SELECT 
    id, entity_name, fund_cluster, par_no AS reference_no, qty, unit, 
    amount AS cost, NULL AS total_cost, description, NULL AS item_no, 
    NULL AS estimate, received_by AS receive_by, position AS received_role, 
    issued_by AS issue_by, NULL AS issued_role, date_file, 
    property_number, date_acquired, received_by, position, issued_by, 
    NULL AS serial_id, NULL AS property_id, NULL AS article, 
    NULL AS office, NULL AS service_status, NULL AS date_counted, 
    NULL AS coa_rep, NULL AS property_cus, NULL AS userid, 
    NULL AS email, NULL AS username, NULL AS fullname, 
    NULL AS password, NULL AS role, NULL AS datecreated, NULL AS lastlogin, 
    NULL AS status, 'PAR' AS source_table
FROM par_tb

UNION ALL

SELECT 
    id, NULL AS entity_name, NULL AS fund_cluster, NULL AS reference_no, 
    NULL AS qty, unit, cost, NULL AS total_cost, article AS description, 
    NULL AS item_no, NULL AS estimate, NULL AS receive_by, NULL AS received_role, 
    NULL AS issue_by, NULL AS issued_role, date_acquired AS date_file, 
    property_id AS property_number, date_acquired, NULL AS received_by, 
    NULL AS position, NULL AS issued_by, serial_id, property_id, 
    article, office, service_status, date_counted, coa_rep, 
    property_cus, NULL AS userid, NULL AS email, NULL AS username, 
    NULL AS fullname, NULL AS password, NULL AS role, NULL AS datecreated, 
    NULL AS lastlogin, NULL AS status, 'QR' AS source_table
FROM qr_tb

UNION ALL

SELECT 
    userid AS id, NULL AS entity_name, NULL AS fund_cluster, NULL AS reference_no, 
    NULL AS qty, NULL AS unit, NULL AS cost, NULL AS total_cost, NULL AS description, 
    NULL AS item_no, NULL AS estimate, NULL AS receive_by, NULL AS received_role, 
    NULL AS issue_by, NULL AS issued_role, datecreated AS date_file, 
    NULL AS property_number, NULL AS date_acquired, NULL AS received_by, 
    NULL AS position, NULL AS issued_by, NULL AS serial_id, NULL AS property_id, 
    NULL AS article, NULL AS office, NULL AS service_status, 
    NULL AS date_counted, NULL AS coa_rep, NULL AS property_cus, 
    userid, email, username, fullname, password, role, 
    datecreated, lastlogin, status, 'USER' AS source_table
FROM user_tb
";

$result = $conn->query($sql);
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
                <h3>System Log History</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="userTable2" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entity Name</th>
                                <th>Fund Cluster</th>
                                <th>Reference No</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Cost</th>
                                <th>Total Cost</th>
                                <th>Description</th>
                                <th>Item No</th>
                                <th>Estimate</th>
                                <th>Received By</th>
                                <th>Received Role</th>
                                <th>Issued By</th>
                                <th>Issued Role</th>
                                <th>Date Filed</th>
                                <th>Property Number</th>
                                <th>Date Acquired</th>
                                <th>Office</th>
                                <th>Service Status</th>
                                <th>COA Rep</th>
                                <th>Property Custodian</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Date Created</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th>Source Table</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['entity_name']) ?></td>
                                    <td><?= htmlspecialchars($row['fund_cluster']) ?></td>
                                    <td><?= htmlspecialchars($row['reference_no']) ?></td>
                                    <td><?= htmlspecialchars($row['qty']) ?></td>
                                    <td><?= htmlspecialchars($row['unit']) ?></td>
                                    <td><?= htmlspecialchars($row['cost']) ?></td>
                                    <td><?= htmlspecialchars($row['total_cost']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['item_no']) ?></td>
                                    <td><?= htmlspecialchars($row['estimate']) ?></td>
                                    <td><?= htmlspecialchars($row['receive_by']) ?></td>
                                    <td><?= htmlspecialchars($row['received_role']) ?></td>
                                    <td><?= htmlspecialchars($row['issue_by']) ?></td>
                                    <td><?= htmlspecialchars($row['issued_role']) ?></td>
                                    <td><?= htmlspecialchars($row['date_file']) ?></td>
                                    <td><?= htmlspecialchars($row['property_number']) ?></td>
                                    <td><?= htmlspecialchars($row['date_acquired']) ?></td>
                                    <td><?= htmlspecialchars($row['office']) ?></td>
                                    <td><?= htmlspecialchars($row['service_status']) ?></td>
                                    <td><?= htmlspecialchars($row['coa_rep']) ?></td>
                                    <td><?= htmlspecialchars($row['property_cus']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['role']) ?></td>
                                    <td><?= htmlspecialchars($row['datecreated']) ?></td>
                                    <td><?= htmlspecialchars($row['lastlogin']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= htmlspecialchars($row['source_table']) ?></td>
                                </tr>
                            <?php endwhile; ?>
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

<?php $conn->close(); ?>
