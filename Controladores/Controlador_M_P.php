<?php
include ("../conexion_BD.php");

if (!empty($_POST["btn_enviar_M_P"])) {
 //session_start();
    $User=$_POST['Usuario_Recupera'];
     $pregunta=$_POST["Pregunta"];
                $respuesta=$_POST["respuesta"];
                $NContra=$_POST["contranueva"];
                $R_Fecha_actual = date('Y-m-j');

$sql=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$User' and Estado_Usuario='ACTIVO'");
              
    if (mysqli_num_rows($sql)==0) {
            //Verifica que no exista el usuario
        
            echo'<script>alert("Ingrese un Usuario Valido ")</script>';
        
     header( "refresh:0;url=../Pantallas/controlador_recupera_contra_p.php" ); 
    } else {
        
        //Extrae el Id del usuario
        while($row=mysqli_fetch_array($sql)){
                       $idUser=$row['ID_Usuario'];
          }

        $sql1=$conexion->query("SELECT * FROM `tbl_ms_preguntas_x_usuario` WHERE ID_Pregunta='$pregunta' and  Respuesta='$respuesta' AND ID_Usuario='$idUser'");
        //si trae registros de preguntas agregadas por usuario
        if (mysqli_num_rows($sql1)>=1) {
            //edicion de contraseña, preguntas y primer ingreso
                $sql2=$conexion->query("UPDATE tbl_ms_usuario SET Contraseña='$NContra', Modificado_Por='$User', Fecha_Modificacion='$R_Fecha_actual' WHERE ID_Usuario='$idUser'");

                $sql3=$conexion->query(" INSERT INTO `tbl_ms_hist_contraseña`(`ID_Usuario`, `Contraseña`, `Creado_Por`, `Fecha_Creacion`) VALUES ('$idUser','$NContra','$User','$R_Fecha_actual')");


                 echo'<script>alert("Contraseña Actualizada ")</script>';
                          header("refresh:0;url=../Pantallas/Home.html");



        }else{
            //edicion de contraseña, preguntas y primer ingreso
                $sql2=$conexion->query("UPDATE tbl_ms_usuario SET Estado_Usuario='BLOQUEADO' WHERE ID_Usuario='$idUser'");
                 echo'<script>alert("Pregunta o respuesta Invalida. Usuario Bloqueado ")</script>';
                   header( "refresh:0;url=../Pantallas/controlador_recupera_contra_p.php" ); 
   
        }


    } }
    




?>