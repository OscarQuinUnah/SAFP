<?php
session_start();
require '../conexion_BD.php';
/*cuando se presiona el boton enviar registro */ 
if (!empty($_POST["btn_enviar_R"])) {
    /*si el campo usuario o contraseña o nombre completo o contraseña no tiene datos envia una alterta*/
    $Contra=$_POST["R_contra"];
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
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_\W]).{'.$Min_Pass.',}$/', $Contra)) {
        echo "La contraseña debe tener al menos una letra minúscula, una letra mayúscula, un carácter especial y un número.";
        echo"ingrese una contraseña de $Min_Pass  digitos";
    } else {
    if (empty($_POST["R_usuario"]) and empty($_POST["R_contra"])and empty($_POST["R_correo"]) and empty($_POST["R_Nombre"])) 
    {
        echo '<div class="alert alert-danger">los campos estan vacios</div>';
    } else{
        $R_usuario=$_POST["R_usuario"];/*esta seccion valida si el usuario existe en la base de datos, despues de llenar la variable registro_usuario */
                $sql=$conexion->query("SELECT * FROM tbl_ms_usuario where Usuario='$R_usuario'");
                if ($datos=$sql->fetch_object()) {
                    echo "<br/>". "El Nombre de Usuario ya existe en la base de datos." . "<br/>";
                    echo "<br/>". "Por favor use otro nombre de usuario." . "<br/>";
                } else {
            
            
            if (($_POST["R_contra"]) != ($_POST["R_contra_2"])) { /*esta parte valida si ambas contraseñas son iguales*/
                echo '<div class="alert alert-danger">la contraseña es distinta </div>';
            }else{
                $R_Correo=$_POST["R_correo"];/*primero llenamos la variable Registro_correo y luego validamos que sea un correo*/ 
                if (!filter_var($R_Correo, FILTER_VALIDATE_EMAIL)) {
                    echo '<div class="alert alert-danger">formato de correo erroneo</div>'; 
                }else {
                    /*despues de haber validad todo el documento y que se haya cumplido todo comienza esta seccion */
                    /*primero crea un id aleatorio de solo numeros con un tamaño de 5 caracteres */
                    $caracteres = '0123456789'; /*abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ mantengo esto por si se desea usar varchar*/

	                function generarID($caracteres, $Tamaño= 5)
	                {
		                    $Max = strlen($caracteres);
		                     $ID_A = '';
		                     for ($c = 0; $c < $Tamaño; $c++) {
			                 $ID_A .= $caracteres[random_int(0, $Max - 1)];
		                   }
		
		               return $ID_A;
	                }
                $ID_Usuario=(generarID($caracteres, $Tamaño= 5));
                $R_Nombre=$_POST["R_Nombre"];
                $R_usuario=strtoupper($_POST["R_usuario"]); /*convierte los datos de usuario en mayusculas*/ 
                $R_contra=$_POST["R_contra"];
                $R_Correo=$_POST["R_correo"];
                $R_Fecha_actual = date('Y-m-d');       /*obtiene la fecha actual*/
                $sql1=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE ID_Parametro=7");
                
                    while($row=mysqli_fetch_array($sql1)){
                    $diasV=$row['Valor'];
                    }
                $R_F_Vencida= date("Y-m-j",strtotime($R_Fecha_actual."+ ".$diasV." days")); /*le suma 1 mes a la fecha actual*/
                $sql=$conexion->query("INSERT INTO tbl_ms_usuario(ID_Usuario,ID_Rol,Nombre_Usuario,Usuario,Contraseña,Correo_Electronico,Fecha_Ultima_conexion, Preguntas_contestadas, Primer_ingreso, Fecha_vencimiento, Creado_por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion, Estado_Usuario, Intentos) 
                VALUES ('$ID_Usuario',3,'$R_Nombre', '$R_usuario','$R_contra','$R_Correo','$R_Fecha_actual',0,1,'$R_F_Vencida','$R_usuario', '$R_Fecha_actual','$R_usuario', '$R_Fecha_actual','INACTIVO',0)");
                //aqui iria la funcion bitacora                    

                       
                $sql2=$conexion->query("INSERT INTO tbl_ms_hist_contraseña(`ID_Usuario`, `Contraseña`, `Creado_Por`, `Fecha_Creacion`) VALUES ('$ID_Usuario','$R_contra','$R_usuario','$R_Fecha_actual')");

                if ($sql) {
                        echo'<script>alert("Datos Guardados exitosamente ")</script>';
                } else {
            ini_set('error_reporting', E_ALL);
                }
                $nombreUsuario=$R_usuario;
                require_once "../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            $_SESSION['UsuarioBitacora']=$nombreUsuario;
                            $_SESSION['IDUsuarioBitacora']=$ID_Usuario;
                            $model->RegautoInsert();

                
                //regNuevoUser();
                $_SESSION['user']=$R_usuario;
                $_SESSION['ID_User']=$ID_Usuario;
                header("location:../Pantallas/Preguntas_RAI.php"); /*como esto es autoregistro el usuario debe configurar las preguntas secretas */
                }
                    
            }
            
        }
        }
        
    }  
    }
?>