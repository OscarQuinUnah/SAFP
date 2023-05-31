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
            $ID_Proyecto=$_SESSION['ID_Proyect'];       
    include("../../conexion_BD.php");
    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $ID_Usuario=$row['ID_Usuario'];
    }
    
            $ID_Tipo_Fondo=$_POST["tipos_de_fondos"];
            $Nombre_del_Objeto=$_POST["Nombre_del_Objeto"];;
            $Cantidad_Rec=$_POST["Cantidad_Rec"];;
            $Valor_monetario=$_POST["Valor_monetario"];;
            $Fecha_Adquisicion=$_POST["FechaAdquisicion"];
            $ID_Donador=$_POST["Donante"];
            
            $Fecha_actual = date('Y-m-d');
            include("../../conexion_BD.php");
            $sql = "INSERT INTO tbl_fondos (ID_de_Fondo, ID_Tipo_Fondo,Nombre_del_Objeto,Cantidad_Rec,Valor_monetario,Fecha_de_adquisicion_F, ID_Proyecto, ID_Donante , ID_usuario, Creado_Por, Fecha_Creacion, Modificado_por, Fecha_Modificacion) 
            VALUES (NULL,$ID_Tipo_Fondo, '$Nombre_del_Objeto',$Cantidad_Rec,$Valor_monetario, '$Fecha_Adquisicion',$ID_Proyecto,$ID_Donador, $ID_Usuario, '$Usuario','$Fecha_actual','$Usuario','$Fecha_actual')";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('FondosAdm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['nFondoBitacora']=$Nombre_del_Objeto;
                            $model->RegaInsertFondo();  


            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('FondosAdm.php');
                    </script>";
            }
            mysqli_close($conexion);
            }
        
    ?>
</body>
</html>