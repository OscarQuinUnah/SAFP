<?php 
//Controladores importantes
 require '../../conexion_BD.php'; 
 require_once "../../EVENT_BITACORA.php";
 session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>
	<!--Seccion donde va toda la barra lateral -->
	<?php include '../sidebarpro.php'; ?>

    <?php
    
        if(isset($_POST['enviar'])){
            //aqui entra sio el usuario ha presionado el boton enviar
            $ID_donante=$_POST['ID_donante'];
            $Nombre_donan=$_POST['Nombre_Donante'];
            $Telef=$_POST['Telef'];//Obtenidos desde el formulario
            $Direcc= $_POST['Direccion'];
            $email=$_POST['Correo_electronico'];
            $R_Fecha_actual = date('Y-m-d'); 



            //si lo que esta en el form esta vacio
            if(empty($Nombre_donan)){
                echo"<p class='error'>* Debes colocar tu nombre completo</p>";
            }else if(empty($Telef)){
                echo"<p class='error'>* Debes colocar tu usuario</p>";
            }else if(empty($Direcc)){
                echo"<p class='error'>* Debes colocar tu password</p>";
            }else if(empty($email)){
                echo"<p class='error'>* Debes colocar tu correo</p>";
            
            }else{

            //UPDATE tbl_ms_usuario SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_donantes SET Nombre_D = '$Nombre_donan', Tel_cel_D = '$Telef', Direccion_D = '$Direcc' , Correo_D = '$email', Modificado_Por='$usuario' ,Fecha_Modificacion = '$R_Fecha_actual' WHERE ID_Donante='$ID_donante';";
            $resultado=mysqli_query($conexion,$sql);
            //Modificado_por = '$Usuario'//

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('DonacAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                    session_start();

                    $_SESSION['donanteBitacoraUP']=$Nombre_donan;
                    $model->RegUptdon();
            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('DonacAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }
        }else{
            //si el usuario NO ha presionado el boton enviar/
            $id=$_GET['ID_Donante']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_donantes where ID_Donante='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $IdDonan=$fila['ID_Donante'];
            $Nombre_donan=$fila['Nombre_D'];
            $Tel_Cel=$fila['Tel_cel_D'];
            $Direcc=$fila['Direccion_D'];//recuperando los datos desde la BD
            $correo=$fila['Correo_D'];

            mysqli_close($conexion);

    ?>
    	<!-- Pagina de contenido-->
	<section class="full-box dashboard-contentPage" style="overflow-y: auto;">
		<!-- Barra superior -->
		<nav class="full-box dashboard-Navbar">
			<ul class="full-box list-unstyled text-right">
				<li class="pull-left">
					<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
				</li>
			</ul>
		</nav>
		<!-- Muestra el contenido de la pagina -->
		<div class="container-fluid">
        <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Donantes</h1>
                        </div>
                        <br>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="container">
                          <div class="row">
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>ID_Usuario(*):</label>
                            <input type="hidden" name="ID_donante" id="ID_donante">
                            <input type="text" class="form-control" name="ID_donante" id="ID_donante" maxlength="100" value="<?php echo $IdDonan; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre Donante(*):</label>
                            <input type="hidden" name="Nombre_Donante" id="Nombre_Donante">
                            <input onpaste="return false" type="text" value="<?php echo $Nombre_donan; ?>" class="form-control" name="Nombre_Donante" id="Nombre_Donante" maxlength="39" placeholder="Ingrese el nombre del donante" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Telefono(*):</label>
                            <input type="hidden" name="Telef" id="Telef">
                            <input onpaste="return false" type="text" value="<?php echo $Tel_Cel; ?>" class="form-control" name="Telef" id="Telef" pattern="[0-9()+-]{8,20}" maxlength="19" placeholder="Ingrese el número de teléfono" onkeypress='return event.charCode >= 48 && event.charCode <= 57' oninput="validarTelefono(event)" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Direccion(*):</label>
                            <input type="hidden" name="Direccion" id="Direccion">
                            <input onpaste="return false" type="text" class="form-control" name="Direccion" id="Direccion" maxlength="39" placeholder="Ingrese la dirrecion del donante" value="<?php echo $Direcc; ?>" oninput="this.value = this.value.toUpperCase();" require>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Correo electronico(*):</label>
                            <input type="hidden" name="Correo_electronico" id="Correo_electronico">
                            <input onpaste="return false"  type="text" class="form-control" name="Correo_electronico" id="Correo_electronico" maxlength="39" placeholder="Ingrese el correo electronico"  value="<?php echo $correo; ?>" onkeypress="validarCorreo(event)" onkeydown="return evitarEspacios(event)" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
                          <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="zmdi zmdi-close-circle"></i> Cancelar</button>
                        </div>
                          </div>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
		</div>
	</section>
                        

    <?php
        }
    ?>



	<!--script en java para los efectos-->
	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

  <script>
    //Validar Telefono
    function validarTelefono(event) {
    const telefono = event.target.value.trim();
    
    if (telefono.length < 8 || telefono[0] === '0') {
        event.target.setCustomValidity('El número de teléfono no debe comenzar en 0 y debe tener minimo 8 digitos.');
    } else {
        const numeros = telefono.replace(/[^0-9]/g, '');
        const repetidos = numeros.split('').sort().join('').match(/(.)\1{4}/g);
        
        if (repetidos) {
        event.target.setCustomValidity('El número de teléfono contiene más de 5 dígitos repetidos consecutivos.');
        } else {
        const unicos = new Set(numeros);
        const porcentaje = unicos.size / telefono.length;
        
        if (porcentaje < 0.5) {
            event.target.setCustomValidity('El número de teléfono no cumple los requisitos mínimos.');
        } else {
            event.target.setCustomValidity('');
        }
        }
    }
    }
  </script>


<script>
  //Evitar espacios
function evitarEspacios(event) {
  if (event.keyCode === 32) { // 32 es el código de tecla para el espacio en blanco
    event.preventDefault(); // Cancelar el evento de pulsación de tecla
    return false; // Impedir la entrada del espacio en blanco
  }
}
</script>


<script>
  //Confirmar cancelacion
  function cancelarform() {
  swal({
    title: 'Confirmar Cancelacion',
    text: "¿Estás seguro de que deseas cancelar? Todos los datos no guardados se perderán.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#40C13C',
    cancelButtonColor: '#F44336',
    confirmButtonText: '<i class="zmdi zmdi-check"></i> Si, cancelar',
    cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, Volver'
  }).then(function () {
    window.location.href = "DonacAdm.php";
  });
}
</script>

</body>
</html>