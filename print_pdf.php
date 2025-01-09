<?php
require_once('tcpdf/tcpdf.php');
require_once('config.php'); // Ensure you have a connection file

// Get the ID from the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID is required.");
}
$id = intval($_GET['id']);

// Fetch data from the database
$query = "SELECT *
          FROM `qr_tb` 
          WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Record not found.");
}

// Collect data for the PDF
$propname = $data['article'];
$propid = $data['property_id'];
$qty = $data['unit'];
$cost = number_format($data['cost'], 2);
$qrdata = $data['serial_id']; // Assuming QR data is serial_id
$office = $data['office'];
$coa = $data['coa_rep'];
$custod = $data['property_cus'];
$acquired = $data['date_acquired'];
$formattedDateAcquired = date('F d, Y', strtotime($acquired));
$counted = $data['date_counted'];
$formattedDateCounted = date('F d, Y', strtotime($counted));
$status = explode(',', $data['service_status']); // Assuming service_status is a comma-separated string

// Create new PDF document with custom dimensions
$pdf = new TCPDF('L', 'mm', array(50, 25), true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Property Sticker');

// Set margins
$pdf->SetMargins(1, 1, 1);
$pdf->SetAutoPageBreak(false, 0);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 6);

// Place logo at upper left
$imageFile = 'image/2.png'; // Replace with the actual path to your 2.png file
$pdf->Image($imageFile, 2, 2, 4.5, 4.5, '', '', '', true);

// University title and heading
$pdf->SetFont('helvetica', 'B', 4);
$pdf->SetXY(-50, 2);
$pdf->Cell(0, 3, 'NORTH EASTERN MINDANAO STATE UNIVERSITY', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 4);
$pdf->SetXY(-50, 4);
$pdf->Cell(0, 3, 'CANTILAN CAMPUS', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 4);
$pdf->SetXY(-50, 7);
$pdf->Cell(0, 3, 'Government Property', 0, 1, 'C');
$pdf->SetFont('helvetica', 'U', 3.5);
$pdf->SetXY(-50, 9);
$pdf->Cell(0, 3, $office, 0, 1, 'C');
$pdf->SetFont('helvetica', 'I', 2.5);
$pdf->SetXY(-50, 10);
$pdf->Cell(0, 3, 'Office/Location: ', 0, 1, 'C');

// QR code placement
$style = array(
    'border' => 0,
    'padding' => 1,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false
);
$pdf->write2DBarcode($qrdata, 'QRCODE,H', 43, 2, 5.5, 5.5, $style, 'N');

// Add your remaining PDF content generation code here (unchanged)

// Property details
// Set font for the first part (normal text)
$pdf->SetFont('helvetica', '', 2.9);
$pdf->SetXY(1, 12);

// Output the first part without underline
$pdf->Cell(0, 3, 'Article: ', 0, 0, 'L');

// Get the width of the first part for positioning
$firstPartWidth = $pdf->GetStringWidth('Article: ');

// Set underline style for the property name
$pdf->SetFont('helvetica', '', 2.9);
$pdf->SetXY(1 + $firstPartWidth, 12);  // Adjust position for underline text
$pdf->SetTextColor(0, 0, 0);  // Set color (optional)
$pdf->SetFont('', 'U');  // Apply underline style
// Output the property name with underline
$pdf->Cell(0, 3, $propname, 0, 1, 'L');
// Reset font style to normal after underline
$pdf->SetFont('helvetica', '', 2.9);

// Set font size
$pdf->SetFont('helvetica', '', 2.9);

// Define widths for labels and values
$labelWidth1 = 8;  // Adjust for Property No. label
$labelWidth2 = 9;  // Adjust for Serial No. label

// Set position and underline "Property No." and its value
$pdf->SetY(14);  // Position for the first line
$pdf->Cell($labelWidth1, 3, 'Property No.:', 0, 0, 'L');  // Label
$pdf->SetFont('', 'U');  // Enable underline
$pdf->Cell(0, 3, $propid, 0, 1, 'L');  // Underlined value
$pdf->SetFont('helvetica', '', 2.9);  // Reset font style

// Set position and underline "Serial No." and its value
$pdf->SetXY(25, -11);  // Adjust position as needed
$pdf->Cell($labelWidth2, 3, 'Serial No.:', 0, 0, 'L');  // Label
$pdf->SetFont('', 'U');  // Enable underline
$pdf->Cell(0, 3, $qrdata, 0, 1, 'L');  // Underlined value
$pdf->SetFont('helvetica', '', 2.9);  // Reset font style

// Set font size
$pdf->SetFont('helvetica', '', 2.9);

// Set position for Unit/Quantity
$pdf->SetY(18);
$pdf->Cell(30, 3, 'Unit/Quantity:', 0, 0, 'L');  // Label with fixed width
$pdf->SetFont('', 'U');  // Enable underline for the value
$pdf->SetX(9);
$pdf->Cell(0, 3, $qty, 0, 1, 'L');  // Underlined value
$pdf->SetFont('helvetica', '', 2.9);  // Reset font style

// Set position for Acquisition Cost
$pdf->SetXY(25, -7);
$pdf->Cell(30, 3, 'Acquisition Cost:', 0, 0, 'L');  // Label with fixed width
$pdf->SetFont('', 'U');  // Enable underline for the value
$pdf->SetX(34);
$pdf->Cell(0, 3, 'Php '.$cost, 0, 1, 'L');  // Underlined value
$pdf->SetFont('helvetica', '', 2.9);  // Reset font style

// Status checkboxes with smaller size
$pdf->SetFont('helvetica', '', 2.9);
$pdf->SetY(16);
$pdf->Cell(10, 3, 'Serviceable: ', 0, 0, 'L');
// Smaller checkbox (1.5 x 1.5)
$pdf->Rect(10, $pdf->GetY() + 0.5, 1.5, 1.5);
if (in_array('Serviceable', $status)) {
    $pdf->Line(10, $pdf->GetY() + 0.5, 11.5, $pdf->GetY() + 2);  // Adjust cross lines
    $pdf->Line(10, $pdf->GetY() + 2, 11.5, $pdf->GetY() + 0.5);
}

$pdf->SetFont('helvetica', '', 2.9);
$pdf->SetX(25);
$pdf->Cell(10, 3, 'Unserviceable: ', 0, 0, 'L');
// Smaller checkbox (1.5 x 1.5)
$pdf->Rect(35, $pdf->GetY() + 0.5, 1.5, 1.5);
if (in_array('Unserviceable', $status)) {
    $pdf->Line(35, $pdf->GetY() + 0.5, 36.5, $pdf->GetY() + 2);  // Adjust cross lines
    $pdf->Line(35, $pdf->GetY() + 2, 36.5, $pdf->GetY() + 0.5);
}


// Footer for signatures
$pdf->SetY(20.9);
$pdf->SetFont('helvetica', '', 1.9);

// Labels for Date Acquired and Date Counted
$pdf->Cell(24, 2, 'Date Acquired', 0, 0, 'C');
$pdf->Cell(24, 2, 'Date Counted', 0, 1, 'C');

// Values with underline
$pdf->SetY(-5);
$pdf->SetFont('', 'U');  // Enable underline
$pdf->Cell(24, 2, $formattedDateAcquired, 0, 0, 'C');  // Underlined COA Representative value
$pdf->Cell(24, 2, $formattedDateCounted, 0, 1, 'C');  // Underlined Property Custodian value
$pdf->SetFont('helvetica', '', 1.9);  // Reset font style

// Footer for signatures
$pdf->SetY(22.9);
$pdf->SetFont('helvetica', '', 1.9);

// Labels for COA Representative and Property Custodian
$pdf->Cell(24, 2, 'COA Representative', 0, 0, 'C');
$pdf->Cell(24, 2, 'Property Custodian', 0, 1, 'C');

// Values with underline
$pdf->SetY(22);
$pdf->SetFont('', 'U');  // Enable underline
$pdf->Cell(24, 2, $coa, 0, 0, 'C');  // Underlined COA Representative value
$pdf->Cell(24, 2, $custod, 0, 1, 'C');  // Underlined Property Custodian value
$pdf->SetFont('helvetica', '', 1.9);  // Reset font style

// Output PDF
$pdf->Output('property_sticker.pdf', 'I');
?>
