<?php
require_once('tcpdf/tcpdf.php');

// Fetch form data
$office = $_POST['office'];
$propertyName = $_POST['article'];
$propertyId = $_POST['property_no'];
$serialNo = $_POST['serial_no'];
$condition = $_POST['condition']; // Fetching the selected condition directly
$unitQuantity = $_POST['unit_quantity'];
$acquisitionCost = $_POST['acquisition_cost'];
$dateAcquired = $_POST['date_acquired'];
$dateCounted = $_POST['date_counted'];
$coaRepresentative = $_POST['coa_representative'];
$propertyCustodian = $_POST['property_custodian'];
$copies = intval($_POST['copies']);

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Government Property Stickers');
$pdf->SetSubject('Generated Stickers');

// Disable header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set default font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Sticker dimensions and layout
$stickerWidth = 95; // Width of a sticker
$stickerHeight = 50; // Height of a sticker
$marginX = 10; // Left margin
$marginY = 10; // Top margin
$columns = 2; // Number of stickers per row
$rows = 5; // Number of stickers per column

// Set the path to the image
$imagePath = 'image/2.png'; // Replace with the correct path to your image

$count = 0;

for ($i = 0; $i < $copies; $i++) {
    // Calculate position for the sticker
    $x = $marginX + ($count % $columns) * $stickerWidth;
    $y = $marginY + floor($count / $columns) * $stickerHeight;

    // Add a new page if current page is full
    if ($count > 0 && $count % ($columns * $rows) === 0) {
        $pdf->AddPage();
        $x = $marginX;
        $y = $marginY;
    }

    // Draw sticker border
    $pdf->Rect($x, $y, $stickerWidth, $stickerHeight);

    // Add image
    $pdf->Image($imagePath, $x + 5, $y + 5, 15, 15); // Adjust the position and size as needed

    // Generate QR code content
    $qrContent = $serialNo;
    
    // Add QR code
    $pdf->write2DBarcode($qrContent, 'QRCODE,H', $x + $stickerWidth - 20, $y + 5, 15, 15, array('border' => 0), 'N');

    // Header
    $pdf->SetXY($x + 23, $y + 5);
    $pdf->SetFont('helvetica', 'B', 5.5);
    $pdf->Cell(0, 0, "NORTH EASTERN MINDANAO STATE UNIVERSITY", 0, 1, 'L');

    $pdf->SetFont('helvetica', 'B', 5.5);
    $pdf->SetXY($x + 35, $y + 8);
    $pdf->Cell(0, 3, 'CANTILAN CAMPUS', 0, 1, 'L');

    // Sticker Title
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetXY($x + 32, $y + 12.5);
    $pdf->Cell(0, 3, 'Government Property', 0, 1, 'L');

    // Office or Location
    $pdf->SetFont('helvetica', 'U', 6);
    $pdf->SetXY($x + 27, $y + 17);
    $pdf->Cell(0, 3, $office, 0, 1, 'L');

    // Office or Location tag
    $pdf->SetFont('helvetica', 'I', 3);
    $pdf->SetXY($x + 40, $y + 19);
    $pdf->Cell(0, 3, 'Office/Location', 0, 1, 'L');

    // Set font and position Article
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 15, $y + 24);

    // Add text with a long underline
    $pdf->Cell(0, 0, "Article: $propertyName", 0, 1, 'L');

    // Draw underline
    $startX = $x + 0 + $pdf->GetStringWidth("Article: $propertyName") + 2; // Adjust position after the text
    $lineWidth = 50; // Adjust the width of the underline
    $pdf->Line($startX, $y + 27, $startX + $lineWidth, $y + 27); // Draw line

    // Set font and position for Property No.
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 15, $y + 28);

    // Add text with a long underline
    $pdf->Cell(0, 0, "Property No.: $propertyId", 0, 1, 'L');

    // Draw underline
    $startX = $x + 5 + $pdf->GetStringWidth("Property No.: $propertyId") + 2; // Adjust position after the text
    $lineWidth = 13; // Adjust the width of the underline
    $pdf->Line($startX, $y + 31, $startX + $lineWidth, $y + 31); // Draw line

    // Set font and position for Serial No.
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 45, $y + 28);

    // Add text with a long underline
    $pdf->Cell(0, 0, "Serial No.: $serialNo", 0, 1, 'L');

    // Draw underline
    $startX = $x + 36 + $pdf->GetStringWidth("Serial No.: $serialNo") + 2; // Adjust position after the text
    $lineWidth = 16.5; // Adjust the width of the underline
    $pdf->Line($startX, $y + 31, $startX + $lineWidth, $y + 31); // Draw line

    // Set font and position checkbox
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 15, $y + 31.5);

    // Draw "Serviceable" checkbox with check mark if the condition is serviceable
    $pdf->Cell(0, 0, "Serviceable", 0, 0); // Label for condition

    // Create the checkbox for "Serviceable"
    $boxX = $pdf->GetX();
    $boxY = $pdf->GetY();
    $checkboxSize = 3; // Adjust the size of the checkbox
    $pdf->Rect($x + 30, $boxY, $checkboxSize, $checkboxSize); // Draw the checkbox

    // If condition is serviceable, draw the check mark
    if ($condition == 'Serviceable') {
        $pdf->SetTextColor(0, 0, 0); // Set black color for the check mark
        $pdf->Text($x + 30, $boxY + 0, 'X'); // Draw the check mark inside the checkbox
    }

    // Move to next position for "Unserviceable"
    $pdf->SetXY($x + 45, $boxY);

    // Create the checkbox for "Unserviceable"
    $pdf->Cell(0, 0, "Unserviceable", 0, 0); // Label for condition

    // Draw the checkbox for "Unserviceable"
    $boxX2 = $pdf->GetX();
    $pdf->Rect($x + 65, $boxY, $checkboxSize, $checkboxSize); // Draw the checkbox

    // If condition is unserviceable, draw the check mark
    if ($condition == 'Unserviceable') {
        $pdf->SetTextColor(0, 0, 0); // Set black color for the check mark
        $pdf->Text($x + 65, $boxY + 0, 'X'); // Draw the check mark inside the checkbox
    }


    // Set font and position for Unit/Qty No.
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 15, $y + 35);

    // Add text with a long underline
    $pdf->Cell(0, 0, "Unit/Quantity: $unitQuantity", 0, 1, 'L');

    // Draw underline
    $startX = $x + 13 + $pdf->GetStringWidth("Unit/Quantity: $unitQuantity") + 2; // Adjust position after the text
    $lineWidth = 8; // Adjust the width of the underline
    $pdf->Line($startX, $y + 38, $startX + $lineWidth, $y + 38); // Draw line


    // Set font and position for Acquisition Cost
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetXY($x + 45, $y + 35);

    // Add text with a long underline
    $pdf->Cell(0, 0, "Acquisition Cost: $acquisitionCost", 0, 1, 'L');

    // Draw underline
    $startX = $x + 37 + $pdf->GetStringWidth("Acquisition Cost: $acquisitionCost") + 2; // Adjust position after the text
    $lineWidth = 10; // Adjust the width of the underline
    $pdf->Line($startX, $y + 38, $startX + $lineWidth, $y + 38); // Draw line

    // Set font and position for Date Acquired
    $pdf->SetFont('helvetica', 'U', 6);
    $pdf->SetXY($x + 15, $y + 39);
    $pdf->Cell(0, 0, "$dateAcquired", 0, 1, 'L');

    $pdf->SetFont('helvetica', 'I', 4);
    $pdf->SetXY($x + 15, $y + 41);
    $pdf->Cell(0, 0, "Date Acquired", 0, 1, 'L');

    // Set font and position for Date Counted
    $pdf->SetFont('helvetica', 'U', 6);
    $pdf->SetXY($x + 45, $y + 39);
    $pdf->Cell(0, 0, "$dateCounted", 0, 1);

    $pdf->SetFont('helvetica', 'I', 4);
    $pdf->SetXY($x + 45, $y + 41);
    $pdf->Cell(0, 0, "Date Counted", 0, 1, 'L');

    // Set font and position for COA
    $pdf->SetFont('helvetica', 'U', 6);
    $pdf->SetXY($x + 15, $y + 43);
    $pdf->Cell(0, 0, "$coaRepresentative", 0, 1);

    $pdf->SetFont('helvetica', 'I', 4);
    $pdf->SetXY($x + 15, $y + 45.5);
    $pdf->Cell(0, 0, "COA Representative", 0, 1);

    $pdf->SetFont('helvetica', 'U', 6);
    $pdf->SetXY($x +45, $y + 43.5);
    $pdf->Cell(0, 0, "$propertyCustodian", 0, 1);

    $pdf->SetFont('helvetica', 'I', 4);
    $pdf->SetXY($x + 45, $y + 45.5);
    $pdf->Cell(0, 0, "Property Custodian", 0, 1);

    $count++;
}

// Output PDF
$pdf->Output('property_stickers.pdf', 'I');
?>
