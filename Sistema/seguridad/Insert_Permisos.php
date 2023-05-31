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
    $IDRolPer=$_SESSION['ID_RolPer'];
    //====================================================
        if(isset($_POST['enviar'])){
            $ID_RolPer = $_POST['idRol'];
            $idObj = $_POST['Objeto'];
            $perInser = isset($_POST['inser']) ? 1 : 0;
            $perDel = isset($_POST['eli']) ? 1 : 0;
            $perUp = isset($_POST['actu']) ? 1 : 0;
            $perSel = isset($_POST['cons']) ? 1 : 0;
            $est = isset($_POST['est']) ? 1 : 0;


            include("../../conexion_BD.php");

                
            try {
                $sql = "INSERT INTO tbl_permisos (ID_Rol, ID_Objeto, Permiso_Insercion, Permiso_Eliminacion, Permiso_Actualizacion, Permiso_consultar, Estad) VALUES ($ID_RolPer, $idObj,'$perInser', '$perDel','$perUp',' $perSel',' $est')";

                $resultado = mysqli_query($conexion,$sql);
    
                if($resultado){
                    //Los datos ingresados a la BD
                    echo "<script language='JavaScript'>
                    alert('La insercion de la pantalla se agregó correctamente');
                    location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "');
                  </script>";
              
                                require_once "../../EVENT_BITACORA.php";
                                $model = new EVENT_BITACORA;
                                session_start();
                                $_SESSION['UsuarioBitacora']=$nombreUsuario;
                                $_SESSION['IDUsuarioBitacora']=$ID_Usuario;
                                $model->RegInsert();
    
                }else{
                    // Los dcatos NO ingresaron a la BD
                    echo "<script languaje='JavaScript'>
                    alert('Los datos NO fueron ingresados a la BD');
                    location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
                        </script>";
                }      
            } catch (Exception $e) {
                $errorCode = $e->getCode(); // Almacenar el código de error SQL\   
                $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL

                //echo $errorMessage;
                //echo $errorCode;

                $sql2 = "SELECT mensaje FROM tbl_errores WHERE codigo = $errorCode";
                $resultado=mysqli_query($conexion,$sql2);

                $row = mysqli_fetch_assoc($resultado);
                $mensaje = $row['mensaje'];
                //echo $mensaje;

                echo "<script languaje='JavaScript'>
                    alert('Excepción capturada: $mensaje');
                    location.assign('PermisosUl.php?ID_Rol=" . $IDRolPer . "')
                </script>";
              

            mysqli_close($conexion);
            }
        }
    ?>
</body>
</html>