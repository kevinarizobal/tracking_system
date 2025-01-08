<?php

include ('config.php');

$sql = "SELECT `userid`, `email`, `username`, `fullname`, `role`, `status` FROM `user_tb`";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode(["data" => $users]);

$conn->close();
?>
