<?php
require_once '../../fpdf/fpdf.php';
require_once '../../controlador/persistencia/ControladorPersistencia.php';   
//require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    
    $this->SetFont('Arial', 'B', '20');
    $this->Cell(300,10,"LISTADO DE USUARIOS:",0,0,'C');
    $this->Ln();
    $this->Ln();
    $this->SetFillColor(2,157,116);
    $this->SetTextColor(240, 255, 240);
    $this->Cell(60,15,"NOMBRE",1, 0, 'C', true);
    $this->Cell(60,15,"APELLIDO",1, 0, 'C', true);
    $this->Cell(60,15,"USUARIO",1, 0, 'C', true);
    $this->Cell(60,15,"TIPO ACCESO",1, 0, 'C', true);
    $this->Cell(80,15,"FECHA CREACION",1, 0, 'C', true);
    $this->Cell(80,15,"FECHA MODIFICACION",1, 0, 'C', true);    
    $this->Ln();
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Practica Profesional Guirao Lazarte Bilyk--Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('A','A3');
$cp = new ControladorPersistencia();
    $listadoUsuarios = $cp->ejecutarSentencia(DBSentencias::BUSCAR_USUARIOS);
    $alterna = true;
    $tipo="";
    foreach ($listadoUsuarios as $usuarios) {
        
        if($usuarios['tipoAcceso_usuario']== 1){
            $tipo = "Total";
        }else
        {
            $tipo = "Restringrido";
        }
        
        
        if ($alterna) {
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(60,10, utf8_decode($usuarios['nombre_usuario']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($usuarios['apellido_usuario']),1, 0, 'L', true);
            $pdf->Cell(60,10, utf8_decode($usuarios['usuario_usuario']),1, 0, 'L', true);
            $pdf->Cell(60,10, $tipo,1, 0, 'L', true);
            $pdf->Cell(80,10, utf8_decode($usuarios['fch_creacion']),1, 0, 'L', true);
            $pdf->Cell(80,10, utf8_decode($usuarios['fch_modificacion']),1, 0, 'L', true);
            $pdf->Ln();
            $alterna = !$alterna;
        }else{
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(60,10, utf8_decode($usuarios['nombre_usuario']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($usuarios['apellido_usuario']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($usuarios['usuario_usuario']),1, 0, 'L', FALSE);
            $pdf->Cell(60,10, utf8_decode($tipo),1, 0, 'L', FALSE);
            $pdf->Cell(80,10, utf8_decode($usuarios['fch_creacion']),1, 0, 'L', FALSE);
            $pdf->Cell(80,10, utf8_decode($usuarios['fch_modificacion']),1, 0, 'L', FALSE);
            $pdf->Ln();
            $alterna = !$alterna;
        }
        
        
        
    }

$pdf->Output();
?>