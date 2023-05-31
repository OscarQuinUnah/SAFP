<?php
include ("../conexion_BD.php");


    session_start();
    $User=$_POST['Usuario_Recupera'];
    
    // Almacenamos el valor del usuario en una variable de sesión
//$_SESSION['Usuario_Recupera'] = $User;

    $pregunta=$_POST["Pregunta"];
    $respuesta=$_POST["respuesta"];
//                $NContra=$_POST["contranueva"];
    $R_Fecha_actual = date('Y-m-j');

        $sql=$conexion->query("SELECT * FROM tbl_ms_usuario WHERE Usuario='$User' and Estado_Usuario='ACTIVO'");

              
    if (mysqli_num_rows($sql)==0) {
            //Verifica que no exista el usuario
        
        echo'<script>alert("Ingrese un Usuario Valido o contactese con uno de los Administradores")</script>';
        header( "refresh:0;url=../Pantallas/controlador_recupera_contra_p.php" ); 

    } else {
        
        //Extrae el Id del usuario
        while($row=mysqli_fetch_array($sql)){
                       $idUser=$row['ID_Usuario'];
          }

        $sql1=$conexion->query("SELECT * FROM `tbl_ms_preguntas_x_usuario` WHERE ID_Pregunta='$pregunta' and  Respuesta='$respuesta' AND ID_Usuario='$idUser'");
        //si trae registros de preguntas agregadas por usuario
        if (mysqli_num_rows($sql1)>=1) {
            session_start();
            $_SESSION['user']=$User;

            // Redirige al New_pass_preg.php y pasa el usuario SQL como parámetro
            header("Location: ../Pantallas/New_pass_preg.php");
            exit;

        }else{
            //edicion de contraseña, preguntas y primer ingreso
                $sql2=$conexion->query("UPDATE tbl_ms_usuario SET Estado_Usuario='INACTIVO' WHERE ID_Usuario='$idUser'");
                 echo'<script>alert("Pregunta o respuesta Invalida. Contactese con uno de los Administradores ")</script>';
                   header( "refresh:0;url=../Pantallas/Login.php" ); 
   
        }


    } 
    




?>