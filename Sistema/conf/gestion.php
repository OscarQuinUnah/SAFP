
<?php
require '../../conexion_BD.php';
/*esta variable impide que se pueda entrar al sistema principal si no se entra por login (crea un usuario global) */
require_once "../../EVENT_BITACORA.php";
session_start();
$usuario=$_SESSION['user'];
$ID_usuario = $_SESSION['ID_User'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Perfil</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
    <!-- Incluya el archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
		/* Personaliza el ancho de los campos de entrada */
		.form-control-sm {
			width: 500px;
		}

    .container-fluid h1{
    text-align: center;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    color: black;
    margin-top: 20px;
    margin-bottom: 20px;
    

	}
	</style>
  
<script>
function opencontra() {
  // Definir las dimensiones de la ventana emergente
  var width = 500;
  var height = 500;

  // Obtener un identificador único para la ventana emergente
  var id = Date.now();

  // Obtener la URL de la página que se desea abrir en la ventana emergente
  var url = 'cambio_Contra_admin.php';

  // Abrir la ventana emergente
  window.open(url, id, 'width=' + width + ',height=' + height);
}
</script>
</head>

<?php include '../sidebar.php'; ?>



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
                     
                        <div class="container-fluid" class="full-box cover dashboard-sideBar" style="overflow-y: auto;">
                              <h1>Gestion de Usuario</h1>
                              <hr style="margin-bottom: 20px;">
                        </div>

                      <?php 
                          $sql="SELECT * FROM tbl_ms_usuario where ID_Usuario='".$ID_usuario."'";
                          $resultado=mysqli_query($conexion,$sql);

                          $fila=mysqli_fetch_assoc($resultado);

                          $Nombre_Usuario=$fila['Nombre_Usuario'];
                          $Usuario=$fila['Usuario'];
                          $Contraseña=$fila['Contraseña'];
                          $Correo_electronico=$fila['Correo_electronico'];
                          mysqli_close($conexion);
                          ?>

      <div class="container">
    
        <div class="row">
            <!-- Columna de datos personales -->
            <div class="col-lg-6">
                <h2 class="font-weight-bold pb-2 border-bottom">Datos Personales</h2>
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre: </label>
                        <input class="form-control" type="text" id="N_U_Imput" name="N_U_Imput" value="<?php echo $Nombre_Usuario ?>" readonly require>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Usuario: </label>
                        <input class="form-control" type="text" id="U_Imput" name="U_Imput" value="<?php echo $Usuario ?>" readonly require>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Correo Electronico: </label>
                        <input class="form-control" type="text" id="C_E_Imput" name="C_E_Imput" value="<?php echo $Correo_electronico ?>" readonly require>
                    </div>
                   <!-- <button type="submit" class="btn btn-primary">Guardar Cambios</button>-->
                </form>
            </div>
            <!-- Columna de gestión de contraseña -->
            <div class="col-lg-6">
                <h2 class="font-weight-bold pb-2 border-bottom">Gestión de Contraseña</h2>
                <form>
                    <div class="form-group">
                        <label for="contraseñaActual">Contraseña: </label>
                        <input class="form-control" type="password" value="<?php echo $Contraseña ?>" readonly>
                    </div>
                    <button style="margin-bottom: 20px;" type="submit" class="btn btn-primary" onclick="opencontra()">Cambiar contraseña</button>
                </form>                    
                        
                
                        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
		
	</section>


	
	<!--script en java para los efectos-->
  <script src="../../js/events.js"></script>
  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>