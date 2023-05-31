<?php



require('./fpdf.php');
require '../conexion_BD.php';
require_once "../EVENT_BITACORA.php";
$model = new EVENT_BITACORA;
session_start();
$model->reportpago();
$IDProyecto=$_SESSION['ID_Proyect'];
$sql1=$conexion->query("SELECT * FROM `tbl_proyectos` WHERE ID_proyecto='$IDProyecto'");

while($row=mysqli_fetch_array($sql1)){
    $Nombre_del_proyecto=$row['Nombre_del_proyecto'];
}

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
      $this->Cell(100, 10, utf8_decode("REPORTE DE PAGOS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(000, 000, 000); //colorTexto
      $this->SetDrawColor(255, 255, 255); //colorBorde 163 163 163
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(40, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Monto pagado'), 1, 0, 'C', 1);
      $this->Cell(120, 10, utf8_decode('Tipo pago'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Proyecto'), 1, 0, 'C', 1);
      $this->Cell(50, 10, utf8_decode('Fecha de Transaccion'), 1, 1, 'C', 1);
    //   $this->Cell(50, 10, utf8_decode('DEPARTAMENTO'), 1, 0, 'C', 1);
    //   $this->Cell(50, 10, utf8_decode('MUNICIPIO'), 1, 1, 'C', 1);
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
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$campo = $_GET["campo"];
$fechaInicio = $_SESSION['fechaInicio'];
$fechaFinal = $_SESSION['$fechaFinal'];

$consulta_reporte_alquiler = $conexion->query("SELECT s.ID_de_pago, s.Monto_pagado, t.nombre,p.Nombre_del_proyecto, u.Nombre_Usuario,s.Fecha_de_transaccion
FROM tbl_pagos_realizados s
JOIN tbl_tipo_pago_r t ON s.ID_T_pago = t.ID_T_pago
JOIN tbl_proyectos p ON s.ID_de_proyecto = p.ID_proyecto
JOIN tbl_ms_usuario u ON s.ID_usuario = u.ID_Usuario
WHERE (s.ID_de_pago LIKE '%{$campo}%' OR s.Monto_pagado LIKE '%{$campo}%' OR t.nombre LIKE '%{$campo}%' OR u.Nombre_Usuario LIKE '%{$campo}%' OR s.Fecha_de_transaccion LIKE '%{$campo}%')
AND p.Nombre_del_proyecto = '$Nombre_del_proyecto' AND s.Fecha_de_transaccion BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'");

while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {   
      $i = $i + 1;
      /* TABLA */
      $pdf->Cell(40, 10, utf8_decode($i), 0, 0, 'C', 0);
      $pdf->Cell(30, 10, 'L' . number_format($datos_reporte->Monto_pagado, 2), 0, 0, 'C', 0);
      $pdf->Cell(120, 10, utf8_decode($datos_reporte -> nombre), 0, 0, 'C', 0);
      $pdf->Cell(20, 10, utf8_decode($datos_reporte -> Nombre_del_proyecto), 0, 0, 'C', 0);
      $pdf->Cell(50, 10, utf8_decode($datos_reporte -> Fecha_de_transaccion), 0, 1, 'C', 0);
    //   $pdf->Cell(50, 10, utf8_decode($datos_reporte -> departamento), 0, 0, 'C', 0);
    //   $pdf->Cell(50, 10, utf8_decode($datos_reporte -> municipio), 0, 1, 'C', 0);
      // $pdf->Cell(100, 10, utf8_decode($datos_reporte -> cai), 1, 0, 'C', 0);   
      // $pdf->Cell(20, 10, utf8_decode($datos_reporte -> estado), 0, 1, 'C', 0);   
   }

$pdf->Output('ReporteDePagos.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
