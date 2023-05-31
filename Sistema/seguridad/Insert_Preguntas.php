<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pregunta</title>
</head>
<body>
    <?php
    //===================================================
    
                        /*despues de haber validad todo el documento y que se haya cumplido todo comienza esta seccion */
    //====================================================
        if(isset($_POST['enviar_Pregunta'])){


            session_start();     
            $Usuario=$_SESSION['usuario'];
            //echo $Usuario;        
            include("../../conexion_BD.php");
            $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

            while($row=mysqli_fetch_array($sql1)){
                $ID_Usuario=$row['ID_Usuario'];
            }
    
            
            $pregunta=$_POST["Pregunta"];
            $Fecha_actual = date('Y-m-d');
            include("../../conexion_BD.php");
            // Los dcatos NO ingresaron a la BD
            $query = "SELECT * FROM tbl_preguntas WHERE Pregunta='$pregunta'";
        $verificacion = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($verificacion) > 0) {
            // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
            echo "<script language='JavaScript'>
                    alert('Error!!!, La pregunta ya existe');
                    location.assign('PreguntasAdm.php');
                  </script>";
            exit; // Finaliza la ejecución del script si hay errores
        }
            $Pregunta = mysqli_real_escape_string($conexion, $pregunta);
            
            $sql = "INSERT INTO tbl_preguntas (Pregunta, Creado_Por, Fecha_Creacion) 
            VALUES ('$Pregunta', '$Usuario','$Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('PreguntasAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['pregbit']=$pregunta;
                            $model->RegInsertpreg(); 


            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Error!!!, Los datos no fueron ingresados a la BD');
                    location.assign('PreguntasAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>