<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Voluntario</title>
</head>
<body>
    <?php
    //===================================================
    
                        /*despues de haber validad todo el documento y que se haya cumplido todo comienza esta seccion */
    //====================================================
        if(isset($_POST['enviar_V'])){

            session_start();     
            $Usuario=$_SESSION['usuario'];
            
            //echo $Usuario;        
            include("../../conexion_BD.php");
            $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $ID_Usuario=$row['ID_Usuario'];
    }
    
    $sql = "SELECT MAX(ID_Voluntario) AS max_id FROM tbl_voluntarios";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $ultimo_id = $row['max_id'];
    $nuevo_id = $ultimo_id + 1;

            $Nombre_Voluntario=$_POST["Nombre_Voluntario"];
            $Telefono_Voluntario=$_POST["Telefono_Voluntario"];
            $Direccion_Voluntario=$_POST["Direccion_Voluntario"];
            $Fecha_actual = date('Y-m-d');
            include("../../conexion_BD.php");
            // Los dcatos NO ingresaron a la BD

            
            $sql = "INSERT INTO tbl_voluntarios (ID_Voluntario, Nombre_Voluntario, Telefono_Voluntario, Direccion_Voluntario, Creado_Por, Fecha_Creacion) 
            VALUES ($nuevo_id, '$Nombre_Voluntario', '$Telefono_Voluntario', '$Direccion_Voluntario', '$Usuario','$Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('VoluntariosAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['nombreVolBitacora']=$Nombre_Voluntario;
                            $model->RegInsertvol();  

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Error!!!, Los datos no fueron ingresados a la BD');
                    location.assign('VoluntariosAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>
