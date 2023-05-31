<?php
$Fecha_Actual = date('Y-m-d');  

    $sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro` in(7,9)");
                // Verificar si la consulta devolvió resultados
                if (mysqli_num_rows($sql2) >= 1) {
                    // Recorrer los resultados y mostrarlos en pantalla
                    while($row = mysqli_fetch_array($sql2)) {
                        if ($row['ID_Parametro'] == 7) {
                            $DiasVencimiento_Pass=$row['Valor'];
                        } 

                        if ($row['ID_Parametro'] == 9) {
                            $Min_Pass=$row['Valor'];
                        }     
                    }
                }
                $F_Vencida= date("Y-m-d",strtotime($Fecha_Actual."+ ".$DiasVencimiento_Pass." days"));


if (!empty($_POST["btn_enviar_N_Contra"])){
    
 if (empty($_POST["C_contra_A"]) and empty($_POST["C_contra_N"])and empty($_POST["C_contra_N_2"])) {
        echo '<div class="alert alert-danger">Los campos estan vacios</div>';
 } else {
    $contraseña_A = $_POST["C_contra_A"];
    $contraseña_Nueva = $_POST["C_contra_N"];
    $contraseña_Nueva_2 = $_POST["C_contra_N_2"];
    
    $ID_usuario = $_SESSION['ID_User'];
    $usuario = $_SESSION['user'];   
    $sql=$conexion->query("SELECT * FROM tbl_ms_usuario where ID_Usuario='$ID_usuario' and Contraseña='$contraseña_A'");
    if ($datos=$sql->fetch_object()) {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_\W]).{'.$Min_Pass.',}$/', $contraseña_Nueva)) {
            echo '<div class="alert alert-danger">La contraseña debe tener al menos una letra minúscula, una letra mayúscula, un carácter especial y un número.</div>';
            echo '<div class="alert alert-warning">Ingrese Una Contraseña de '. $Min_Pass . ' digitos</div>';
            
        }else{
            if (($_POST["C_contra_N"]) != ($_POST["C_contra_N_2"])) { /*esta parte valida si ambas contraseñas son iguales*/
                echo '<div class="alert alert-warning">Las Contraseñas son Distintas </div>';
            }else{
                $sql3=$conexion->query("UPDATE tbl_ms_usuario SET Contraseña='$contraseña_Nueva', Fecha_Vencimiento='$F_Vencida', Modificado_Por='$usuario', Fecha_Modificacion='$Fecha_Actual' WHERE ID_Usuario='$ID_usuario'");
                $sql4=$conexion->query("INSERT INTO tbl_ms_hist_contraseña(ID_Usuario, Contraseña, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) VALUES ('$ID_usuario','$contraseña_Nueva','$usuario','$Fecha_Actual','$usuario','$Fecha_Actual')");
                
                echo '<div class="alert alert-success">Contraseña Actualizada Exitosamente</div>';
            }
        }
    }else{
        echo '<div class="alert alert-danger">Contraseña Actual Incorrecta </div>';
    }

 }

}
    
?>