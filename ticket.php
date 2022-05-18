<?php

require(__DIR__.'/pdf_js.php');

class PDF_AutoPrint extends PDF_JavaScript {
    function AutoPrint($printer='') {
        // Open the print dialog
        if($printer) {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        } else {
            $script = 'print(true);';
        }
        
        $this->IncludeJS($script);
    }
}

function hacerTicket($nombreCom,$razonSoc,$dir1,$dir2,$cPostal,$ciudad,$estado,$pais,$email,$telefono,$rfc,$id,$fecha,$tiempo,$mesero,$mesa,$nCaja,$pIva,$total,$efectivo,$cambio,$detalles,$nSuc,$contSuc) {
    $noArticulos = count($detalles);
    $pdf = new PDF_AutoPrint('P','mm',array(80,109+($noArticulos*6))); // ancho x largo en mm
    $pdf->AddPage();                                //minimo 106 + 6 por cada articulo
    
    // CABECERA
    $pdf->AddFont('Helvetica','','Helvetica Regular.ttf',true);
    $pdf->AddFont('Helvetica','B','Helvetica Bold.ttf',true);
    $pdf->SetFont('Helvetica','',12);
    $pdf->Cell(60,4,$nombreCom,0,1,'C');
    $pdf->SetFont('Helvetica','',7);
    $pdf->Cell(60,3,$razonSoc,0,1,'C');
    $pdf->Cell(60,3,'RFC: '.$rfc,0,1,'C');
    $pdf->Cell(60,3,$dir1,0,1,'C');
    $pdf->Cell(60,3,$dir2.' C.P. '.$cPostal,0,1,'C');
    $pdf->Cell(60,3,$ciudad.', '.$estado.', '.$pais,0,1,'C');
    $pdf->Cell(60,3,'Tel: '.$telefono,0,1,'C');
    $pdf->Cell(60,3,$email,0,1,'C');
    
    // DATOS TICKET        
    $pdf->Ln(3);
    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Cell(60,3,'Folio: '.$id,0,1,'');
    $pdf->Cell(60,3,'Fecha y hora: '.' '.$fecha.' '.$tiempo,0,1,'');
    $pdf->Cell(60,3,'Metodo de pago: Efectivo',0,1,'');
    $pdf->Cell(60,3,'Le atendió: '.$mesero,0,1,'');
    $pdf->Cell(60,3,'Mesa: '.$mesa.' Caja: '.$nCaja.' No. de sucursal: '.$nSuc,0,1,'');
    $pdf->Cell(60,3,'Contacto: '.$contSuc,0,1,'');
    
    // COLUMNAS
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Cell(30, 10, 'Producto', 0);
    $pdf->Cell(5, 10, 'Cant.',0,0,'R');
    $pdf->Cell(10, 10, 'P.Unit',0,0,'R');
    $pdf->Cell(15, 10, 'Total',0,0,'R');
    $pdf->Ln(8);
    $pdf->Cell(60,0,'','T');
    $pdf->Ln(1);
    
    // PRODUCTOS
    $pdf->SetFont('Helvetica', '', 7);
    foreach($detalles as $detalle){
        $cantidad = $detalle['cantidad'];
        $precio = $detalle['unitaryPrice_product'];
        $nombre = $detalle['name_product'];
        $pdf->MultiCell(30,4,$nombre,0,'L'); 
        $pdf->Cell(35, -5,$cantidad,0,0,'R');
        $pdf->Cell(10, -5, '$'.number_format(round($precio,2), 2, '.', ','),0,0,'R');
        $pdf->Cell(15, -5, '$'.number_format(round($precio*$cantidad,2), 2, '.', ','),0,0,'R');
        $pdf->Ln(2);
    }
    
    //SUMATORIO DE LOS PRODUCTOS Y EL IVA 
    if ($pIva != 0) {
        $pdf->Cell(60,0,'','T'); $pdf->Ln(1); 
        $pdf->Cell(25, 10, 'SUBTOTAL', 0); $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '$'.number_format(round((round($total,2)/($pIva/100+1)),2), 2, '.', ','),0,0,'R');
        $pdf->Ln(3); 
        $pdf->Cell(25, 10, 'I.V.A. '.$pIva.'%', 0); $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '$'.number_format(round((round($total,2)*($pIva/100)),2), 2, '.', ','),0,0,'R');
        $pdf->Ln(3); 
    } else {
        $pdf->Cell(60,0,'','T'); $pdf->Ln(1); 
        $pdf->Cell(25, 10, 'SUBTOTAL', 0); $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '$'.number_format(round($total,2), 2, '.', ','),0,0,'R');
        $pdf->Ln(3); 
        $pdf->Cell(25, 10, 'I.V.A. 0%', 0); $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '$0.00',0,0,'R');        
        $pdf->Ln(3); 
    }
    $pdf->Cell(25, 10, 'TOTAL', 0); $pdf->Cell(20, 10, '', 0); 
    $pdf->Cell(15, 10, '$'.number_format(round($total,2), 2, '.', ','),0,0,'R'); 
    $pdf->Ln(3); 
    $pdf->Cell(25, 10, 'EFECTIVO', 0); $pdf->Cell(20, 10, '', 0); 
    $pdf->Cell(15, 10, '$'.number_format(round($efectivo,2), 2, '.', ','),0,0,'R'); 
    $pdf->Ln(3); 
    $pdf->Cell(25, 10, 'CAMBIO', 0); $pdf->Cell(20, 10, '', 0); 
    $pdf->Cell(15, 10, '$'.number_format(round($cambio,2), 2, '.', ','),0,0,'R'); 
    $pdf->Ln(6); 

    // PIE DE PAGINA $pdf->Ln(10); 
    $pdf->Cell(60,4,'¡GRACIAS POR SU PREFERENCIA!',0,1,'C');
    $pdf->AutoPrint();
    $pdf->Output('ticket.pdf','i');
    $pdf->Output('ticket.pdf','d');

}

?>