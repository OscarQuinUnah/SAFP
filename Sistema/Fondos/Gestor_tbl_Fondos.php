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
$columns = ['ID_de_Fondo', 'nombre_T_Fondo', 'Nombre_del_Objeto', 'Cantidad_Rec', 'Valor_monetario','Nombre_del_proyecto','Nombre_D','Fecha_de_adquisicion_F'];

/* Nombre de la tabla */
$table = "tbl_fondos";

$id = 'ID_de_Fondo';
 
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

$sql = "SELECT f.ID_de_fondo, tf.nombre_T_Fondo, f.Nombre_del_Objeto, f.Cantidad_Rec, f.Valor_monetario, p.Nombre_del_proyecto, d.Nombre_D, f.Fecha_de_adquisicion_F
FROM tbl_fondos f 
JOIN tbl_tipos_de_fondos tf ON f.ID_Tipo_Fondo = tf.ID_Tipo_Fondo
JOIN tbl_donantes d ON f.ID_Donante = d.ID_Donante
JOIN tbl_proyectos p ON f.ID_Proyecto = p.ID_proyecto
WHERE (f.ID_de_fondo LIKE '%{$campo}%' OR tf.nombre_T_Fondo LIKE '%{$campo}%' OR f.Nombre_del_Objeto LIKE '%{$campo}%' OR f.Cantidad_Rec LIKE '%{$campo}%' OR f.Valor_monetario LIKE '%{$campo}%' OR d.Nombre_D LIKE '%{$campo}%' OR f.Fecha_de_adquisicion_F LIKE '%{$campo}%')
AND p.Nombre_del_proyecto = '$Nombre_del_proyecto' AND f.Fecha_de_adquisicion_F BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'
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
        $output['data'] .= '<td>' . $row['ID_de_fondo'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre_T_Fondo'] . '</td>';
        $output['data'] .= '<td>' . $row['Nombre_del_Objeto'] . '</td>';
        $output['data'] .= '<td>' . $row['Cantidad_Rec'] . '</td>'; 
        $output['data'] .= '<td>L.' . number_format($row['Valor_monetario'], 2) . '</td>';
        $output['data'] .= '<td>' . $row['Nombre_del_proyecto'] . '</td>';
        $output['data'] .= '<td>' . $row['Nombre_D'] . '</td>';
        $output['data'] .= '<td>' . $row['Fecha_de_adquisicion_F'] . '</td>';
         $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=7");
if ($datos=$sql->fetch_object()) {
        $output['data'] .= '<td><a class="boton-editar" href="Update_Fondo.php?ID_de_fondo=' . $row['ID_de_fondo'] . '"><i class="zmdi zmdi-edit"></i></a></td>';
}
$sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=7");
if ($datos=$sql->fetch_object()) { 
        $output['data'] .= '<td><a onclick="return confirmar()" class="boton-eliminar" href="Delete_Fondo.php?ID_de_fondo=' . $row['ID_de_fondo'] . '"><i class="zmdi zmdi-delete"></i></a></td>';
}
$output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
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
