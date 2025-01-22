<?php
require_once('tcpdf/tcpdf.php');
include('config.php'); // Include database connection

// Extend TCPDF class to create a custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 35, 'INVENTORY CUSTODIAN SLIP', 0, 1, 'C');
    }
}

// Create PDF instance with long bond paper size (8.5 x 13 inches)
$pdf = new MYPDF();
$pdf->SetMargins(25.4, 25, 25.4);  // 1 inch margins (25.4mm)
$pdf->AddPage('P', array(215.9, 330.2));  // 'P' for portrait orientation

// Create PDF instance with long bond paper size (8.5 x 13 inches)
$pdf = new MYPDF();
$pdf->SetMargins(2.54, 25, 2.54);
$pdf->AddPage('P', array(215.9, 330.2));  // 'P' for portrait orientation

$pdf->SetFont('helvetica', '', 10);
$pdf->Ln(5);
// Validate and fetch data from database
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    die("No property ID provided.");
}

$sql = "SELECT * FROM ics_tb WHERE item_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'qty' => $row['qty'],
            'unit' => $row['unit'],
            'unit_cost' => $row['unit_cost'],
            'total_cost' => $row['total_cost'],
            'desc' => $row['description'],
            'item_no' => $row['item_no'],
            'estimate' => $row['estimate'],
        ];
        $entityName = $row['entity_name'];
        $fundCluster = $row['fund_cluster'];
        $ics_no = $row['ics_no'];
        $receive_by = $row['receive_by'];
        $role1 = $row['role1'];
        $issue_by = $row['issue_by'];
        $role2 = $row['role2'];
        $date_file = $row['date_file'];
    }
} else {
    die("No records found.");
}

// Entity Name and PAR No.
$pdf->Cell(35, 6, "Entity Name:", 0, 0, 'L');
$pdf->SetFont('helvetica', 'U', 10);
$pdf->Cell(70, 6, $entityName, 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$pdf->Cell(35, 6, "Fund Cluster:", 0, 0, 'L');
$pdf->SetFont('helvetica', 'U', 10);
$pdf->Cell(75, 6, $fundCluster, 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);

$pdf->Cell(55, 6, "PAR No.:", 0, 0, 'R');
$pdf->SetFont('helvetica', 'U', 10);
$pdf->Cell(25, 6, $ics_no, 0, 1, 'R');
$pdf->SetFont('helvetica', '', 10);

$pdf->Ln(5);

// Header table settings
$pdf->SetFont('helvetica', 'B', 8);
$tableWidth = 210;  // Total width of the table (leaving margins)
$signWidth = $tableWidth;

$col1Width = $tableWidth * 0.10;  // 10% for Quantity
$col2Width = $tableWidth * 0.10;  // 10% for Unit
$col3Width = $tableWidth * 0.25;  // 25% for Amount (total width for the merged columns)
$col4Width = $tableWidth * 0.25;  // 20% for Description
$col5Width = $tableWidth * 0.15;  // 15% for Inventory Item No.
$col6Width = $tableWidth * 0.15;  // 15% for Estimated Useful Life

// First row (main headers)
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
$pdf->Cell($col1Width, 12, "Quantity", 1, 0, 'C');
$pdf->Cell($col2Width, 12, "Unit", 1, 0, 'C');
$pdf->Cell($col3Width, 6, "Amount", 'LRTB', 0, 'C');
$pdf->Cell($col4Width, 12, "Description", 1, 0, 'C');
$pdf->Cell($col5Width, 12, "Inventory Item No.", 1, 0, 'C');
$pdf->Cell($col6Width, 12, "Estimated Useful Life", 1, 1, 'C');

// Second row (sub-headers under Amount)
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Reset to the "Amount" column start position
$pdf->Cell($col1Width, 6, "", 0, 0, 'C');  // Empty cell to align with "Quantity" and "Unit"
$pdf->Cell($col2Width, 6, "", 0, 0, 'C');  // Empty cell to align with "Quantity" and "Unit"

$pdf->SetXY(45, 53);  // Set the X and Y to align the "Unit Cost" and "Total Cost" cells
$pdf->Cell($col3Width * 0.5, 6, "Unit Cost", 1, 0, 'C');
$pdf->Cell($col3Width * 0.5, 6, "Total Cost", 1, 1, 'C');

// Populate table rows
$pdf->SetFont('helvetica', '', 8);
$totalAmount = 0;

foreach ($data as $row) {
    $totalAmount += $row['total_cost'];
    $pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
    $pdf->Cell(21, 8, $row['qty'], 'LR', 0, 'C');
    $pdf->Cell(21, 8, $row['unit'], 'LR', 0, 'C');
    $pdf->Cell(26.3, 8, number_format($row['unit_cost'], 2), 'LR', 0, 'C');
    $pdf->Cell(26.2, 8, number_format($row['total_cost'], 2), 'LR', 0, 'C');
    $pdf->Cell(52.5, 8, $row['desc'], 'LR', 0, 'C');
    $pdf->Cell(31.5, 8, $row['item_no'], 'LR', 0, 'C');
    $pdf->Cell(31.5, 8, $row['estimate'], 'LR', 0, 'C');
    $pdf->Cell(26.3, 8, number_format($row['total_cost'], 2), 'LR', 1, 'C');
}

$pdf->SetX(3);
$pdf->Cell(21, 165, '', 'LRB', 0, 'C');
$pdf->Cell(21, 165, '', 'RB', 0, 'C');
$pdf->Cell(26.25, 165, '', 'RB', 0, 'C');
$pdf->Cell(26.25, 165, '', 'RB', 0, 'C');
$pdf->Cell(52.45, 165, '', 'RB', 0, 'C');
$pdf->Cell(31.55, 165, '', 'RB', 0, 'C');
$pdf->Cell(31.55, 165, '', 'RB', 0, 'C');

$pdf->Ln(160);
$pdf->Cell(165, 0, number_format($totalAmount, 2), 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(94.5, 55, "", 'LRB', 0, 'L');
$pdf->Cell(115.5, 55, "", 'LRB', 0, 'L');

$pdf->SetXY(5,245);
$pdf->Cell(90, 20, "Receive from:", 0, 0, 'L');

$pdf->SetXY(20,265);
$pdf->Cell(90, 6, "___________________________________", 0, 0, 'L');

$pdf->SetXY(30,265);
$pdf->Cell(120, 6, $receive_by, 0, 0, 'L');

$pdf->SetXY(21.5,270);
$pdf->Cell(120, 6, "Signature over Printed Name of End User", 0, 0, 'L');

$pdf->SetFont('helvetica', 'U', 8);
$pdf->SetXY(35,275);
$pdf->Cell(120, 6, "$role1", 0, 0, 'L');
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY(36,280);
$pdf->Cell(120, 6, "$date_file", 0, 0, 'L');


// Receive By Signature
$pdf->SetXY(105,245);
$pdf->Cell(90, 20, "Receive by:", 0, 0, 'L');

$pdf->SetXY(130,265);
$pdf->Cell(90, 6, "___________________________________", 0, 0, 'L');

$pdf->SetXY(140,265);
$pdf->Cell(120, 6, $issue_by, 0, 0, 'L');

$pdf->SetXY(137,270);
$pdf->Cell(120, 6, "Signature over Printed Name", 0, 0, 'L');

$pdf->SetFont('helvetica', 'U', 8);
$pdf->SetXY(142,275);
$pdf->Cell(120, 6, "$role2", 0, 0, 'L');
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY(145,280);
$pdf->Cell(120, 6, "$date_file", 0, 0, 'L');

$pdf->Output('property_acknowledgment_receipt_static.pdf', 'I');
?>
