<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGREGAR</title>
</head>
<body>
    <?php
    //===================================================
    
                        /*despues de haber validad todo el documento y que se haya cumplido todo comienza esta seccion */
    //====================================================
        if(isset($_POST['enviar_F'])){
            $nombre_T_Fondo=$_POST["nombre_T_Fondo"];
            include("../../conexion_BD.php");

            $sql = "SELECT MAX(ID_tipo_fondo) AS max_id FROM tbl_tipos_de_fondos";
            $resultado = mysqli_query($conexion, $sql);
            $row = mysqli_fetch_assoc($resultado);
            $ultimo_id = $row['max_id'];
            $nuevo_id = $ultimo_id + 1;
            
                        $query = "SELECT * FROM tbl_tipos_de_fondos WHERE nombre_T_Fondo='$nombre_T_Fondo'";
        $verificacion = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($verificacion) > 0) {
            // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
            echo "<script language='JavaScript'>
                    alert('Error!!!, El tipo de Fondo ya existe');
                    location.assign('Tipo_Fondo_Adm.php');
                  </script>";
            exit; // Finaliza la ejecución del script si hay errores
        }

            $sql = "INSERT INTO tbl_tipos_de_fondos (ID_tipo_fondo, nombre_T_Fondo) 
            VALUES ($nuevo_id,'$nombre_T_Fondo')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('Tipo_Fondo_Adm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['nombreTFondoBitacora']=$nombre_T_Fondo;
                            $model->RegInsertTFondo();

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('Tipo_Fondo_Adm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>