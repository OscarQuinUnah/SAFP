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


            session_start();     
            $Usuario=$_SESSION['usuario'];
            $IDProyecto=$_SESSION['ID_Proyect'];
            
            echo $Usuario;        
    include("../../conexion_BD.php");
    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $Usuario=$row['ID_Usuario'];
    }
            $Monto=$_POST["Monto_pagado"];
            $T_Monto=$_POST["Pago"];
            $ID_Usuario=$_POST["Usuario"];
            $Fecha_de_transaccion=$_POST["FechaTransaccion"];
            $Fecha_actual = date('Y-m-d');
            include("../../conexion_BD.php");
            $sql = "INSERT INTO `tbl_pagos_realizados`(`Monto_pagado`, `ID_T_pago`, `Fecha_de_transaccion`, `ID_de_proyecto`, `ID_Usuario`, `Creado_Por`, `Fecha_Creacion`, `Modificado_por`, `Fecha_Modificacion`)
            VALUES ($Monto, $T_Monto, '$Fecha_de_transaccion', '$IDProyecto', '$Usuario','$Usuario','$Fecha_actual','$Usuario','$Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('PagosAdm.php');
                            </script>";   
                           require_once "../../EVENT_BITACORA.php";
                           $model = new EVENT_BITACORA;
                           session_start();
                           $_SESSION['IDpagoBitacora']=$Monto;
                           $model->RegInsertPago();  

            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('PagosAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>
