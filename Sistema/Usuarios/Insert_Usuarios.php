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


                $sql1=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE ID_Parametro=7");
                
                    while($row=mysqli_fetch_array($sql1)){
                    $diasV=$row['Valor'];
                    }
                $R_F_Vencida= date("Y-m-j",strtotime($R_Fecha_actual."+ ".$diasV." days")); /*le suma 1 mes a la fecha actual*/
                //fin parte 2
    //====================================================
        if(isset($_POST['enviar'])){
            $nombreUsuario = strtoupper($_POST['Usuario']);
            $nombreCompleto = $_POST['Nombre_Usuario'];
            $contraseña = $_POST['contraseña'];
            $Rol = $_POST['Rol'];
            //$verifContra = $_POST[''];
            $email = $_POST['Correo_electronico'];
            $vencimiento = $_POST['FechaVencimiento'];

            include("../../conexion_BD.php");

$sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro` in (9,10)");
// Verificar si la consulta devolvió resultados
if (mysqli_num_rows($sql2) >= 1) {
    // Recorrer los resultados y mostrarlos en pantalla
    while($row = mysqli_fetch_array($sql2)) {
      if ($row['ID_Parametro'] == 9) {
        $Min_Pass=$row['Valor'];
    } 

        if ($row['ID_Parametro'] == 10) {
            $Max_Pass=$row['Valor'];
        }     
    }
}

                if (strlen($contraseña) < $Min_Pass || !preg_match('/[a-z]/', $contraseña) || !preg_match('/[A-Z]/', $contraseña) || !preg_match('/[0-9]/', $contraseña) ) {
                    echo'<script>alert("Contraseña poco segura. Debe contener al menos ' .$Min_Pass. ' caracteres , 1 numero, 1 Mayuscula y 1 minuscula")</script>';
                    header("refresh:0;url=usuariosAdm.php");
                    //echo '<div class="alert_danger">Contraseña poco segura. Debe contener al menos 8 caracteres , 1 numero, 1 Mayuscula y 1 minuscula</div>';


                }else{

                

            try {
                $sql = "INSERT INTO tbl_ms_usuario ( ID_Rol, Nombre_Usuario, Usuario, Contraseña, Correo_electronico, Fecha_Vencimiento, Estado_Usuario, Creado_Por, Fecha_Creacion ) VALUES ($Rol,'$nombreCompleto', '$nombreUsuario','$contraseña','$email', '$R_F_Vencida', 'NUEVO', '$usuario','$R_Fecha_actual'  )";

                $resultado = mysqli_query($conexion,$sql);
    
                if($resultado){
                    //Los datos ingresados a la BD
                    echo "<script languaje='JavaScript'>
                            alert('Los datos fueron ingresados correctamente a la BD');
                                location.assign('usuariosAdm.php');
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
                        location.assign('usuariosAdm.php');
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
                    location.assign('usuariosAdm.php');
                </script>";
            }    

            mysqli_close($conexion);
            }
        }
    ?>
</body>
</html>