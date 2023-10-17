<?php
// Include FPDF library
require('pdf/fpdf.php');

// Create a PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set font for the entire document
$pdf->SetFont('Arial', '', 12);

// Add a title
$pdf->Cell(0, 10, 'Purchase Order', 0, 1, 'C');

// Add content to the PDF
$pdf->Cell(50, 10, 'Date: ' . date('Y-m-d'), 0, 1);
$pdf->Cell(50, 10, 'Bill To:', 0, 1);
$pdf->MultiCell(0, 10, 'John Doe' . "\n" . '123 Main Street' . "\n" . 'City, State ZIP', 0, 'L');
$pdf->Cell(50, 10, 'Ship To:', 0, 1);
$pdf->MultiCell(0, 10, 'Jane Smith' . "\n" . '456 Elm Street' . "\n" . 'City, State ZIP', 0, 'L');

// Add a table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Item', 1);
$pdf->Cell(50, 10, 'Description', 1);
$pdf->Cell(20, 10, 'Quantity', 1);
$pdf->Cell(20, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln(); // Move to the next row

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, 'Item 1', 1);
$pdf->Cell(50, 10, 'Description 1', 1);
$pdf->Cell(20, 10, '2', 1);
$pdf->Cell(20, 10, '$10.00', 1);
$pdf->Cell(30, 10, '$20.00', 1);
$pdf->Ln();

$pdf->Cell(30, 10, 'Item 2', 1);
$pdf->Cell(50, 10, 'Description 2', 1);
$pdf->Cell(20, 10, '3', 1);
$pdf->Cell(20, 10, '$15.00', 1);
$pdf->Cell(30, 10, '$45.00', 1);

// Output the PDF (D for download)
$pdf->Output('purchase_order.pdf', 'D');

// Exit
exit;
?>
