<?php
	include 'plantilla.php';
	include "../connect/bd.php";
	$query = "SELECT id, nombre, precio FROM servicios;"; 
	$resultado= mysqli_query($conn,$query);
	$pdf = new PDF('P','mm','letter');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	?>

	<?php
		$pdf->Cell(65,4,'ID',1,0,'C',true);
		$pdf->Cell(65,4,'NOMBRE',1,0,'C',true);
		$pdf->Cell(65,4,'PRECIO',1,0,'C',true);	     
	?>

	<?php			   
	$pdf->SetFont('Arial','',12);
	while($row = mysqli_fetch_array($resultado))
	{
		         $pdf->Ln(4);
				 $pdf->Cell(65,4,$row['id'],1,0,'C');				 
				 $pdf->Cell(65,4,$row['nombre'],1,0,'C');			
		         $pdf->Cell(65,4,$row['precio'],1,0,'C');				
	}				
	$pdf->Output();
?>