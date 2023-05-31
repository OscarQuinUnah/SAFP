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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>
	<!--Seccion donde va toda la barra lateral -->
	<?php include '../sidebar.php'; ?>

    <?php
    
        if(isset($_POST['enviar'])){
            //aqui entra sio el usuario ha presionado el boton enviar
            $id=$_POST['IDusuario'];
            $userName=$_POST['Nombre_Usuario'];
            $user=$_POST['Usuario'];//Obtenidos desde el formulario
            $Rol= $_POST['Rol'];
            $contra=$_POST['contraseña'];
            $email=$_POST['Correo_electronico'];
            $vencimiento = $_POST['FechaVencimiento'];
            $Estado = strtoupper($_POST['Estado']);
            $R_Fecha_actual = date('Y-m-d'); 



            //si lo que esta en el form esta vacio
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo "<p class='error'> El correo es incorrecto</p>";
            }else{





            //UPDATE tbl_ms_usuario SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_ms_usuario SET Nombre_Usuario = '$userName', Usuario ='$user', ID_Rol ='$Rol', Contraseña = '$contra', Correo_electronico = '$email', Fecha_Vencimiento = '$vencimiento', Estado_Usuario = '$Estado', Modificado_Por = '$usuario', Fecha_Modificacion = '$R_Fecha_actual' WHERE ID_Usuario='$id'";
            $resultado=mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('usuariosAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                     session_start();                       
                            $_SESSION['UsuarioBitUP']=$userName;
                            $_SESSION['IDUsuarioBitUP']=$id;
                            $model->RegUptusu();
            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('usuariosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Usuario']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_ms_usuario where ID_Usuario='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $idUser=$fila['ID_Usuario'];
            $nombreUsuario=$fila['Nombre_Usuario'];
            $usuario=$fila['Usuario'];//recuperando los datos desde la BD
            $Rol=$fila['ID_Rol'];
            $pass=$fila['Contraseña'];
            $correo=$fila['Correo_electronico'];
            $vencimiento=$fila['Fecha_Vencimiento'];
            $Estado=$fila['Estado_Usuario'];

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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar usuarios</h1>
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
                            <input type="hidden" name="IDusuario" id="IDusuario">
                            <input type="text" class="form-control" name="IDusuario" id="IDusuario" maxlength="100" value="<?php echo $idUser; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Usuario(*):</label>
                            <input type="hidden" name="Usuario" id="Usuario">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="Usuario" id="Usuario" maxlength="100"  value="<?php echo $usuario; ?>" placeholder="Ingrese el usuario" onkeypress="validarMayusculas(event)"  oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre Usuario(*):</label>
                            <input type="hidden" name="Nombre_Usuario" id="Nombre_Usuario">
                            <input type="text" class="form-control" name="Nombre_Usuario" id="Nombre_Usuario" maxlength="100" placeholder="Ingrese el nombre de usuario" value="<?php echo $nombreUsuario; ?>"  oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Rol de usuario:(*):</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_ms_roles");
                            ?>
                            <select class="form-control" name="Rol" id="Rol" required>
                            <option value="">Seleccione un rol</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_Rol'] == $Rol) ? 'selected' : '';
                            echo "<option value='".$row1['ID_Rol']."' ".$selected.">".$row1['Rol']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Correo electrónico (*):</label>
                           <input type="hidden" name="Correo_electronico" id="Correo_electronico">
                           <input type="text" class="form-control" name="Correo_electronico" id="Correo_electronico" maxlength="100" placeholder="Ingrese el correo electrónico" value="<?php echo $correo; ?>" onkeypress="validarCorreo(event)" required>
                            </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label for="contraseña">Contraseña</label>
                          <div class="input-group">
                          <?php 
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
?>
                          <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" maxlength="<?php echo $Max_Pass ?>" onkeypress="return bloquearEspacio(event);" value="<?php echo $pass; ?>" required>
                           <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" id="ver-ocultar" onclick="mostrarContrasena()">
                          <i class="zmdi zmdi-eye"></i>
                          </button>
                         </div>
                         </div>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Fecha de Vencimiento(*):</label>
                            <input type="hidden" name="FechaVencimiento" id="FechaVencimiento">
                            <input type="date" class="form-control" name="FechaVencimiento" id="FechaVencimiento" maxlength="100" placeholder="Ingrese la fecha de vencimiento" value="<?php echo $vencimiento; ?>" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Estado usuario(*)</label>
                            <select class="form-control" name="Estado" id="Estado" required>
                              <option value="">Seleccione un Estado</option>
                              <option value="ACTIVO" <?php if ($Estado == 'ACTIVO') echo 'selected'; ?>>ACTIVO</option>
                              <option value="BLOQUEADO" <?php if ($Estado == 'BLOQUEADO') echo 'selected'; ?>>BLOQUEADO</option>
                              <option value="NUEVO" <?php if ($Estado == 'NUEVO') echo 'selected'; ?>>NUEVO</option>
                              <option value="INACTIVO" <?php if ($Estado == 'INACTIVO') echo 'selected'; ?>>INACTIVO</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
                          <button class="btn btn-danger" onclick="cancelar()" type="button"><i class="zmdi zmdi-close-circle"></i> Cancelar</button>
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


<script>
  //Confirmar cancelacion
  function cancelar() {
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
    window.location.href = "usuariosAdm.php";
  });
}
</script>

	<!--script en java para los efectos-->
	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>