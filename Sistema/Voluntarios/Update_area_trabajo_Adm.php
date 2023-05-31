<?php
    include("../../conexion_BD.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<title>Editar Area Trabajo</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>

    <?php
        if(isset($_POST['enviar_F2'])){   
    $ID_Area_Trabajo=$_POST["ID_Area_Trabajo"];
    $nombre_Area_Trabajo=$_POST["nombre_Area_Trabajo"];
    $descripcion_A_Trabajo=$_POST["descripcion_A_Trabajo"];
            //si lo que esta en el form esta vacio
            $query = "SELECT * FROM tbl_area_trabajo WHERE nombre_Area_Trabajo='$nombre_Area_Trabajo'";
            $verificacion = mysqli_query($conexion, $query);
            
            if (mysqli_num_rows($verificacion) > 0) {
                // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                echo "<script language='JavaScript'>
                        alert('Error!!!, El Area de trabajo ya existe');
                        location.assign('area_trabajo_Adm.php');
                      </script>";
                exit; // Finaliza la ejecución del script si hay errores
            }
            
            $sql="UPDATE tbl_area_trabajo SET nombre_Area_Trabajo = '$nombre_Area_Trabajo', descripcion_A_Trabajo='$descripcion_A_Trabajo' where ID_Area_Trabajo = $ID_Area_Trabajo";
            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('area_trabajo_Adm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['nareaBitacora']=$nombre_Area_Trabajo;
                            $model->UPAreaT();  

            }else{
                echo "<script language='JavaScript'>
                alert('Error!!!, Los datos no se actualizaron');
            location.assign('area_trabajo_Adm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Area_Trabajo']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_area_trabajo where ID_Area_Trabajo='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);
            $ID_Area_Trabajo=$fila["ID_Area_Trabajo"];
            $nombre_Area_Trabajo=$fila["nombre_Area_Trabajo"];
            $descripcion_A_Trabajo=$fila["descripcion_A_Trabajo"];
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar el Area de Trabajo</h1>
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
                            <label>ID Area de Trabajo(*):</label>
                            <input type="hidden" name="ID_Fondo" id="ID_Fondo">
                            <input style="text" type="text" class="form-control" name="ID_Area_Trabajo" id="ID_Area_Trabajo" maxlength="10"  value="<?php echo $ID_Area_Trabajo; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre del Area de Trabajo</label>
                            <input maxlength="49"oncopy="return false" type="text" class="form-control"  name="nombre_Area_Trabajo" id="nombre_Area_Trabajo" placeholder="Ingrese el nombre del Area de Trabajo" value="<?php echo $nombre_Area_Trabajo; ?>" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();"require>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Descripcion del Area de Trabajo</label>
                            <input maxlength="99"  oncopy="return false" type="text" class="form-control"  name="descripcion_A_Trabajo" id="descripcion_A_Trabajo" placeholder="Ingrese la descripcion del Area de Trabajo" value="<?php echo $descripcion_A_Trabajo; ?>" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();"require>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar_F2" value="AGREGAR"><i class="zmdi zmdi-download"></i> Guardar</button>
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
  <script src="./js/usuario.js"></script>
  <?php include '../sidebarpro.php'; ?>

  <script>
    //Confrimar cancelacion
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
    window.location.href = "area_trabajo_Adm.php";
  });
}
</script>

</body>
</html>