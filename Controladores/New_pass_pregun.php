<?php
include ("../conexion_BD.php");

if(isset($_POST['btn_enviar_P'])){

    // Recupera el usuario SQL del parámetro del controlador/recupera_contra_pregunta.php
    session_start();
    $User =$_SESSION['user'];
    //Extrae las variables del formulario
    $NContra=$_POST["p_contranueva"];
    $P_Fecha_Actual = date('Y-m-j');
    

    $sql=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$User' and Estado_Usuario='ACTIVO'");
    if (mysqli_num_rows($sql)==1) {

        while($row=mysqli_fetch_array($sql)){
            $idUser=$row['ID_Usuario'];
        } 
        
        //Se le permite hacer el cambio de contraseña
        //Trae el parametro de vencimiento DE CONTRASEÑA
        $sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro` in(7,9)");
                // Verificar si la consulta devolvió resultados
                if (mysqli_num_rows($sql2) >= 1) {
                    // Recorrer los resultados y mostrarlos en pantalla
                    while($row = mysqli_fetch_array($sql2)) {
                        if ($row['ID_Parametro'] == 7) {
                            $diasV=$row['Valor'];
                        } 

                        if ($row['ID_Parametro'] == 9) {
                            $Min_Pass=$row['Valor'];
                        }     
                    }
                }

        $P_Vencida= date("Y-m-d",strtotime($P_Fecha_Actual."+ ".$diasV." days"));

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_\W]).{'.$Min_Pass.',}$/', $NContra)) {
        
            //echo '<div class="alert alert-danger">La contraseña debe tener al menos una letra minúscula, una letra mayúscula, un carácter especial y un número.</div>';
            echo '<script>alert("La contraseña debe contener al menos una letra minúscula, una letra mayúscula, un carácter especial, un número y \'' . $Min_Pass . '\' digitos");</script>';
            header("refresh:0;url=../Pantallas/New_pass_preg.php");
            
        }else{
            $sql3=$conexion->query("UPDATE tbl_ms_usuario SET Contraseña='$NContra', Fecha_Vencimiento='$P_Vencida', Modificado_Por='$User', Fecha_Modificacion='$P_Fecha_Actual' WHERE ID_Usuario='$idUser'");
            $sql4=$conexion->query("INSERT INTO tbl_ms_hist_contraseña(ID_Usuario, Contraseña, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) VALUES ('$idUser','$NContra','$User','$P_Fecha_Actual','$User','$P_Fecha_Actual')");

            echo'<script>alert("Contraseña Actualizada Exitosamente")</script>';
            header("refresh:0;url=../Pantallas/Login.php");
        }



    }else {
        echo'<script>alert("Lo sentimos a surgido un error, contactese con uno de los administradores.")</script>';
                header("refresh:0;url=../Pantallas/New_pass_preg.php");
    }

}

?>