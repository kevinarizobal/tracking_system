<?php
require_once('tcpdf/tcpdf.php');
include('config.php'); // Include database connection

// Extend TCPDF class to create custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 35, 'PROPERTY ACKNOWLEDGEMENT RECEIPT', 0, 1, 'C');

        // Add "Appendix 59" in the upper right corner
        $this->SetFont('helvetica', 'I', 6);
        $this->SetXY($this->getPageWidth() - 45, 5); // Positioning at the top right
        $this->Cell(40, 10, 'Appendix 71', 0, 1, 'R');
    }
}


// Create PDF instance with long bond paper size (8.5 x 13 inches)
$pdf = new MYPDF();
$pdf->SetMargins(25.4, 25.4, 25.4);
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
        $receive_date = $row['receive_date'];
        $issue_date = $row['issue_date'];
        $position2 = $row['position2'];
    }
} else {
    die("No records found.");
}

// Set consistent widths
$tableWidth = 190;   // Total width of the table
$signWidth = $tableWidth;  // Signature section width

$pdf->SetX(13);
// Entity Name and PAR No.
$pdf->Cell(35, 6, "Entity Name:", 0, 0, 'L'); // Left-aligned
$pdf->SetFont('helvetica', 'U', 10); // Underlined for entity name
$pdf->Cell(70, 6, $entityName, 0, 1, 'L'); // Underline only this cell
$pdf->SetFont('helvetica', '', 10);  // Reset to normal font

$pdf->SetX(13);
// Fund Cluster and PAR No.
$pdf->Cell(35, 6, "Fund Cluster:", 0, 0, 'L');  // Left-aligned
$pdf->SetFont('helvetica', 'U', 10); // Underlined for fund cluster
$pdf->Cell(75, 6, $fundCluster, 0, 0, 'L');  // Underline only this cell
$pdf->SetFont('helvetica', '', 10);  // Reset to normal font

$pdf->SetX(95);
$pdf->Cell(55, 6, "PAR No.:", 0, 0, 'R');  // Right-aligned
$pdf->SetFont('helvetica', 'U', 10); // Underlined for PAR No.
$pdf->Cell(25, 6, $parNumber, 0, 1, 'R');  // Underline only this cell
$pdf->SetFont('helvetica', '', 10);  // Reset to normal font


// Add spacing
$pdf->Ln(5);

// Table headers (centered)
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
$pdf->SetFont('helvetica', '', 10);

// Header row
$pdf->Cell(25, 8, "Quantity", 1, 0, 'C');
$pdf->Cell(25, 8, "Unit", 1, 0, 'C');
$pdf->Cell(65, 8, "Description", 1, 0, 'C');
$pdf->Cell(25, 8, "Property No.", 1, 0, 'C');
$pdf->Cell(25, 8, "Date Acquired", 1, 0, 'C');
$pdf->Cell(25, 8, "Amount", 1, 1, 'C');

// Populate table rows
$pdf->SetFont('helvetica', '', 8);
$totalAmount = 0;

foreach ($data as $row) {
    $totalAmount += $row['amount'];
    $pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
    $pdf->Cell(25, 8, $row['qty'], 'LR', 0, 'C');
    $pdf->Cell(25, 8, $row['unit'], 'LR', 0, 'C');
    $pdf->Cell(65, 8, $row['desc'], 'LR', 0, 'C');
    $pdf->Cell(25, 8, $row['prop_no'], 'LR', 0, 'C');
    $pdf->Cell(25, 8, $row['date'], 'LR', 0, 'C');
    $pdf->Cell(25, 8, number_format($row['amount'], 2), 'LR', 1, 'C');
}
$pdf->SetX(3);
$pdf->Cell(35, 165, '', 'R', 0, 'C');
$pdf->Cell(25, 165, '', 'R', 0, 'C');
$pdf->Cell(65, 165, '', 'R', 0, 'C');
$pdf->Cell(25, 165, '', 'R', 0, 'C');
// Add total amount row
$pdf->SetX(($pdf->GetPageWidth() - $tableWidth) / 2);  // Center position
$pdf->Cell(165, 165, "", 'LB', 0, 'R');
$pdf->Cell(25, 165, "", 'LRB', 0, 'C');

// Add signature section
$pdf->Ln(160);
$pdf->Cell(330, 0, number_format($totalAmount, 2), 0, 0, 'C');
$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
// Signature lines
$pdf->Cell(115, 20, "Received by:", 'LR', 0, 'L');
$pdf->Cell(75, 20, "Issued by:", 'LR', 1, 'L');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(115, 6, "___________________________________", 'LR', 0, 'C');
$pdf->Cell(75, 6, "___________________________________", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(115, 6, $received_by, 'LR', 0, 'C');
$pdf->Cell(75, 6, $issued_by, 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(115, 6, "Signature over Printed Name of End User", 'LR', 0, 'C');
$pdf->Cell(75, 6, "Signature over Printed Name of Supply/Property Custodian", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(115, 6, "$position", 'LR', 0, 'C');
$pdf->Cell(75, 6, "$position2", 'LR', 1, 'C');

$pdf->SetX(($pdf->GetPageWidth() - $signWidth) / 2);  // Center position
$pdf->Cell(115, 6, "$receive_date", 'LRB', 0, 'C');
$pdf->Cell(75, 6, "$issue_date", 'LRB', 1, 'C');

// Output PDF
$pdf->Output('property_acknowledgment_receipt.pdf', 'I');
?>
