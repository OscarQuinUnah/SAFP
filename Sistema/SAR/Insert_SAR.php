<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGREGAR</title>
    <link rel="stylesheet" href="../../css/estilos.css">

    <script>
        function soloLetras(e) {
            // Obtener el código ASCII de la tecla presionada
            var key = e.keyCode || e.which;
            
            // Convertir el código ASCII a una letra
            var letra = String.fromCharCode(key).toLowerCase();
            
            // Definir la expresión regular
            var soloLetras = /[a-z\s]/;
            
            // Verificar si la letra es válida
            if (!soloLetras.test(letra)) {
                // Si la letra no es válida, cancelar el evento
                e.preventDefault();
                return false;
            }
        }
        </script>
            <script>
                function validarMayusculas(e) {
                    var tecla = e.keyCode || e.which;
                    var teclaFinal = String.fromCharCode(tecla).toUpperCase();
                    var letras = /^[A-Z]+$/;

                    if(!letras.test(teclaFinal)){
                        e.preventDefault();
                    }
                }
            </script>
                    <script>
        function bloquearEspacio(event) {
        var tecla = event.keyCode || event.which;
        if (tecla == 32) {
            return false;
        }
        }
</script>

</head>
<body>

    <?php
    include("../../conexion_BD.php");

    //===================================================
    
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
    
                //Parte 2
                
                $R_Fecha_actual = date('Y-m-d');       /*obtiene la fecha actual*/


                $sql1=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE ID_Parametro=7");
                
                    while($row=mysqli_fetch_array($sql1)){
                    $diasV=$row['Valor'];
                    }
                $R_F_Vencida= date("Y-m-j",strtotime($R_Fecha_actual."+ ".$diasV." days")); /*le suma 1 mes a la fecha actual*/
                //fin parte 2
    //====================================================
        if(isset($_POST['enviar'])){



            //$ID_SAR = $_POST['id_sar'];
            $RTN = $_POST['rtn'];
            $num_declaracion = $_POST['numDeclaracion'];

            $tipoDeclaracion = $_POST['tipoDeclaracion'];

            $nombre_razonSocial = $_POST['razonSocial'];

            $monto = $_POST['Monto'];

            $departamento = $_POST['departamento'];
            $municipio = $_POST['municipio'];
            $barrio_colonia = $_POST['barrioColonia'];
            $calle_avenida = $_POST['calleAvenida'];
            $num_casa = $_POST['numCasa'];
            $bloque = $_POST['bloque'];
            //   if (is_null($_POST['bloque'])) {
            //      // El valor de $_POST['bloque'] está vacío
            //      $bloque = NULL;
            //   }else{
            //      $bloque = $_POST['bloque'];
            //   }
            $telefono = $_POST['telFijo'];
            $celular = $_POST['telCelular'];
            $domicilio = $_POST['domicilio'];
            $correo = $_POST['Correo_electronico'];
            $profesion_oficio = $_POST['profesionOficio'];
            $cai = $_POST['cai'];
            $fecha_limite_emision = $_POST['fechaEmision'];
            $num_inicial = $_POST['numeroInicial'];
            $num_final = $_POST['numeroFinal'];



            //$colores = $_POST['colores'];



            include("../../conexion_BD.php");

                // if (strlen($contraseña) < 8 || !preg_match('/[a-z]/', $contraseña) || !preg_match('/[A-Z]/', $contraseña) || !preg_match('/[0-9]/', $contraseña) ) {
                //     echo'<script>alert("Contraseña poco segura. Debe contener al menos 8 caracteres , 1 numero, 1 Mayuscula y 1 minuscula")</script>';
                //     header("refresh:0;url=usuariosAdm.php");
                //     //echo '<div class="alert_danger">Contraseña poco segura. Debe contener al menos 8 caracteres , 1 numero, 1 Mayuscula y 1 minuscula</div>';


                // }else{

                

        try {
            // $sql = "INSERT INTO tbl_r_sar (RTN, num_declaracion, nombre_razonSocial, Monto, departamento, municipio, barrio_colonia, calle_avenida, num_casa, bloque, telefono, celular, domicilio, correo, profesion_oficio, cai, fecha_limite_emision, num_inicial, num_final, tipo_declaracion) VALUES ('$RTN', $num_declaracion, '$nombre_razonSocial', $monto,'$departamento','$municipio', '$barrio_colonia','$calle_avenida', $num_casa, $bloque, $telefono, $celular, '$domicilio', '$correo', '$profesion_oficio', '$cai', '$fecha_limite_emision', $num_inicial, $num_final, '$tipoDeclaracion')";

            $sql = "INSERT INTO tbl_r_sar (RTN, num_declaracion, tipo_declaracion, nombre_razonSocial, Monto, departamento, municipio, barrio_colonia, calle_avenida, num_casa, bloque, telefono, celular, domicilio, correo, profesion_oficio, cai, fecha_limite_emision, num_inicial, num_final) VALUES ('$RTN',  $num_declaracion, '$tipoDeclaracion', '$nombre_razonSocial', $monto, '$departamento', '$municipio', '$barrio_colonia', '$calle_avenida', $num_casa, '$bloque', $telefono, $celular, '$domicilio', '$correo', '$profesion_oficio', '$cai', '$fecha_limite_emision', $num_inicial, $num_final)";

            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                //Los datos ingresados a la BD
                echo "<script languaje='JavaScript'>
                        alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('SAR_Adm.php');
                            </script>";     
                            require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['RTNSarBitacora']=$RTN;
                            $model->RegInsertSar();
 
                         
            }else{
                // Los dcatos NO ingresaron a la BD
                echo "<script languaje='JavaScript'>
                alert('Los datos NO fueron ingresados a la BD');
                    location.assign('SAR_Adm.php');
                    </script>";
            }
        } catch (Exception $e) {
            $errorCode = $e->getCode(); // Almacenar el código de error SQL\   
                $errorMessage = $e->getMessage(); // Almacenar el mensaje de error SQL

                echo $errorMessage;
                echo $errorCode;

                // $sql2 = "SELECT mensaje FROM tbl_errores WHERE codigo = $errorCode";
                // $resultado=mysqli_query($conexion,$sql2);

                // $row = mysqli_fetch_assoc($resultado);
                //$mensaje = $row['mensaje'];
                //echo $mensaje;

                // echo "<script languaje='JavaScript'>
                //     alert('Excepción capturada: $mensaje');
                //     location.assign('SAR_Adm.php');
                // </script>";
        }
            
            
        }
        mysqli_close($conexion);
    ?>
</body>
</html>