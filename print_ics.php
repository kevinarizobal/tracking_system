<?php
include('config.php');
// Include the main TCPDF library
require_once('tcpdf/tcpdf.php');

$id = isset($_GET['id']) ? $_GET['id'] : ''; // Check if 'id' exists in the query parameter

if (empty($id)) {
    die('Item ID is required.');
}

// Prepare the SQL query with a parameterized statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM ics_tb WHERE item_no = ?");
$stmt->bind_param('s', $id); // 's' for string type
$stmt->execute();
$result = $stmt->get_result();

$rows = '';

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $entity_name = $row['entity_name'];
        $fund_cluster = $row['fund_cluster'];
        $ics_no = $row['ics_no'];
        $qty = $row['qty'];
        $unit = $row['unit'];
        $unit_cost = $row['unit_cost'];
        $total_cost = $row['total_cost'];
        $description = $row['description'];
        $item_no = $row['item_no'];
        $estimated = $row['estimate'];
        $receive_by = $row['receive_by'];
        $role1 = $row['role1'];
        $issue_by = $row['issue_by'];
        $role2 = $row['role2'];
        $date_file = $row['date_file'];
        $rows .= '
            <tr>
                <td style="height:100px; text-align: center;">' . $qty . '</td>
                <td style="text-align: center;">' . $unit . '</td>
                <td style="text-align: center;">' . $unit_cost . '</td>
                <td style="text-align: center;">' . $total_cost . '</td>
                <td style="text-align: justify;">' . $description . '</td>
                <td style="text-align: center;">' . $item_no . '</td>
                <td style="text-align: center;">' . $estimated . '</td>
            </tr>';
    }
}

$sql = "SELECT SUM(total_cost) as total_sum FROM ics_tb WHERE item_no = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $total_sum = $row['total_sum'];
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
$pdf->Cell(0, 10, 'INVENTORY CUSTODIAN SLIP (ICS)', 0, 1, 'C');
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
$pdf->Cell(50, 10, $ics_no, 0, 1); // PAR No. value

$pdf->Ln(5); // Add some space

// Define the table content
$html = '
<table border="1" cellpadding="7">
    <thead>
        <tr>
            <th style="background-color:#f2f2f2;text-align: center;">Quantity</th>
            <th style="background-color:#f2f2f2;text-align: center;">Unit</th>
            <th style="background-color:#f2f2f2;text-align: center;">Unit Cost</th>
            <th style="background-color:#f2f2f2;text-align: center;">Total Cost</th>
            <th style="background-color:#f2f2f2;text-align: center;">Description</th>
            <th style="background-color:#f2f2f2;text-align: center;">Inventory Item No.</th>
            <th style="background-color:#f2f2f2;text-align: center;">Estimated Useful Life</th>
        </tr>
    </thead>
    <tbody>
        ' . $rows . '
        <tr>
            <td colspan="7" style="text-align: right;">Total: '.$total_sum.'.00</td>
        </tr>
        <tr>
            <td colspan="3">Received by:<br><br><br>
                <div style="text-align: center;">
                    <span style="text-decoration: underline; text-decoration-thickness: 3px;">'.$receive_by.'</span><br>
                    Signature over Printed Name of End User<br>
                    '.$role1.'<br>
                    Position/Office<br>
                    '.$date_file.'<br>
                    Date
                </div>
            </td>
            <td colspan="4">Issued by:<br><br><br>
                <div style="text-align: center;">
                    <span style="text-decoration: underline; text-decoration-thickness: 3px;">'.$issue_by.'</span><br>
                    Signature over Printed Name of End User<br>
                    '.$role2.'<br>
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
