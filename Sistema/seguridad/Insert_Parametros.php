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
        if(isset($_POST['Enviar_Parametros'])){

            session_start();     
            $Usuario=$_SESSION['usuario'];
            //echo $Usuario;        
            include("../../conexion_BD.php");
            $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

            while($row=mysqli_fetch_array($sql1)){
                $ID_Usuario=$row['ID_Usuario'];
            }
    
            $Nombre_Parametro=$_POST["Nombre_Parametro"];
            $Descrip_Parametro=$_POST["Descrip_Parametro"];
            $Valor_Parametro=$_POST["Valor_Parametro"];
            $Fecha_actual = date('Y-m-d');

            include("../../conexion_BD.php");
            
            $query = "SELECT * FROM tbl_ms_parametros WHERE Parametro='$Nombre_Parametro'";
            $verificacion = mysqli_query($conexion, $query);
            
            if (mysqli_num_rows($verificacion) > 0) {
                // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                echo "<script language='JavaScript'>
                        alert('Error!!!, El Parametro ya existe');
                        location.assign('ParametrosAdm.php');
                      </script>";
                exit; // Finaliza la ejecución del script si hay errores
            }       
            
            $sql = "INSERT INTO tbl_ms_parametros (Parametro, Descripcion_P, Valor, ID_Usuario, Fecha_Creacion) 
            VALUES ('$Nombre_Parametro', '$Descrip_Parametro', '$Valor_Parametro' , '$ID_Usuario','$Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('ParametrosAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['parabit']=$Nombre_Parametro;
                            $model->RegInsertpara(); 

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Erro!!, Los datos no fueron ingresados a la BD');
                    location.assign('ParametrosAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>
