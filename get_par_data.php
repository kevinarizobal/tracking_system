<?php
include 'config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT `id`, `entity_name`, `fund_cluster`, `par_no`, `qty`, `unit`, `description`, `property_number`, `date_acquired`, `amount`, `received_by`, `issued_by`, `date_file` FROM `par_tb` WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Ensure description is returned as an array
        $descriptions = explode(',', $row['description']);  // Assuming descriptions are stored as comma-separated values
        $row['description'] = $descriptions;

        echo json_encode($row); // Return the result as a JSON object
    } else {
        echo json_encode([]); // Return an empty array if no result found
    }
}
?>
