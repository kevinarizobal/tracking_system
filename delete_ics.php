<?php
include('config.php');

$id = $_GET['id'];
$sql = "DELETE FROM ics_tb WHERE id = $id";

if ($conn->query($sql)) {
    echo "<script>alert('Deleted Successfully!!');</script>";
    header("Location: ics.php"); 
} else {
    echo "Error: " . $conn->error;
}

?>
