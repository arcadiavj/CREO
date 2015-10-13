<?php
require_once '../../fpdf/fpdf.php';
require_once '../../controlador/persistencia/ControladorPersistencia.php';   
//require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    
    $fecha = time();//coloca la fecha actual
    $formatoFecha=date('d-m-Y H:i:s');//formato para mostrar en pantalla
    $file ="../images/logo.png"; 
    $this->Image($file);
    $this->SetFont('Arial', 'B', '15');
    $this->Cell(300,10,'Fecha: '.$formatoFecha,0,0,'R');
    $this->Ln();
    $this->Cell(300,10,"LISTADO DE ART:",0,0,'C');
    $this->Ln();
    $this->Ln();
    $this->SetFillColor(2,157,116);
    $this->SetTextColor(240, 255, 240);
    $this->Cell(30,15,"NOMBRE",1, 0, 'C', true);
    $this->Cell(80,15,"DIRECCION",1, 0, 'C', true);
    $this->Cell(80,15,"DETALLE",1, 0, 'C', true);
    $this->Cell(50,15,"CREADO",1, 0, 'C', true);
    $this->Cell(50,15,"MODIFICADO",1, 0, 'C', true);
    $this->Cell(30,15,"USUARIO",1, 0, 'C', true);
    $this->Ln();
}

// Pie de página
function Footer()
{
    $id = $_GET["idUsuario"];
    $cp = new ControladorPersistencia();
    $consultaUsuarios=$cp->ejecutarSentencia(DBSentencias::BUSCAR_USUARIO_ID,array($id));
    $usuarios = $consultaUsuarios->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuarioF) {
        
        $usuario=$usuarioF['usuario_usuario'];
    }
    
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Practica Profesional Guirao Lazarte Bilyk--Pagina '.$this->PageNo().'/{nb} Usuario: '.$usuario,0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('A','A3');
$cp = new ControladorPersistencia();
    $listadoArt = $cp->ejecutarSentencia(DBSentencias::BUSCAR_ARTS);
    $alterna = true;
    foreach ($listadoArt as $otro) {
        if ($alterna) {
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(30,10, utf8_decode($otro['nombre_art']),1, 0, 'L', true);
            $pdf->Cell(80,10, utf8_decode($otro['direccion_art']),1, 0, 'L', true);
            $pdf->Cell(80,10, utf8_decode($otro['detalle_art']),1, 0, 'L', true);
            $pdf->Cell(50,10, utf8_decode($otro['fch_creacion']),1, 0, 'L', true);
            $pdf->Cell(50,10, utf8_decode($otro['fch_modificacion']),1, 0, 'L', true);
            $pdf->Cell(30,10, utf8_decode($otro['nombre_usuario']),1, 0, 'L', true);
            $pdf->Ln();
            $alterna = !$alterna;
        }else{
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetTextColor(3, 3, 3);
            $pdf->Cell(30,10, utf8_decode($otro['nombre_art']),1, 0, 'L', FALSE);
            $pdf->Cell(80,10, utf8_decode($otro['direccion_art']),1, 0, 'L', FALSE);
            $pdf->Cell(80,10, utf8_decode($otro['detalle_art']),1, 0, 'L', FALSE);
            $pdf->Cell(50,10, utf8_decode($otro['fch_creacion']),1, 0, 'L', FALSE);
            $pdf->Cell(50,10, utf8_decode($otro['fch_modificacion']),1, 0, 'L', FALSE);
            $pdf->Cell(30,10, utf8_decode($otro['usuario_usuario']),1, 0, 'L', FALSE);
            $pdf->Ln();
            $alterna = !$alterna;
        }
        
    }

$pdf->Output();
?>