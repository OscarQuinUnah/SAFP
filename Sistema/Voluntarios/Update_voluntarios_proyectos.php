<?php
    include("../../conexion_BD.php");
    session_start();
    $usuario=$_SESSION['usuario'];
    $IDProyecto=$_SESSION['ID_Proyect'];
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

    <?php
        if(isset($_POST['enviar_F2'])){   
          $Fecha_actual = date('Y-m-d');
          $ID_Vinculacion_Proy=$_POST["ID_Vinculacion_Proy"];
          $ID_Voluntario=$_POST["ID_Voluntario"];
          $ID_proyecto=$IDProyecto;
          $ID_Area_Trabajo=$_POST["ID_Area_Trabajo"];
          $Fecha_Vinculacion_P=$_POST["Fecha_Vinculacion_P"];
            //si lo que esta en el form esta vacio
            $sql="UPDATE tbl_voluntarios_proyectos SET ID_Voluntario=$ID_Voluntario,ID_proyecto=$ID_proyecto,ID_Area_Trabajo=$ID_Area_Trabajo,Fecha_Vinculacion_P='$Fecha_Vinculacion_P', Modificado_por='$usuario', Fecha_Modificacion='$Fecha_actual'   where ID_Vinculacion_Proy = $ID_Vinculacion_Proy";
            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('voluntarios_proyectos_Adm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['IDvolproBitacora']=$ID_Vinculacion_Proy;
                            $model->UPVOLPRO();  
 

            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('voluntarios_proyectos_Adm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Vinculacion_Proy']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_voluntarios_proyectos where ID_Vinculacion_Proy='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);
            $ID_Vinculacion_Proy=$fila["ID_Vinculacion_Proy"];
          $ID_Voluntario=$fila["ID_Voluntario"];
          $ID_proyecto=$fila["ID_proyecto"];
          $ID_Area_Trabajo=$fila["ID_Area_Trabajo"];
          $Fecha_Vinculacion_P=$fila["Fecha_Vinculacion_P"];
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar la Vinculacion de Voluntarios a Proyecto</h1>
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
                          <label>	ID de Vinculacion:</label>
                            <input type="text" class="form-control" name="ID_Vinculacion_Proy" id="ID_Vinculacion_Proy" value="<?php echo $ID_Vinculacion_Proy; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Proyecto al que se esta vinculando:</label>
                            <?php include("../../conexion_BD.php");
                            $sql1=$conexion->query("SELECT * FROM `tbl_proyectos` WHERE ID_proyecto='$IDProyecto'");

                             while($row=mysqli_fetch_array($sql1)){
                             $Nombre_del_proyecto=$row['Nombre_del_proyecto'];
                            }?>
                            <input type="text" class="form-control"  name="Proyecto" id="Proyecto" placeholder="<?php echo $Nombre_del_proyecto?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Voluntario</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_voluntarios");
                            ?>
                            <select class="form-control" name="ID_Voluntario" id="ID_Voluntario" required>
                            <option value="">Seleccione un voluntario</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_Voluntario'] == $ID_Voluntario) ? 'selected' : '';
                            echo "<option value='".$row1['ID_Voluntario']."' ".$selected.">".$row1['Nombre_Voluntario']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Area de trabajo:</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_area_trabajo WHERE  ID_Area_Trabajo NOT IN (SELECT ID_Area_Trabajo FROM tbl_voluntarios_proyectos WHERE ID_Voluntario = $ID_Voluntario and ID_proyecto=$IDProyecto AND ID_Area_Trabajo <> $ID_Area_Trabajo)");
                            ?>
                            <select class="form-control" name="ID_Area_Trabajo" id="ID_Area_Trabajo" required>
                            <option value="">Seleccione el area de trabajo</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_Area_Trabajo'] == $ID_Area_Trabajo) ? 'selected' : '';
                            echo "<option value='".$row1['ID_Area_Trabajo']."' ".$selected.">".$row1['nombre_Area_Trabajo']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Fecha de Vinculacion de Proyectos:</label>
                            <input type="date" class="form-control" name="Fecha_Vinculacion_P" id="Fecha_Vinculacion_P" value="<?php echo $Fecha_Vinculacion_P; ?>" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar_F2" value="AGREGAR"><i class="zmdi zmdi-download"></i> Guardar</button>
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
    window.location.href = "voluntarios_proyectos_Adm.php";
  });
}
</script>
	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="./js/usuario.js"></script>
  <?php include '../sidebarpro.php'; ?>
</body>
</html>