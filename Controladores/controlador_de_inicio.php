<?php
require '../conexion_BD.php';
session_start();
if (empty($_SESSION['user']) and empty($_SESSION['ID_User'])) {
    header('location:../Pantallas/Login.php');
}else{
        header('location:../Sistema/Home/home.php');
}

/*esta variable impide que se pueda entrar al sistema principal si no se entra por login (crea un usuario global) */
?>