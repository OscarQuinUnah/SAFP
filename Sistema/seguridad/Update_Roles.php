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
            // $id_rol=$_GET['id'];
            $id_rol2=$_POST['id'];

            $nombreRol=$_POST['Nombre_rol'];
            $descripcion=$_POST['descripcion'];//Obtenidos desde el formulario
            $estado= $_POST['estado'];
            $R_Fecha_actual = date('Y-m-d');       /*obtiene la fecha actual*/




            //si lo que esta en el form esta vacio
            if(empty($nombreRol)){
                echo"<p class='error'>* Debes colocar un rol</p>";
            }else if(empty($descripcion)){
                echo"<p class='error'>* Debes colocar una descripcion</p>";
            }else if(empty($estado)){
                echo"<p class='error'>* Debes colocar un estado</p>";
            }else{




              $query = "SELECT * FROM tbl_ms_roles WHERE Rol='$nombreRol'";
              $verificacion = mysqli_query($conexion, $query);
              
              if (mysqli_num_rows($verificacion) > 0) {
                  // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                  echo "<script language='JavaScript'>
                          alert('Error!!!, Ese Rol ya existe');
                          location.assign('RolesAdm.php');
                        </script>";
                  exit; // Finaliza la ejecución del script si hay errores
              }
            //UPDATE tbl_ms_usuario SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_ms_roles SET Rol = '$nombreRol', Descripcion ='$descripcion', Estado = $estado, Modificado_Por = '$usuario', Fecha_Modificacion = '$R_Fecha_actual' WHERE ID_ROL = $id_rol2";
            $resultado=mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('RolesAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                     session_start();                       
                            $_SESSION['RolBitUP']=$nombreRol;
                            $model->RegUptRol();

            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('RolesAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Rol']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_ms_roles where ID_Rol='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $nombreRol=$fila['Rol'];
            $descripcion=$fila['Descripcion'];
            $estado=$fila['Estado'];//recuperando los datos desde la BD

            if($fila['Estado'] == 1){
                $strEstado = "ACTIVO";
              }else{
                $strEstado = "INACTIVO";
              } 
              

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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Roles</h1>
                        </div>
                        <br>
                    </div>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>ID ROL(*):</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="id" id="id" maxlength="100" placeholder="Ingrese la descripcion del rol" value="<?php echo $id?>"  readonly required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre rol(*):</label>
                            <input type="hidden" name="Nombre_rol" id="Nombre_rol">
                            <input type="text" class="form-control" name="Nombre_rol" id="Nombre_rol" maxlength="100" placeholder="Ingrese el nombre del Rol" value="<?php echo $nombreRol?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Descripcion(*):</label>
                            <input type="hidden" name="descripcion" id="descripcion">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="100" placeholder="Ingrese la descripcion del rol" value="<?php echo $descripcion ?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Estado usuario(*)</label>
                            <select class="form-control" name="estado" id="estado" required>
                              <option value="">Seleccione un Estado</option>
                              <option value="1" <?php if ($strEstado == 'ACTIVO') echo 'selected'; ?>>ACTIVO</option>
                              <option value="2" <?php if ($strEstado == 'INACTIVO') echo 'selected'; ?>>INACTIVO</option>
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



	<!--script en java para los efectos-->
  
<script>
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
    window.location.href = "RolesAdm.php";
  });
}
</script>

	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>