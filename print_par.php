<?php
require_once('tcpdf/tcpdf.php');
include('config.php'); // Include database connection

// Extend TCPDF class to create custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 35, 'PROPERTY ACKNOWLEDGMENT RECEIPT', 0, 1, 'C');
    }
}

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

$sql = "SELECT * FROM par_tb WHERE property_number = ?";
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
            'desc' => $row['description'],
            'prop_no' => $row['property_number'],
            'date' => $row['date_acquired'],
            'amount' => $row['amount'],
        ];
        $entityName = $row['entity_name'];
        $fundCluster = $row['fund_cluster'];
        $parNumber = $row['par_no'];
        $received_by = $row['received_by'];
        $issued_by = $row['issued_by'];
        $position = $row['position'];
        $date_file = $row['date_file'];
    }
} else {
    die("No records found.");
}

// Set consistent widths
$tableWidth = 210;   // Total width of the table
$signWidth = $tableWidth;  // Signature section width

// Entity Name and PAR No.
$pdf->Cell(105, 6, "Entity Name: $entityName", 0, 0, 'L'); // Left-aligned
$pdf->Cell(105, 6, "", 0, 1, 'R');      // Right-aligned

// Fund Cluster and PAR No.
$pdf->Cell(105, 6, "Fund Cluster: $fundCluster", 0, 0, 'L');  // Left-aligned
$pdf->Cell(105, 6, "PAR No.: $parNumber", 0, 1, 'R');         // Right-aligned

// Add spacing
$pdf->Ln(5);

// Table headers (centered)
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
$pdf->SetFont('helvetica', '', 10);

// Header row
$pdf->Cell(30, 8, "Quantity", 1, 0, 'C');
$pdf->Cell(30, 8, "Unit", 1, 0, 'C');
$pdf->Cell(60, 8, "Description", 1, 0, 'C');
$pdf->Cell(30, 8, "Property No.", 1, 0, 'C');
$pdf->Cell(30, 8, "Date Acquired", 1, 0, 'C');
$pdf->Cell(30, 8, "Amount", 1, 1, 'C');

// Populate table rows
$pdf->SetFont('helvetica', '', 8);
$totalAmount = 0;

foreach ($data as $row) {
    $totalAmount += $row['amount'];
    $pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
    $pdf->Cell(30, 8, $row['qty'], 'LR', 0, 'C');
    $pdf->Cell(30, 8, $row['unit'], 'LR', 0, 'C');
    $pdf->Cell(60, 8, $row['desc'], 'LR', 0, 'C');
    $pdf->Cell(30, 8, $row['prop_no'], 'LR', 0, 'C');
    $pdf->Cell(30, 8, $row['date'], 'LR', 0, 'C');
    $pdf->Cell(30, 8, number_format($row['amount'], 2), 'LR', 1, 'C');
}
$pdf->SetX(3);
$pdf->Cell(30, 8, '', 'R', 0, 'C');
$pdf->Cell(30, 8, '', 'R', 0, 'C');
$pdf->Cell(60, 8, '', 'R', 0, 'C');
$pdf->Cell(30, 8, '', 'R', 0, 'C');
// Add total amount row
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
$pdf->Cell(180, 8, "", 'LB', 0, 'R');
$pdf->Cell(30, 8, number_format($totalAmount, 2), 'LRB', 1, 'C');

// Add signature section
$pdf->Ln(0);
$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position

// Signature lines
$pdf->Cell(120, 6, "Received by:", 'LR', 0, 'L');
$pdf->Cell(90, 6, "Issued by:", 'LR', 1, 'L');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(120, 6, "___________________________________", 'LR', 0, 'C');
$pdf->Cell(90, 6, "___________________________________", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(120, 6, $received_by, 'LR', 0, 'C');
$pdf->Cell(90, 6, $issued_by, 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(120, 6, "Signature over Printed Name of End User", 'LR', 0, 'C');
$pdf->Cell(90, 6, "Signature over Printed Name of Supply/Property Custodian", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(120, 6, "$position", 'LR', 0, 'C');
$pdf->Cell(90, 6, "AOI/Supply Officer", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(120, 6, "$date_file", 'LRB', 0, 'C');
$pdf->Cell(90, 6, "$date_file", 'LRB', 1, 'C');

// Output PDF
$pdf->Output('property_acknowledgment_receipt.pdf', 'I');
?>
