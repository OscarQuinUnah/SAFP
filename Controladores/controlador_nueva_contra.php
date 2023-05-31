<?php

include ("../conexion_BD.php");


    session_start();
    $token=$_POST['token'];
    $contra_new=$_POST['contrasena_nueva'];
    $contra_confir_new=$_POST['confirmar_contrasena'];
    //Extrae las fechas
    $Fecha_Actual = date('Y-m-d');

    
    //Consulta a la base de datos, con la contraseña proporcionada y verifica si el estado es activo
    $sql=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Token='$token' and Estado_Usuario='ACTIVO'");
    if (mysqli_num_rows($sql) ==1) {
        while($row=mysqli_fetch_array($sql)){
            $idUser=$row['ID_Usuario'];
            $User=$row['Usuario'];
            $Contraseña=$row['Contraseña'];
            $Fecha_Vencimiento=$row['Fecha_Vencimiento'];
        }  
          
            //Valida si la fecha del sistema es la igual o mayor a la fecha de vencimiento,
            //El usuario se bloque
            if ($Fecha_Vencimiento == $Fecha_Actual or $Fecha_Vencimiento < $Fecha_Actual) {
                echo'<script>alert("Lo sentimos tu contraseña a expirado. Por favor contactese con uno de los administradores")</script>';
                header("refresh:0;url=../Pantallas/Nueva_Contra.php");
                //echo '<div class="alert_danger">Lo sentimos tu contraseña a expirado, por favor contactese con uno de los administradores </div>';
                
                //Se le bloquea el usuario
                $sql1=$conexion->query("UPDATE tbl_ms_usuario SET Estado_Usuario='INACTIVO', Fecha_Modificacion='$Fecha_Actual' WHERE ID_Usuario='$idUser'");
                
              } else if ($Fecha_Vencimiento > $Fecha_Actual) {
    
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

                        $F_Vencida= date("Y-m-d",strtotime($Fecha_Actual."+ ".$diasV." days"));
                        

                        if (strlen($contra_new) < $Min_Pass || !preg_match('/[a-z]/', $contra_new) || !preg_match('/[A-Z]/', $contra_new) || !preg_match('/[0-9]/', $contra_new) ) {
                            echo'<script>alert("Contraseña poco segura. Debe contener al menos \'' . $Min_Pass . '\' caracteres , 1 numero, 1 Mayuscula y 1 minuscula")</script>';
                            header("refresh:0;url=../Pantallas/Nueva_Contra.php");
                           
    
                        }else {
                            if ($contra_new === $contra_confir_new) {
                                $sql3=$conexion->query("UPDATE tbl_ms_usuario SET Contraseña='$contra_new', Fecha_Vencimiento='$F_Vencida', Modificado_Por='$User', Fecha_Modificacion='$Fecha_Actual' WHERE ID_Usuario='$idUser'");
                                $sql4=$conexion->query("INSERT INTO tbl_ms_hist_contraseña(ID_Usuario, Contraseña, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) VALUES ('$idUser','$contra_new','$User','$Fecha_Actual','$User','$Fecha_Actual')");
                                $sql5=$conexion->query("UPDATE tbl_ms_usuario SET Token=NULL WHERE ID_Usuario='$idUser'");
                                echo'<script>alert("Su contraseña se ha actualizado exitosamente")</script>';
                                header("refresh:0;url=../Pantallas/Login.php");
    
                            }else {
                                echo'<script>alert("La contraseñas no coinciden")</script>';
                                header("refresh:0;url=../Pantallas/Nueva_Contra.php");
                            }
                         }
                    }
                                       
                        
        
    }else {
        echo'<script>alert("Lo sentimos, Ha surgido un error. Por favor contactese con uno de los administradores")</script>';
        header("refresh:0;url=../Pantallas/Nueva_Contra.php");
    } 

?>