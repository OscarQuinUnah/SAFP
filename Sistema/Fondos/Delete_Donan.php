<?php
include("../../conexion_BD.php");
    $ID_Donante = $_GET['ID_Donante'];
    try {

        //DELETE FROM tbl_ms_usuario WHERE Usuario = $id
    $sql = "DELETE FROM tbl_donantes where ID_Donante = '$ID_Donante'";
    $resultado = mysqli_query($conexion,$sql);



    if($resultado){
        echo "<script languaje='JavaScript'>
                alert('Los datos se eliminaron correctamente de la Base de Datos');
                location.assign('DonacAdm.php');
                </script>";     
                require_once "../../EVENT_BITACORA.php";
                $model = new EVENT_BITACORA;
                 session_start();
                 $_SESSION['IDdonanteBitacoraDELETE']=$ID_Donante;
                 $model-> DeleteDon();

  
        
    }else{
        if (mysqli_errno($conexion)) {
            echo "<script languaje='JavaScript'>
        alert('No puedes borrar este usuario');
        location.assign('DonacAdm.php');
        </script>";   
        } else {
            echo "<script languaje='JavaScript'>
        alert('Los datos NO se eliminaron de la BD');
        location.assign('DonacAdm.php');
        </script>"; 
        }
          
    }
    $conexion->close();


        } catch (Exception $e) {
            //$mensajeError = $e->getMessage();

            $errorCode = $e->getCode(); // Almacenar el código de error SQL\
            $sql2 = "SELECT mensaje FROM tbl_errores WHERE codigo = $errorCode";
            $resultado=mysqli_query($conexion,$sql2);

            $row = mysqli_fetch_assoc($resultado);
            $mensaje = $row['mensaje'];
            //echo $mensaje;

             echo "<script languaje='JavaScript'>
             alert('$mensaje');
             location.assign('DonacAdm.php');
            </script>";

             //printf("Ha ocurrido un error: %s\n", mysqli_error($conexion));

            $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL


            //echo $errorMessage;
            //echo $errorCode;
             exit;
        }
    
?>