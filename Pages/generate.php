<?php
session_start();
require('fpdf/fpdf.php');
include_once '../config/Database.php';
include_once '../model/Table.php';

//Cell(w, h, txt, border)

class PDF extends FPDF
{
// Page header
	function Header()
	{
		// Logo
		$this->Image('RFS-logo.png',15,5,20);
		//Chevron
		$this->Image('RFS-chevron.png',40,5,160,25);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(30,60,'Bulli RFS Brigade',0,0,'C');
		
		//Sub-Heading
		$this->SetFontSize(10);
		$this->Cell(-30,70,'Financial Report for: ',0,0,'C');
		
		// Line break
		$this->Ln(20);
	}

// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',14);

//for($i=1;$i<=40;$i++)
	//$pdf->Cell(0,10,'Printing line number '.$i,0,1);

$pdf->SetX(20);
$pdf->SetY(50);
$pdf->Cell(10,10,'Opening Balance',0,1);
//$pdf->Line(20, 45, 210-20, 45);

$pdf->SetFont('Times','',12);
//$pdf->Cell(5,5,'Cheque account:                                                                                      '.$_POST['firstname'],0,1,);
//$pdf->Cell(5,5,'DGR:                                                                                                       '.$_POST['lastname'],0,1);
$pdf->Cell(5,5,'Term deposit: ',0,1);
$pdf->Cell(5,5,'Debit cards: ',0,1);
$pdf->Cell(5,5,'Petty cash: ',0,1);
$pdf->Cell(5,5,'Social account: ',0,1);
$pdf->Cell(5,5,'                                                                                                      Total: ',0,1);

$pdf->Ln();
$pdf->Ln();

//Incomes
//$pdf->SetX(20);
//$pdf->SetY(100);

$pdf->SetFont('Times','B',14);
$pdf->Cell(10,10,'Incomes',0,1);

$pdf->Output('I','Test.pdf');
?>



