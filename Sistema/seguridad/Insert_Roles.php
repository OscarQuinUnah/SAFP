<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGREGAR</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php
    include("../../conexion_BD.php");
    session_start();     
    $usuario=$_SESSION['user'];
    $ID_Rol=$_SESSION['ID_Rol'];

                
                $R_Fecha_actual = date('Y-m-d');       /*obtiene la fecha actual*/

        if(isset($_POST['enviar'])){
            
            $nombreRol = strtoupper($_POST['Nombre_rol']);
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
                

                $query = "SELECT * FROM tbl_ms_roles WHERE Rol='$nombreRol'";
              $verificacion = mysqli_query($conexion, $query);
              
              if (mysqli_num_rows($verificacion) > 0) {
                  // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                  echo "<script language='JavaScript'>
                          alert('Error!!!, Ese Rol ya existe');
                          location.assign('RolesAdm.php');
                        </script>";
                  exit; // Finaliza la ejecución del script si hay errores
              }
            $sql = "INSERT INTO tbl_ms_roles (Rol, Descripcion, Estado, Creado_Por, Fecha_Creacion ) VALUES ( '$nombreRol', '$descripcion', $estado,  '$usuario', '$R_Fecha_actual' )";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('RolesAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                    session_start();
                    $_SESSION['RolBitacora']=$nombreRol;
                    $model->RegInsertRol();

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('RolesAdm.php');
                    </script>";
                    
            }
            mysqli_close($conexion);
            }
        // }
    ?>
</body>
</html>