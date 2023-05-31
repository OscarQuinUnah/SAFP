<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/
session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];

require '../../conexion_BD.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['ID_SAR','RTN', 'num_declaracion', 'tipo_declaracion','nombre_razonSocial', 'Monto','departamento','municipio', 'barrio_colonia', 'calle_avenida', 'num_casa', 'bloque', 'telefono', 'celular', 'domicilio', 'correo', 'profesion_oficio', 'cai', 'fecha_limite_emision', 'num_inicial', 'num_final'];

/* Nombre de la tabla */
$table = "tbl_r_sar";

$id = 'ID_SAR';
 
$campo = isset($_POST['campo']) ? $conexion->real_escape_string($_POST['campo']) : null;
$fechaInicio = isset($_POST['fechaInicio']) ? $conexion->real_escape_string($_POST['fechaInicio']) : null;
$fechaFinal = isset($_POST['fechaFinal']) ? $conexion->real_escape_string($_POST['fechaFinal']) : null;

/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}
if ($fechaInicio != null && $fechaFinal != null) {
    $where .= ($where == '') ? 'WHERE ' : ' AND ';
    $where .= "b.Fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "'";
}elseif($fechaInicio == null || $fechaFinal == null) {
    $fechaInicio = '2023-01-01';
    $fechaFinal = date('Y-m-d', strtotime('+1 day'));;
    $where .= ($where == '') ? 'WHERE ' : ' AND ';
    $where .= "b.Fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "'";
}
$_SESSION['fechaInicio']=$fechaInicio;
$_SESSION['$fechaFinal']=$fechaFinal;
/* Limit */
$limit = isset($_POST['registros']) ? $conexion->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conexion->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";

/**
 * Ordenamiento
 */

 $sOrder = "";
 if(isset($_POST['orderCol'])){
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
    
    $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType;
 }


/* Consulta */

$sql="SELECT SQL_CALC_FOUND_ROWS * from tbl_r_sar
WHERE (ID_SAR LIKE '%{$campo}%' OR RTN LIKE '%{$campo}%' OR num_declaracion LIKE '%{$campo}%' OR tipo_declaracion LIKE '%{$campo}%' OR nombre_razonSocial LIKE '%{$campo}%' OR Monto LIKE '%{$campo}%' OR departamento LIKE '%{$campo}%' OR municipio LIKE '%{$campo}%'
        OR barrio_colonia LIKE '%{$campo}%' OR calle_avenida LIKE '%{$campo}%' OR num_casa LIKE '%{$campo}%' OR bloque LIKE '%{$campo}%' OR telefono LIKE '%{$campo}%' OR celular LIKE '%{$campo}%'
        OR domicilio LIKE '%{$campo}%'OR correo LIKE '%{$campo}%' OR profesion_oficio LIKE '%{$campo}%' OR cai LIKE '%{$campo}%' OR fecha_limite_emision LIKE '%{$campo}%' OR num_inicial LIKE '%{$campo}%'
        OR num_final LIKE '%{$campo}%') AND fecha_limite_emision BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'
ORDER BY {$columns[$orderCol]} {$oderType}
LIMIT {$inicio}, {$limit}";
$resultado = $conexion->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conexion->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table ";
$resTotal = $conexion->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];

/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . $row['ID_SAR'] . '</td>';
        $output['data'] .= '<td>' . $row['RTN'] . '</td>';
        $output['data'] .= '<td>' . $row['num_declaracion'] . '</td>';
        $output['data'] .= '<td>' . $row['tipo_declaracion'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre_razonSocial'] . '</td>';
        $output['data'] .= '<td>L. ' . number_format($row['Monto'], 2) .'</td>';
        $output['data'] .= '<td>' . $row['departamento'] . '</td>';
        $output['data'] .= '<td>' . $row['municipio'] . '</td>';
        $output['data'] .= '<td>' . $row['barrio_colonia'] . '</td>';
        $output['data'] .= '<td>' . $row['calle_avenida'] . '</td>';
        $output['data'] .= '<td>' . $row['num_casa'] . '</td>';
        // $output['data'] .= '<td>' . $row['bloque'] . '</td>';
         if (is_null($row['bloque'])) {
             $output['data'] .= '<td>N/A</td>';
         } else {
             $output['data'] .= '<td>' . $row['bloque'] . '</td>';
         }
        $output['data'] .= '<td>' . $row['telefono'] . '</td>';
        $output['data'] .= '<td>' . $row['celular'] . '</td>';
        $output['data'] .= '<td>' . $row['domicilio'] . '</td>';
        $output['data'] .= '<td>' . $row['correo'] . '</td>';
        $output['data'] .= '<td>' . $row['profesion_oficio'] . '</td>';
        $output['data'] .= '<td>' . $row['cai'] . '</td>';
        $output['data'] .= '<td>' . $row['fecha_limite_emision'] . '</td>';
        $output['data'] .= '<td>' . $row['num_inicial'] . '</td>';
        $output['data'] .= '<td>' . $row['num_final'] . '</td>';
         $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) {
        $output['data'] .= '<td><a class="boton-editar" href="Update_SAR.php?ID_SAR=' . $row['ID_SAR'] . '"><i class="zmdi zmdi-edit"></i></a></td>';
}
$sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) { 
        $output['data'] .= '<td><a onclick="return confirmar()" class="boton-eliminar" href="Delete_SAR.php?ID_SAR=' . $row['ID_SAR'] . '"><i class="zmdi zmdi-delete"></i></a></td>';
}
$output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="19">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if($output['totalFiltro'] > 0){
    $totalFiltro = ceil($output['totalFiltro'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if(($pagina - 4) > 1){
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if($numeroFin > $totalFiltro){
        $numeroFin = $totalFiltro;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}elseif ($output['totalFiltro'] < 1){
    $pagina="";
    $output['paginacion'] = "";
}elseif ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if(($pagina - 4) > 1){
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if($numeroFin > $totalPaginas){
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
