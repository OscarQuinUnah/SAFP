<?php
    include("../../conexion_BD.php");
    require_once "../../EVENT_BITACORA.php";
    
    session_start();     
    $usuario=$_SESSION['usuario'];
    $ID_Rol=$_SESSION['ID_Rol'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>
	<!--Seccion donde va toda la barra lateral -->
	<?php include '../sidebar.php'; ?>


  <?php
    if(isset($_POST['Enviar_Pregunta'])){        
        // Validar si se ha enviado el formulario
        $ID_Pregunta = mysqli_real_escape_string($conexion, $_POST["ID_Pregunta"]);
        $pregunta = mysqli_real_escape_string($conexion, $_POST["Pregunta"]);
        $Fecha_actual = date('Y-m-d');
        
        include("../../conexion_BD.php");
        
        // Validar si el campo pregunta no está vacío
        if(empty($pregunta)){
            echo"<p class='error'>* Debe colocar una Pregunta</p>";
            exit; // Finaliza la ejecución del script si hay errores
        }

        // Verificar si la pregunta ya existe en la base de datos
        $query = "SELECT * FROM tbl_preguntas WHERE Pregunta='$pregunta'";
        $verificacion = mysqli_query($conexion, $query);
        
        if (mysqli_num_rows($verificacion) > 0) {
            // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
            echo "<script language='JavaScript'>
                    alert('Error!!!, La pregunta ya existe');
                    location.assign('PreguntasAdm.php');
                  </script>";
            exit; // Finaliza la ejecución del script si hay errores
        }
        
        // Actualizar pregunta en la base de datos
        $sql = "UPDATE tbl_preguntas SET Pregunta = '$pregunta', Fecha_Modificacion='$Fecha_actual' WHERE ID_Pregunta='$ID_Pregunta';";
        $resultado = mysqli_query($conexion, $sql);

        if($resultado){
            echo "<script language='JavaScript'>
                    alert('Los datos se actualizaron correctamente');
                    location.assign('PreguntasAdm.php');
                  </script>";
            
            // Registrar en la bitácora la actualización de la pregunta
            require_once "../../EVENT_BITACORA.php";
            $model = new EVENT_BITACORA;
            session_start();
            $_SESSION['pregbitUP']=$pregunta;
            $model->RegUptpreg(); 

        } else {
            echo "<script language='JavaScript'>
                    alert('Error!, Los datos no se actualizaron');
                    location.assign('PreguntaAdm.php');
                  </script>";
        }
        
        mysqli_close($conexion);
    } else {
        // Si el usuario NO ha presionado el botón enviar, cargar la pregunta para editar
        $id = mysqli_real_escape_string($conexion, $_GET['ID_Pregunta']); // Recuperar el id que se envía desde el home.html
        $sql = "SELECT * FROM tbl_preguntas WHERE ID_Pregunta='$id'";
        $resultado = mysqli_query($conexion, $sql);

        $fila = mysqli_fetch_assoc($resultado);

        $ID_Pregunta = $fila['ID_Pregunta'];
        $Pregunta = $fila['Pregunta']; // Recuperando los datos desde la BD

        mysqli_close($conexion);
    }
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
                    <div style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-header with-border">
                          <h1 class="box-title">Editar Pregunta</h1>
                        </div>
                        <br>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="container">
                          <div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>ID Pregunta(*):</label>
                            <input type="hidden" name="ID_Pregunta" id="ID_VID_Preguntaoluntario">
                            <input oncopy="return false" onpaste="return false" class="form-control" name="ID_Pregunta" id="ID_Pregunta" value="<?php echo $ID_Pregunta; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Pregunta(*):</label>
                            <input type="hidden" name="Pregunta" id="Pregunta">
                            <input onpaste="return false" type="text" class="form-control" name="Pregunta" id="Pregunta" value="<?php echo $Pregunta; ?>" maxlength="50" placeholder="Ingrese una pregunta" oninput="this.value = this.value.toUpperCase();" onkeypress="return validarEspaciosYSignos(event)" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="Enviar_Pregunta" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
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
                        




	<!--script en java para los efectos-->
  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

  
  <script>
        function validarEspaciosYSignos(event) {
        var tecla = event.which || event.keyCode;
        var caracter = String.fromCharCode(tecla);

        // Permitir letras, espacios y signos de interrogación
        var permitidos = /^[a-zA-Z\s\?\¿]*$/;

        if (!permitidos.test(caracter)) {
            event.preventDefault();
            return false;
        }

        return true;
        }
  </script>

<script>
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
    window.location.href = "PreguntasAdm.php";
  });
}
</script>


</body>
</html>