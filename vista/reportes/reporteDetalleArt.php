<?php
    require_once '../../fpdf/fpdf.php';
    require_once '../../controlador/persistencia/ControladorPersistencia.php';
    if (isset($_GET["id"])) {
        $id=$_GET["id"];
        $idUsuario=$_GET["idUsuario"];
        $pdf=new FPDF();
        $pdf->AddPage('P', 'A3');
        $fecha = time();//coloca la fecha actual
        $formatoFecha=date('d-m-Y H:i:s');
        $file ="../images/logo.png"; 
        $pdf->Image($file);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', '12');
        
        $pdf->Cell(300,10,'Fecha: '.$formatoFecha,0,0,'C');
        $pdf->ln();
        $pdf->SetFont('Arial', 'B', '20');
        $pdf->Cell(100,10,"DETALLE DEL ART:",0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        
        
        
        $cp = new ControladorPersistencia();
        $respArt = $cp->ejecutarSentencia(DBSentencias::BUSCAR_UNA_ART, array($id));
        $arts = $respArt->fetchAll(PDO::FETCH_ASSOC);
       
        
        foreach ($arts as $art) {
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"NOMBRE",1, 0, 'C', true);
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(100,15, utf8_decode($art['nombre_art']),1, 0, 'C', true);
            $pdf->Ln();
            
            
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"DIRECCION",1, 0, 'C', true);
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(100,15, utf8_decode($art['direccion_art']),1, 0, 'C', true);
            $pdf->Ln();
            
            
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"DETALLE",1, 0, 'C', true);
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(100,15, utf8_decode($art['detalle_art']),1, 0, 'C', true);
            $pdf->Ln();
            
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"CREADO",1, 0, 'C', true);
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(100,15, utf8_decode($art['fch_creacion']),1, 0, 'C', true);
            $pdf->Ln();
            
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"MODIFICADO",1, 0, 'C', true);
            if ($art['fch_modificacion'] == '0000-00-00 00:00:00')
                {
                    $pdf->SetFont('Arial', '', '16');
                    $pdf->SetFillColor(229, 229, 229);
                    $pdf->SetTextColor(3, 3, 3);
                    $pdf->Cell(100,15, "La ART No ha sido Modificada",1, 0, 'C', true);
                    $pdf->Ln();
                
                }else
                    {
                    
                    $pdf->SetFont('Arial', '', '16');
                    $pdf->SetFillColor(229, 229, 229);
                    $pdf->SetTextColor(3, 3, 3);
                    $pdf->Cell(100,15, utf8_decode($art['fch_modificacion']),1, 0, 'C', true);
                    $pdf->Ln();
                    
                    }
          
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(2,157,116);
            $pdf->SetTextColor(240, 255, 240);
            $pdf->Cell(100,15,"CREADO POR",1, 0, 'C', true);
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(100,15, utf8_decode($art['nombre_usuario']),1, 0, 'C', true);
            $pdf->Ln();
            
            
                        
    }
    $pdf->Ln();
    
    $respUsuario = $cp->ejecutarSentencia(DBSentencias::BUSCAR_USUARIO_ID,array($idUsuario) );
           $usuarios = $respUsuario->fetchAll(PDO::FETCH_ASSOC);
            
           foreach ($usuarios as $usuario) {
               
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetFillColor(254,254,254);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150,15,"USUARIO QUE REALIZO LA CARGA",1, 0, 'C', true);
            
            $pdf->Ln();
            
            $pdf->SetFont('Arial', '', '16');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(50,15, utf8_decode($usuario['nombre_usuario']),1, 0, 'C', true);
            $pdf->Cell(50,15, utf8_decode($usuario['apellido_usuario']),1, 0, 'C', true);
            $pdf->Cell(50,15, utf8_decode($usuario['usuario_usuario']),1, 0, 'C', true);
            $pdf->Ln();
           }  
           
           $consultaUsuarios=$cp->ejecutarSentencia(DBSentencias::BUSCAR_USUARIO_ID,array($idUsuario));
    $usuarios = $consultaUsuarios->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuarioF) {
        
        $usuario=$usuarioF['usuario_usuario'];
    }
    // Posición: a 1,5 cm del final
    $pdf->SetY(380);
    // Arial italic 8
    $pdf->SetFont('Arial','I',12);
    // Número de página
    $pdf->Cell(0,10,'Practica Profesional Guirao Lazarte Bilyk--Pagina '.$pdf->PageNo().' Usuario: '.$usuario,0,0,'C');
           
           
           
        $pdf->Output();
    }

