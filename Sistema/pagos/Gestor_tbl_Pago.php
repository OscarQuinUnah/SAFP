<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/
session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
 $IDProyecto=$_SESSION['ID_Proyect'];
 require '../../conexion_BD.php';
 $sql1=$conexion->query("SELECT * FROM `tbl_proyectos` WHERE ID_proyecto='$IDProyecto'");

 while($row=mysqli_fetch_array($sql1)){
     $Nombre_del_proyecto=$row['Nombre_del_proyecto'];
 }
/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['ID_de_pago ', 'Monto_pagado', 'ID_T_pago', 'Fecha_de_transaccion',  'ID_Usuario', 'Creado_Por', 'Fecha_Creacion', 'Modificado_por', 'Fecha_Modificacion'];

/* Nombre de la tabla */
$table = "tbl_pagos_realizados";

$id = 'ID_de_pago ';
 
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

$sql="SELECT SQL_CALC_FOUND_ROWS s.ID_de_pago, s.Monto_pagado, t.nombre,p.Nombre_del_proyecto,s.Fecha_de_transaccion
FROM tbl_pagos_realizados s
JOIN tbl_tipo_pago_r t ON s.ID_T_pago = t.ID_T_pago
JOIN tbl_proyectos p ON s.ID_de_proyecto = p.ID_proyecto

WHERE (s.ID_de_pago LIKE '%{$campo}%' OR s.Monto_pagado LIKE '%{$campo}%' OR t.nombre LIKE '%{$campo}%' OR s.Fecha_de_transaccion LIKE '%{$campo}%')
AND p.Nombre_del_proyecto = '$Nombre_del_proyecto' AND s.Fecha_de_transaccion BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'
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
        $output['data'] .= '<td>' . $row['ID_de_pago'] . '</td>';
        $output['data'] .= '<td>L.' . number_format($row['Monto_pagado'], 2) . '</td>';
        $output['data'] .= '<td>' . $row['nombre'] . '</td>';
        $output['data'] .= '<td>' . $row['Nombre_del_proyecto'] . '</td>';
        $output['data'] .= '<td>' . $row['Fecha_de_transaccion'] . '</td>';
        $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=10");
if ($datos=$sql->fetch_object()) {  
        $output['data'] .= '<td><a class="boton-editar" href="Update_Pago.php?ID_de_pago=' . $row['ID_de_pago'] . '"><i class="zmdi zmdi-edit"></i></a></td>';
}
$sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=10");
if ($datos=$sql->fetch_object()) { 
        $output['data'] .= "<td><a onclick='return confirmar()' class='boton-eliminar' href='Delete_Pago.php?ID_de_pago=" . $row['ID_de_pago'] . "'><i class='zmdi zmdi-delete'></i></a></td>";
}
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
