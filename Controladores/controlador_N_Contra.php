<?php
require '../conexion_BD.php';

if(isset($_POST['btn_enviar_R'])){

  session_start();
  $User =$_SESSION['user'];

  $NContra=$_POST["contranueva"];
  $R_Fecha_actual = date("Y-m-j");
  

   //Extrae el ID Del usuario
   $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$User'");
                
   while($row=mysqli_fetch_array($sql1)){
        $idUser=$row['ID_Usuario'];
   }

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

   $P_Vencida= date("Y-m-d",strtotime($R_Fecha_actual."+ ".$diasV." days"));

   if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_\W]).{'.$Min_Pass.',}$/', $NContra)) {
    echo '<script>alert("La contraseña debe contener al menos una letra minúscula, una letra mayúscula, un carácter especial, un número y \'' . $Min_Pass . '\' digitos");</script>';
    header("refresh:0;url=../Pantallas/nueva_Contrasena.php");

   }else{
      //edicion de contraseña, preguntas y primer ingreso
      $sql2=$conexion->query("UPDATE tbl_ms_usuario SET Contraseña='$NContra',Fecha_Vencimiento='$P_Vencida', Modificado_Por='$User', Fecha_Modificacion='$R_Fecha_actual', Estado_Usuario='ACTIVO' WHERE ID_Usuario='$idUser' ");
      $sql2=$conexion->query("INSERT INTO tbl_ms_hist_contraseña(ID_Usuario, Contraseña, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion)
       VALUES ('$idUser','$NContra','$User','$R_Fecha_actual','$User','$R_Fecha_actual')");
        
    
      
              echo'<script>alert("Datos Guardados exitosamente ")</script>';
              session_start();
              
              $_SESSION['user']=$User;
              $_SESSION['ID_User']=$idUser;
              header("refresh:0;url=../Pantallas/Login.php");
            ini_set('error_reporting', E_ALL);
   }

                
           
  


}
       



?>