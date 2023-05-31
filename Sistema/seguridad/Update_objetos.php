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


            //$ID_SAR = $_POST['id_sar'];
            $idObje = $_POST['idObj'];
            $objeto = $_POST['objeto'];
            $descripcion = $_POST['descripcion'];
            $tipoObj = $_POST['tipoObj'];

            $query = "SELECT * FROM tbl_objetos WHERE Objeto='$objeto'";
                    $verificacion = mysqli_query($conexion, $query);
                    
                    if (mysqli_num_rows($verificacion) > 0) {
                        // La pregunta ya existe, mostrar mensaje de error y redirigir al usuario
                        echo "<script language='JavaScript'>
                                alert('Error!!!, El Objeto ya existe');
                                location.assign('ObjetosAdm.php');
                              </script>";
                        exit; // Finaliza la ejecución del script si hay errores
                    }

            $sql = "UPDATE tbl_objetos SET Objeto = '$objeto', Descripcion = '$descripcion', Tipo_Objeto = '$tipoObj' WHERE ID_Objeto = $idObje;";

            $resultado=mysqli_query($conexion,$sql);



            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('ObjetosAdm.php');
                    </script>";          
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                    session_start();
                    $_SESSION['OBJBitacora']=$objeto;
                    $model->UPObj();
   
            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('ObjetosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id_objeto=$_GET['ID_Objeto']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_objetos where ID_Objeto = $id_objeto";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $IDobj = $fila['ID_Objeto'];
            $objeto = $fila['Objeto'];
            $descripcion = $fila['Descripcion'];
            $tipo_objeto = $fila['Tipo_Objeto'];

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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Objetos</h1>
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
                            <label>OBJETO(*):</label>
                            <input type="hidden" name="idObj" id="idObj" value="<?php echo $IDobj ?>">
                            <input type="text" class="form-control" name="objeto" id="objeto" maxlength="40" placeholder="Ingrese el Numero de declaracion" value="<?php echo $objeto?>"  oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>DESCRIPCION(*):</label>
                            <input type="hidden" name="descripcion" id="descripcion">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="descripcion" id="descripcion" maxlength="100" value="<?php echo $descripcion ?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>TIPO DE OBJETO(*):</label>
                            <input type="hidden" name="tipoObj" id="tipoObj">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="tipoObj" id="tipoObj" maxlength="50" value="<?php echo $tipo_objeto?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <input type="hidden" name="id" value="<?php echo $id_sar; ?>">

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar" value="AGREGAR"><i class="zmdi zmdi-download"></i> Guardar</button>
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
    window.location.href = "ObjetosAdm.php";
  });
}
</script>

	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>