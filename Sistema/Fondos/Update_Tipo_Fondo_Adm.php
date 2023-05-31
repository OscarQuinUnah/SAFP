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

<title>Editar Tipo Fondo</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>

    <?php
        if(isset($_POST['enviar_F2'])){   
    $ID_tipo_fondo=$_POST["ID_tipo_fondo"];
    $nombre_T_Fondo=$_POST["nombre_T_Fondo"];
            //si lo que esta en el form esta vacio
            $sql="UPDATE tbl_tipos_de_fondos SET nombre_T_Fondo = '$nombre_T_Fondo' where ID_tipo_fondo = $ID_tipo_fondo";
            $resultado = mysqli_query($conexion,$sql);
            
                        $query = "SELECT * FROM tbl_tipos_de_fondos WHERE nombre_T_Fondo='$nombre_T_Fondo'";
        $verificacion = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($verificacion) > 0) {
            // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
            echo "<script language='JavaScript'>
                    alert('Error!!!, El tipo de Fondo ya existe');
                    location.assign('Tipo_Fondo_Adm.php');
                  </script>";
            exit; // Finaliza la ejecución del script si hay errores
        }

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('Tipo_Fondo_Adm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['nombreTFondoBitacora']=$nombre_T_Fondo;
                            $model->UPInsertTFondo();


            }else{
                echo "<script language='JavaScript'>
                alert('Error!!!, Los datos no se actualizaron');
            location.assign('Tipo_Fondo_Adm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_tipo_fondo']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_tipos_de_fondos where ID_tipo_fondo='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_tipo_fondo=$fila['ID_tipo_fondo'];
            $nombre_T_Fondo=$fila['nombre_T_Fondo'];
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Tipo de Fondo</h1>
                        </div>
                        <br>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="container">
                          <div class="row">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>ID Tipo Fondo(*):</label>
                            <input type="hidden" name="ID_Fondo" id="ID_Fondo">
                            <input oncopy="return false" style="text" type="text" class="form-control" name="ID_tipo_fondo" id="ID_tipo_fondo" maxlength="10"  value="<?php echo $ID_tipo_fondo; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Nombre del Tipo Fondo</label>
                            <input oncopy="return false" type="text" class="form-control"  name="nombre_T_Fondo" id="nombre_T_Fondo" placeholder="Ingrese el Nombre del Tipo Fondo" value="<?php echo $nombre_T_Fondo; ?>" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" require>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar_F2" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
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
    window.location.href = "Tipo_Fondo_Adm.php";
  });
}
</script>
  
</body>
</html>