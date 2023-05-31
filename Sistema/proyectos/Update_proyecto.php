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

<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>

<?php include '../sidebar.php'; ?>

    <?php
        if(isset($_POST['enviar'])){
            //aqui entra si el usuario ha presionado el boton enviar
            
            $Usuario=$_SESSION['usuario'];      
    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $ID_Usuario=$row['ID_Usuario'];
    }
    $ID_proyecto =$_POST["proyecto"];
    $nomb_proyec=$_POST["Nombre_proyecto"];
    $Fecha_ini=$_POST["Fechaini"];
    $Fecha_final=$_POST["Fechafinal"];
    $Fondos_proyec=$_POST["Monto_proyectados"];
    $estado=$_POST["estado"];
    $Fecha_actual = date('Y-m-d');

            //si lo que esta en el form esta vacio
            $sql="UPDATE tbl_proyectos SET ID_Usuario=$ID_Usuario, Nombre_del_proyecto='$nomb_proyec', Fecha_de_inicio_P='$Fecha_ini' ,Fecha_final_P='$Fecha_final', Fondos_proyecto  =$Fondos_proyec, Estado_Proyecto = '$estado', Modificado_por= '$Usuario', Fecha_Modificacion = '$Fecha_actual' where ID_proyecto = $ID_proyecto";
            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('proyectosAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['projectBitacora']=$nomb_proyec;
                            $model->UPTProjec(); 

            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('proyectosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_proyecto']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_proyectos where ID_proyecto='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_proyecto=$fila['ID_proyecto'];
            $nomb_proyec=$fila['Nombre_del_proyecto'];
            $Fecha_ini=$fila['Fecha_de_inicio_P'];
            $Fecha_final=$fila['Fecha_final_P'];
            $Fondos_proyec=$fila['Fondos_proyecto'];
            $estado=$fila['Estado_Proyecto'];
            
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Proyectos</h1>
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
                            <label>Id proyecto(*):</label>
                            <input type="hidden" name="proyecto" id="proyecto">
                            <input type="text" class="form-control" name="proyecto" id="proyecto" maxlength="100" placeholder="Ingrese el id proyecto" value="<?php echo $ID_proyecto; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre del proyecto(*):</label>
                            <input type="hidden" name="Nombre_proyecto" id="Nombre_proyecto">
                            <input type="text" class="form-control" name="Nombre_proyecto" id="Nombre_proyecto" maxlength="100" placeholder="Ingrese el nombre del proyecto:" value="<?php echo $nomb_proyec; ?>"  oninput="this.value = this.value.toUpperCase();" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Fecha de Inicio:</label>
                            <input type="date" class="form-control" name="Fechaini" id="Fechaini" maxlength="100" placeholder="Ingrese la Fecha de inicio" value="<?php echo $Fecha_ini; ?>">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Fecha final:</label>
                          <input type="date" class="form-control" name="Fechafinal" id="Fechafinal" maxlength="100" placeholder="Ingrese la Fecha final" min="<?= date('Y-m-d') ?>" value="<?php echo $Fecha_final; ?>">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Fondos proyectados(*):</label>
                            <input type="hidden" name="Monto_proyectados" id="Monto_proyectados">
                            <input style="text" type="text" class="form-control" name="Monto_proyectados" id="Monto_proyectados" maxlength="10"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" placeholder="Ingrese los fondos proyectados:" value="<?php echo $Fondos_proyec; ?>"required>
                          </div>
                        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Estado usuario(*)</label>
                            <select class="form-control" name="estado" id="estado" required>
                              <option value="">Seleccione un estado</option>
                              <option value="ACTIVO" <?php if ($estado == 'ACTIVO') echo 'selected'; ?>>ACTIVO</option>
                              <option value="INACTIVO" <?php if ($estado == 'INACTIVO') echo 'selected'; ?>>INACTIVO</option>
                              <option value="FINALIZADO" <?php if ($estado == 'FINALIZADO') echo 'selected'; ?>>FINALIZADO</option>
                            </select>
                          </div>
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
    window.location.href = "proyectosAdm.php";
  });
}
</script>
</script>
<script>
  const fechaInicial = document.getElementById('Fechaini');
  const fechaFinal = document.getElementById('Fechafinal');

  fechaInicial.addEventListener('change', () => {
    if (fechaInicial.value > fechaFinal.value) {
      fechaFinal.value = fechaInicial.value;
    }
    fechaFinal.min = fechaInicial.value;
  });
</script>
	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>