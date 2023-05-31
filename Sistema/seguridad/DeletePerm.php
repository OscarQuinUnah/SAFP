<?php
include("../../conexion_BD.php");
    $ID_Per = $_GET['ID_permiso'];
    session_start();  
    $IDRolPer=$_SESSION['ID_RolPer'];

    // $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Nombre_Usuario'");

    //              while($row=mysqli_fetch_array($sql1)){
    //                 $IDusuarioDel=$row['ID_Usuario'];
    //              }


    try {

        //DELETE FROM tbl_ms_usuario WHERE Usuario = $id
    $sql = "DELETE FROM tbl_permisos WHERE ID_permiso = '$ID_Per'";
    $resultado = mysqli_query($conexion,$sql);



    if($resultado){
        echo "<script languaje='JavaScript'>
                alert('Los datos se eliminaron correctamente de la Base de Datos');
                location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
                </script>";  
                require_once "../../EVENT_BITACORA.php";
                $model = new EVENT_BITACORA;
                session_start();
                $_SESSION['IDPerDELETE']=$ID_Per;
                $_SESSION['IDRolDELETE']=$ID_Rol;
                $model->DeleteRol();   

                            
    }else{
        if (mysqli_errno($conexion)) {
            echo "<script languaje='JavaScript'>
        alert('No puedes borrar este usuario');
        location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
        </script>";   
        } else {
            echo "<script languaje='JavaScript'>
        alert('Los datos NO se eliminaron de la BD');
        location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
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
              alert('$mensaje Por referencia con la tabla roles');
               location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
             </script>";

             //printf("Ha ocurrido un error: %s\n", mysqli_error($conexion));

            $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL
            //echo $errorMessage;

            //echo $errorMessage;
            //echo $errorCode;
             exit;
        }
    
?>