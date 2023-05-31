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
            $Nombre=$_POST["Nombre"];
            include("../../conexion_BD.php");
            
            $query = "SELECT * FROM tbl_tipo_pago_r WHERE Nombre='$Nombre'";
            $verificacion = mysqli_query($conexion, $query);
            
            if (mysqli_num_rows($verificacion) > 0) {
                // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                echo "<script language='JavaScript'>
                        alert('Error!!!, El tipo de pago ya existe');
                        location.assign('TipoPagosAdm.php');
                      </script>";
                exit; // Finaliza la ejecución del script si hay errores
            }

            $sql = "INSERT INTO tbl_tipo_pago_r (ID_T_pago, Nombre) 
            VALUES (NULL,'$Nombre')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('TipoPagosAdm.php');
                            </script>";    
                            require_once "../../EVENT_BITACORA.php";
                           $model = new EVENT_BITACORA;
                           session_start();
                           $_SESSION['nombtpagoBitacora']=$Nombre;
                           $model->InsertTPago();  
            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('TipoPagosAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>