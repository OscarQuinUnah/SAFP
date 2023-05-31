<?php

require('./fpdf.php');
require_once "../EVENT_BITACORA.php";
$model = new EVENT_BITACORA;
session_start();
$model->reportproj();
class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      include '../conexion_BD.php';//llamamos a la conexion BD

      $consulta_info = $conexion->query(" select Valor from tbl_ms_parametros WHERE ID_Parametro = 12");//traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      $this->Image('asociacion.jpg', 250, 5, 40); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode($dato_info -> Valor), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color


      $consulta_info = $conexion->query(" select Valor from tbl_ms_parametros WHERE ID_Parametro = 14");//traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      /* UBICACION */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : " . $dato_info -> Valor), 0, 0, '', 0);
      $this->Ln(5);


      $consulta_info = $conexion->query(" select Valor from tbl_ms_parametros WHERE ID_Parametro = 13");//traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      /* TELEFONO */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : " . $dato_info -> Valor), 0, 0, '', 0);
      $this->Ln(5);


      $consulta_info = $conexion->query(" select Valor from tbl_ms_parametros WHERE ID_Parametro = 15");//traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      /* CORREO */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : " . $dato_info -> Valor), 0, 0, '', 0);
      $this->Ln(5); //SERIA EL ESPACIADO ENTRE ESTE CAMPO Y EL TITULO DEL REPORTE

       // Obtener la fecha actual
       $fecha_actual = date('d/m/Y h:m:s');
      //  $fecha_actual = date('Y-m-d H:i:s');
      //  $fecha_actual = date('Y-m-d H:i:s');
      $fecha_actual = date('d/m/Y H:i:s');
      

       // Escribir la fecha en el reporte
       $this->Cell(1);  // mover a la derecha
       $this->Cell(85,10,'Fecha: '.$fecha_actual,0,0,'', 0);
       $this->Ln(7); //SERIA EL ESPACIADO ENTRE ESTE CAMPO Y EL TITULO DEL REPORTE

      /* SUCURSAL */
      // $this->Cell(180);  // mover a la derecha
      // $this->SetFont('Arial', 'B', 10);
      // $this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
      // $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 95, 189);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE PROYECTOS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(000, 000, 000); //colorTexto
      $this->SetDrawColor(255, 255, 255); //colorBorde 163 163 163
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(30, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(50, 10, utf8_decode('Proyecto'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('Fecha Inicio'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Fecha final'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Voluntarios'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('fondos proy.'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Fondos act.'), 1, 0, 'C', 1);
      $this->Cell(33, 10, utf8_decode('Pagos'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Estado'), 1, 1, 'C', 1);
      // $this->Cell(50, 10, utf8_decode('CAI'), 1, 0, 'C', 1);
      // $this->Cell(20, 10, utf8_decode('Estado'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y h:m:s');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../conexion_BD.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$campo = $_GET["campo"];
$fechaInicio = $_SESSION['fechaInicio'];
$fechaFinal = $_SESSION['$fechaFinal'];

$consulta_reporte_alquiler = $conexion->query("SELECT * from tbl_proyectos
WHERE (ID_proyecto LIKE '%{$campo}%' OR Nombre_del_proyecto LIKE '%{$campo}%' OR Fecha_de_inicio_P LIKE '%{$campo}%' OR Fecha_final_P LIKE '%{$campo}%' OR Fondos_proyecto LIKE '%{$campo}%' OR Estado_Proyecto LIKE '%{$campo}%')
AND Fecha_de_inicio_P BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'");


while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {
    $ID_Proyect = $datos_reporte->ID_proyecto;
    
    // Consulta para obtener el total de fondos del proyecto
    $consulta_fondos = $conexion->query("SELECT SUM(`Valor_monetario`) as Total FROM tbl_fondos WHERE `ID_Proyecto` = $ID_Proyect");
    $datos_fondos = $consulta_fondos->fetch_object();
    $total_fondos = $datos_fondos->Total;
   
    // Consulta para obtener el total de voluntarios del proyecto
    $consulta_voluntarios = $conexion->query("SELECT COUNT(*) as Total FROM tbl_voluntarios_proyectos WHERE `ID_proyecto` = $ID_Proyect");
    $datos_voluntarios = $consulta_voluntarios->fetch_object();
    $total_voluntarios = $datos_voluntarios->Total;
    
    $consulta_pagos = $conexion->query("SELECT SUM(`Monto_pagado`) as Total FROM tbl_pagos_realizados WHERE `ID_de_proyecto` = $ID_Proyect");
    $datos_pagos = $consulta_pagos->fetch_object();
    $total_pagos = $datos_pagos->Total;
   
    $i = $i + 1;
    /* TABLA */
    $pdf->Cell(30, 10, utf8_decode($i), 0, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode($datos_reporte -> Nombre_del_proyecto), 0, 0, 'C', 0);
    $pdf->Cell(35, 10, utf8_decode($datos_reporte -> Fecha_de_inicio_P), 0, 0, 'C', 0);
    $pdf->Cell(20, 10, utf8_decode($datos_reporte -> Fecha_final_P), 0, 0, 'C', 0);
    $pdf->Cell(25, 10, utf8_decode($total_voluntarios), 0, 0, 'C', 0); // Nueva celda para el total de voluntarios
    $pdf->Cell(30, 10, 'L' . number_format($datos_reporte->Fondos_proyecto, 2), 0, 0, 'C', 0);
    $pdf->Cell(30, 10, 'L' . number_format($total_fondos, 2), 0, 0, 'C', 0); // Nueva celda para el total de fondos
    $pdf->Cell(33, 10, 'L' . number_format($total_pagos, 2), 0, 0, 'C', 0); // Nueva celda para el total de pagos
    $pdf->Cell(20, 10, utf8_decode($datos_reporte -> Estado_Proyecto), 0, 1, 'C', 0);

   }

$pdf->Output('Reporteproyec.pdf', 'I'); //nombreDescarga, Visor(I->visualizar - D->descargar)
