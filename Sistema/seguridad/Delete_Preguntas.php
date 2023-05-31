<?php
include("../../conexion_BD.php");
    $ID_Pregunta = $_GET['ID_Pregunta'];
    try {

        //DELETE FROM tbl_ms_usuario WHERE Usuario = $id
    $sql = "DELETE FROM tbl_preguntas where ID_Pregunta = '$ID_Pregunta'";
    $resultado = mysqli_query($conexion,$sql);



    if($resultado){
        echo "<script languaje='JavaScript'>
                alert('Los datos se eliminaron correctamente de la Base de Datos');
                location.assign('PreguntasAdm.php');
                </script>"; 
                require_once "../../EVENT_BITACORA.php";
                $model = new EVENT_BITACORA;
                session_start();
                $_SESSION['IDpregDELETE']=$ID_Pregunta;
                $model->Deletepreg();    
    

    }else{
        if (mysqli_errno($conexion)) {
            echo "<script languaje='JavaScript'>
        alert('No puedes borrar este usuario');
        location.assign('PreguntasAdm.php');
        </script>";   
        } else {
            echo "<script languaje='JavaScript'>
        alert('Los datos NO se eliminaron de la BD');
        location.assign('PreguntasAdm.php');
        </script>"; 
        }
          
    }
    $conexion->close();


        } catch (Exception $e) {
            $mensajeError = $e->getMessage();
            // echo "<script languaje='JavaScript'>
            //     alert('Excepción capturada: $mensajeError');
            //     location.assign('usuariosAdm.php');
            // </script>";

            echo "<script languaje='JavaScript'>
            alert('Los datos NO se eliminaron de la BD por dependencias');
            location.assign('PreguntasAdm.php');
        </script>";
        }
    
?>