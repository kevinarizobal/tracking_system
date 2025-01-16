<?php
include('config.php');
// Include the main TCPDF library
require_once('tcpdf/tcpdf.php');

$id = $_GET['id'];

$sql = "SELECT * FROM par_tb WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $qty = $row['qty'];
    $unit = $row['unit'];
    $description = $row['description'];
    $property_number = $row['property_number'];
    $date_acquired = $row['date_acquired'];
    $amount = $row['amount'];
    $entity_name = $row['entity_name'];
    $fund_cluster = $row['fund_cluster'];
    $par_no = $row['par_no'];
    $position = $row['position'];
    $received_by = $row['received_by'];
    $issued_by = $row['issued_by'];
    $date_file = $row['date_file'];
  }
}


// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('NEMSU-SUPTRACK');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, table, example, guide');

// Set default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Add header
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'PROPERTY ACKNOWLEDGMENT RECEIPT', 0, 1, 'C');
$pdf->Ln(5); // Add some space

// Add entity details
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(50, 10, 'Entity Name:', 0, 0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(100, 10, $entity_name, 0, 1);

$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(50, 10, 'Fund Cluster:', 0, 0); // Fund Cluster label
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(50, 10, $fund_cluster, 0, 0); // Fund Cluster value

$pdf->SetX(120); // Move to the right for PAR No.
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(30, 10, 'PAR No.:', 0, 0); // PAR No. label
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(50, 10, $par_no, 0, 1); // PAR No. value

$pdf->Ln(5); // Add some space

// Define the table content
$html = '
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th style="background-color:#f2f2f2;text-align: center;">Quantity</th>
            <th style="background-color:#f2f2f2;text-align: center;">Unit</th>
            <th style="background-color:#f2f2f2;text-align: center;">Description</th>
            <th style="background-color:#f2f2f2;text-align: center;">Property Number</th>
            <th style="background-color:#f2f2f2;text-align: center;">Date Required</th>
            <th style="background-color:#f2f2f2;text-align: center;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height:280px; text-align: center;">'.$qty.'</td>
            <td style="text-align: center;">'.$unit.'</td>
            <td style="text-align: justify;">'.$description.'</td>
            <td style="text-align: center;">'.$property_number.'</td>
            <td style="text-align: center;">'.$date_acquired.'</td>
            <td style="text-align: right;">'.$amount.'<br><br><br><br><br>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <br><br><br>'.$amount.'</td>
        </tr>
        <tr>
            <td colspan="3">Received by:<br><br><br>
                <div style="text-align: center;">
                    <span style="text-decoration: underline; text-decoration-thickness: 3px;">'.$received_by.'</span><br>
                    Signature over Printed Name of End User<br>
                    '.$position.'<br>
                    Position/Office<br>
                    '.$date_file.'<br>
                    Date
                </div>
            </td>
            <td colspan="3">Issued by:<br><br><br>
                <div style="text-align: center;">
                    <span style="text-decoration: underline; text-decoration-thickness: 3px;">'.$issued_by.'</span><br>
                    Signature over Printed Name of End User<br>
                    AOI/Supply Office<br>
                    Position/Office<br>
                    '.$date_file.'<br>
                    Date
                </div>
            </td>
        </tr>
    </tbody>
</table>
';

// Output the table using writeHTML
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output the PDF document
$pdf->Output('example_table.pdf', 'I');
?>
