<?php
include("../../conexion_BD.php");
    $ID_Usuario = $_GET['ID_Usuario'];

    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE ID_Usuario='$ID_Usuario'");

                 while($row=mysqli_fetch_array($sql1)){
                    $Nombre_Usuario=$row['ID_Usuario'];
                 }


    try {

        //DELETE FROM tbl_ms_usuario WHERE Usuario = $id
    $sql = "DELETE FROM tbl_ms_usuario WHERE ID_Usuario = '$ID_Usuario'";
    $resultado = mysqli_query($conexion,$sql);



    if($resultado){
        echo "<script languaje='JavaScript'>
                alert('Los datos se eliminaron correctamente de la Base de Datos');
                location.assign('usuariosAdm.php');
                </script>";     
                require_once "../../EVENT_BITACORA.php";
                $model = new EVENT_BITACORA;
                session_start();
                $_SESSION['UsuarioBitacoraDELETE']=$Nombre_Usuario;
                $_SESSION['IDUsuarioBitacoraDELETE']=$ID_Usuario;
                $model->RegDelete();

                            
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
                  alert('Excepción capturada: $mensaje Con la tabla bitacora');
                  location.assign('usuariosAdm.php');
              </script>";

            //   echo "<script languaje='JavaScript'>
            //   alert('$mensaje') Por referencia a llave foranea con la tabla bitacora;
            //   location.assign('usuariosAdm.php');
            //  </script>";

             //printf("Ha ocurrido un error: %s\n", mysqli_error($conexion));

            $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL


            echo $errorMessage;
            //echo $errorCode;
             exit;
        
    }

    
?>