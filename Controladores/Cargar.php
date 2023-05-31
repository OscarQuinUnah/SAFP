<?php
require '../conexion_BD.php';

$colums = [ 'ID_Usuario','ID_Rol', 'Nombre_Usuario', 'Contraseña', 'Fecha_Ultima_conexion', 'Estado_Usuario'];
$table = "tbl_ms_usuario";

//
$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

$sql = "SELECT " . implode(", ", $colums) . "
FROM $table";
$resultado = $conn->query($sql);
$num_row = $resultado->num_rows;

$html = '';

if ($num_row > 0){
    while ($row = $resultado->fetch_assoc()){
        $html .= '<tr>';
        $html .= '<td>'.$row['ID_Usuario'].'</td>';
        $html .= '<td>'.$row['ID_Rol'].'</td>';
        $html .= '<td>'.$row['Nombre_Usuario'].'</td>';
        $html .= '<td>'.$row['Contrasena'].'</td>';
        $html .= '<td>'.$row['Fecha_Última_conexión'].'</td>';
        $html .= '<td>'.$row['Estado_Usuario'].'</td>';
        $html .= '<td><a hreft="">Editar</a></td>';
        $html .= '<td><a hreft="">Eliminar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultado</td>';
    $html .= '</tr>';
}
echo json_encode($html, JSON_UNESCAPED_UNICODE);


