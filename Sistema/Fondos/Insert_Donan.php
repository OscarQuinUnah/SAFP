<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Donate</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php
    include("../../conexion_BD.php");

    //===================================================

    //====================================================
        if(isset($_POST['enviar'])){
            session_start();     
            $Usuario=$_SESSION['usuario'];

            // Crear una consulta para obtener el próximo valor AUTO_INCREMENT para la columna id_parametro
            include("../../conexion_BD.php");
            $query = "SHOW TABLE STATUS LIKE 'tbl_donantes';";
            $result = mysqli_query($conexion, $query);
            $row = mysqli_fetch_assoc($result);
            $next_id = $row['Auto_increment'];
            
                                          
            $ID_Donante=$next_id;
            $nombreDonante = $_POST['Nombre_Donante'];
            $telefono = $_POST['Telef'];
            $Direccion = $_POST['Direccion'];
            $email = $_POST['Correo_electronico'];

            $R_Fecha_actual = date('Y-m-d');

            
                
            $sql = "INSERT INTO tbl_donantes (Nombre_D, Tel_cel_D, Direccion_D, Correo_D, Creado_Por, Fecha_Creacion) VALUES ('$nombreDonante', '$telefono', '$Direccion', '$email', '$Usuario', '$R_Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('DonacAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['DonanteBitacora']=$nombreDonante;
                            $_SESSION['IDdonanteBitacora']=$ID_Donante;
                            $model->RegInsertDon();

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Error!!!, Los datos no fueron ingresados a la BD');
                location.assign('DonacAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
        }
    ?>
</body>
</html>