<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/


require '../../conexion_BD.php';
session_start();
/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['ID_Bitacora', 'Fecha', 'ID_Usuario ', 'ID_Objeto ', 'Accion', 'Descripcion'];

/* Nombre de la tabla */
$table = "tbl_ms_bitacora";

$id = 'ID_Bitacora';
 
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

$sql = "SELECT SQL_CALC_FOUND_ROWS b.ID_Bitacora,b.Fecha, u.Usuario, o.Objeto, b.Accion, b.Descripcion 
FROM tbl_ms_bitacora b
JOIN tbl_objetos o ON b.ID_Objeto = o.ID_Objeto
JOIN tbl_ms_usuario u ON b.ID_Usuario = u.ID_Usuario
WHERE (b.ID_Bitacora LIKE '%{$campo}%' OR u.Usuario LIKE '%{$campo}%' OR o.Objeto LIKE '%{$campo}%' OR b.Accion LIKE '%{$campo}%' OR b.Descripcion LIKE '%{$campo}%')
AND b.Fecha BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'
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
        $output['data'] .= '<td>' . $row['ID_Bitacora'] . '</td>';
        $output['data'] .= '<td>' . $row['Fecha'] . '</td>';
        $output['data'] .= '<td>' . $row['Usuario'] . '</td>';
        $output['data'] .= '<td>' . $row['Objeto'] . '</td>';
        $output['data'] .= '<td>' . $row['Accion'] . '</td>';
        $output['data'] .= '<td>' . $row['Descripcion'] . '</td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
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
