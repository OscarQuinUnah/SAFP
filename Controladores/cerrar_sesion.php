<?php
 require_once "../EVENT_BITACORA.php";
 $model = new EVENT_BITACORA;
    session_start(); // Iniciar la sesión
    $model->Cerrarlogin(); 
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión
?>