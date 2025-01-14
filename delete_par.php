<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM par_tb WHERE id = $id";
    
    if ($conn->query($sql)) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
