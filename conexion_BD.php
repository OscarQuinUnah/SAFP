<?php
try{
$conexion = new mysqli("localhost", "root", "", "bd_asociacion_creo_en_ti", "3306");
$conexion->set_charset("utf8");
/*aqui se da la conexion con la base de datos, es necesario que la base de datos posea este usuario para conectarse*/ 
}catch(Exception $e){
    $errorCode = $e->getCode(); // Almacenar el código de error SQL\
    $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL

    echo $errorCode;
    echo "<br>";
    echo $errorMessage;
    echo "<script languaje='JavaScript'>
    alert('Parametros mal colocados para establecer la conexion a la BD');
   </script>";
   exit;
}
?>

