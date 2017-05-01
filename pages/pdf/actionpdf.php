
<?php session_start();

require('WriteHTML.php');
$date=date('d-m-y');

$pdf=new PDF_HTML();

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);

$pdf->AddPage();
$pdf->Image('logo.png',18,13,33);
$pdf->SetFont('Arial','b',12);
$pdf->WriteHTML('<para><br><br><center>'.$_SESSION['user'].'  Date:'.$date.'</center><br>');

$pdf->SetFont('courier','B',8); 

$htmlTable='<table style="background:gray;">'.$_SESSION['pdf'].'</table>';

$pdf->WriteHTML2("$htmlTable");
$pdf->SetFont('Arial','B',6);
$pdf->Output(); 
?>
