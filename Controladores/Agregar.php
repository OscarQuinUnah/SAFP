<?php

require_once("../conexion_BD.php");

if(!empty($_POST['ID']) && !empty($_POST['usuario']) && !empty($_POST['nombusu']) && !empty($_POST['Rol']) && !empty($_POST['correo']) && !empty($_POST['clave']) && !empty($_POST['Fechacrea']) && !empty($_POST['Fechaven']) && !empty($_POST['estado'])){

    $ID = $_POST['ID'];
    $usuario = $_POST['usuario'];
    $nombusu = $_POST['nombusu'];
    $Rol = $_POST['Rol'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $Fechacrea = $_POST['Fechacrea'];
    $Fechaven = $_POST['Fechaven'];
    $estado = $_POST['estado'];

    $consulta = $conexion->prepare("INSERT INTO tbl_ms_usuario(ID_Usuario,Usuario,Nombre_Usuario,ID_Rol,Correo_electronico,Contraseña,Fecha_Creacion,Fecha_Vencimiento,Estado_Usuario) VALUES (:ID,:usuario,:nombusu,:Rol,:correo,:clave,:Fechacrea,:Fechaven,:estado)"); 
    $consulta->bind_Param(":ID",$ID);
    $consulta->bind_Param(":usuario",$usuario);
    $consulta->bind_Param(":nombusu",$nombusu);
    $consulta->bind_Param(":Rol",$Rol);
    $consulta->bind_Param(":correo",$correo);
    $consulta->bind_Param(":clave",$clave);
    $consulta->bind_Param(":Fechacrea",$Fechacrea);
    $consulta->bind_Param(":Fechaven",$Fechaven);
    $consulta->bind_Param(":estado",$estado);

    if($consulta->execute()){
        header("location: usuariosAdm.php?msj=Registro agregado");
    }
    else{
        header("location: usuariosAdm.php?msj=Error al agregar el registro");
    }
}else{
    print("debe completar todos los campos del formulario ");
}       

?>