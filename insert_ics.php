<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity_name = $_POST['entity'];
    $fund_cluster = $_POST['fund-cluster'];
    $ics_no = $_POST['par-no'];
    $item_no = $_POST['item-number'];
    $date_acquired = $_POST['date-acquired'];
    $receive_by = $_POST['received-by'];
    $role1 = $_POST['role1'];
    $issue_by = $_POST['issued-by'];
    $role2 = $_POST['role2'];
    $estimate = $_POST['estimate'];

    $quantities = $_POST['quantity'];
    $units = $_POST['unit'];
    $descriptions = $_POST['description'];
    $costs = $_POST['cost'];
    $amounts = $_POST['amount'];

    $sql = "INSERT INTO `ics_tb`(`entity_name`, `fund_cluster`, `ics_no`, `qty`, `unit`, `unit_cost`, `total_cost`, `description`, `item_no`, `estimate`, `receive_by`, `role1`, `issue_by`, `role2`, `date_file`) VALUES ";

    $values = [];
    foreach ($quantities as $key => $qty) {
        $unit = $units[$key];
        $description = $descriptions[$key];
        $cost = $costs[$key];
        $amount = $amounts[$key];

        $values[] = "(
            '" . $conn->real_escape_string($entity_name) . "',
            '" . $conn->real_escape_string($fund_cluster) . "',
            '" . $conn->real_escape_string($ics_no) . "',
            '" . $conn->real_escape_string($qty) . "',
            '" . $conn->real_escape_string($unit) . "',
            '" . $conn->real_escape_string($cost) . "',
            '" . $conn->real_escape_string($amount) . "',
            '" . $conn->real_escape_string($description) . "',
            '" . $conn->real_escape_string($item_no) . "',
            '" . $conn->real_escape_string($estimate) . "',
            '" . $conn->real_escape_string($receive_by) . "',
            '" . $conn->real_escape_string($role1) . "',
            '" . $conn->real_escape_string($issue_by) . "',
            '" . $conn->real_escape_string($role2) . "',
            '" . $conn->real_escape_string($date_acquired) . "'
        )";
    }

    $sql .= implode(", ", $values);

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data inserted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
