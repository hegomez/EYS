<?php include("inc/conn.php") ?>
<?php include("inc/func.php") ?>
<?php include("fpdf/fpdf.php")?>
<?php
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetMargins(15, 15, 15);
	$pdf->Image('img/logo_.png',5,5,32.25,21);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,4,'INSTITUTO DE CIRUGIA DE OJOS LTDA.',0,1,"C");
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,4,'NIT: 830038378 4',0,1,"C");
	$pdf->ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'RELACION DE CIRUGIAS PROGRAMADAS Y DE URGENCIAS "DETALLADA"',1,1,"C");
	$pdf->SetFont('Arial','B',9);
	//180
	$pdf->Cell(15,4,utf8_decode('Admisión'),1,0,"C");
	$pdf->Cell(20,4,utf8_decode('Fecha'),1,0,"C");
	$pdf->Cell(30,4,utf8_decode('Identificación'),1,0,"C");
	$pdf->Cell(55,4,utf8_decode('Paciente'),1,0,"C");
	$pdf->Cell(25,4,utf8_decode('EPS'),1,0,"C");
	$pdf->Cell(15,4,utf8_decode('Servicio'),1,0,"C");
	$pdf->Cell(20,4,utf8_decode('Valor'),1,1,"C");

	$RS=$bd->query("SELECT * FROM cc where mes='".$_GET['mes']."' and ano='".$_GET['ano']."' ORDER BY admision");
	
	while($PROC=$RS->fetch_assoc())
	{
		//$pdf->
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(15,4,utf8_decode($PROC['admision']),1,0);
		$pdf->Cell(20,4,utf8_decode($PROC['fecha']),1,0);
		$pdf->Cell(30,4,utf8_decode($PROC['identificacion']),1,0);
		$pdf->Cell(55,4,utf8_decode($PROC['nombre']),1,0);
		$pdf->Cell(25,4,utf8_decode($PROC['eps']),1,0);
		$pdf->Cell(15,4,utf8_decode($PROC['servicio']),1,0);
		$pdf->Cell(20,4,'$'.utf8_decode(number_format($PROC['valor'],0,',','.')),1,1,'R');
		$RES=$bd->query("SELECT * FROM data where admision=".$PROC['admision']);
		$pdf->SetFont('Courier','',8);
		while($ROW=$RES->fetch_assoc())
		{
			$pdf->Cell(15,4,utf8_decode($ROW['cups']),1,0);
			$pdf->Cell(145,4,substr($ROW['proc'],0,73),1,0);
			$pdf->Cell(20,4,utf8_decode(number_format($ROW['valor'],0,',','.')),1,1,'R');
		}
	}

	$pdf->Output();
?>