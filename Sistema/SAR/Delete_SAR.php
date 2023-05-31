<?php
include("../../conexion_BD.php");
    $id_sar = $_GET['ID_SAR'];

    //$sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Nombre_Usuario'");

    // while($row=mysqli_fetch_array($sql1)){
    //    $IDusuarioDel=$row['ID_Usuario'];
    // }


    try {

        //DELETE FROM tbl_r_sar WHERE Usuario = $id_sar
    $sql = "DELETE FROM tbl_r_sar WHERE ID_SAR = $id_sar";
    $resultado = mysqli_query($conexion,$sql);



    if($resultado){
        echo "<script languaje='JavaScript'>
                alert('Los datos se eliminaron correctamente de la Base de Datos');
                location.assign('SAR_Adm.php');
                </script>";     
                require_once "../../EVENT_BITACORA.php";
                $model = new EVENT_BITACORA;
                session_start();
                $_SESSION['IDSarBitacoraDELETE']=$id_sar;
                $model->DeleteSar();
             

                            
    }else{
        if (mysqli_errno($conexion)) {
            echo "<script languaje='JavaScript'>
        alert('No puedes borrar este usuario');
        location.assign('usuariosAdm.php');
        </script>";   
        } else {
            echo "<script languaje='JavaScript'>
        alert('Los datos NO se eliminaron de la BD');
        location.assign('usuariosAdm.php');
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
             alert('Los datos NO se eliminaron de la BD por dependencias: $mensaje');
             location.assign('SAR_Adm.php');
            </script>";

             //printf("Ha ocurrido un error: %s\n", mysqli_error($conexion));

            $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL


            //echo $errorMessage;
            //echo $errorCode;
             exit;
        }
    
?>