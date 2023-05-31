<?php 
//Controladores importantes
 require '../../conexion_BD.php'; 
 require_once "../../EVENT_BITACORA.php";
 session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
 $ID_Proyect = $_GET['ID_proyecto'];
 $_SESSION['ID_Proyect']= $ID_Proyect;



 $sql = "SELECT Nombre_del_proyecto FROM tbl_proyectos WHERE ID_proyecto = '$ID_Proyect'";
 $resultado = mysqli_query($conexion, $sql);
 $fila = mysqli_fetch_assoc($resultado);
 
 $nombrepro = $fila['Nombre_del_proyecto'];
 $strpro = $fila ? $nombrepro : '';
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Gestion Proyectos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../css/adminlte.min.css">

  <script type="text/javascript">
    function confirmar(){
      return confirm('¿Está Seguro?, se eliminará el proyecto');
    }
  </script>
</head>

<?php include '../sidebarpro.php'; ?>

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
                          <h1 style="text-align:center; padding-top:20px; padding-bottom:25px;" class="box-title">Gestion de Proyecto <?php echo $strpro ?></h1>
                          <div class="box-tools pull-right">
                          </div>
              <!-- ################################ INICIO DE VOLUNTARIOS ##################################### -->
                          <div class="container-fluid">
                              <!-- Small boxes (Stat box) -->
                              <div class="row">
                              <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where  Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=15");
if ($datos=$sql->fetch_object()) { ?>
                                <div class="col-lg-3 col-6">
                                  <!-- small box -->
                                  <div class="small-box bg-info">
                                    <div class="inner">
                                    <?php //TABLA VOLUNTARIOS
                                      // Consulta SQL para contar la cantidad de registros en la tabla "usuarios de ese idProyecto"
                                        $sql = "SELECT COUNT(*) as Total FROM tbl_voluntarios_proyectos WHERE `ID_proyecto`=$ID_Proyect";
                                        // Ejecutar la consulta
                                        $resultado=mysqli_query($conexion,$sql);
                                        // Obtener el resultado como un array asociativo
                                        $datos = mysqli_fetch_array($resultado);
                                        $Voluntarios_cantidad = $datos['Total'];
                                      ?>
                                      <h3> <?php echo $Voluntarios_cantidad ?></h3>
                                      

                                      <p style="font-size: 15px">Voluntarios</p>
                                    </div>
                                    <div class="icon">
                                      <i class="ion-android-contacts"></i>
                                    </div>
                                    <a href="../Voluntarios/voluntarios_proyectos_Adm.php" class="small-box-footer">Informacion <i class="fas fa-arrow-circle-right"></i></a>
                                  </div>
                                </div>
                                <?php } ?>
                                <!-- ./col -->
                                <!-- ################################ INICIO DE FONDOS ##################################### -->
                                <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where  Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=7");
if ($datos=$sql->fetch_object()) { ?>
                                <div class="col-lg-3 col-6">
                                  <!-- small box -->
                                  <div class="small-box bg-success">
                                    <div class="inner">
                                    <?php //TABLA PAGOS
                                      // Consulta SQL para contar la cantidad de registros en la tabla "usuarios de ese idProyecto"
                                        $sql = "SELECT SUM(`Valor_monetario`) as Total FROM tbl_fondos WHERE `ID_Proyecto` =$ID_Proyect";
                                        // Ejecutar la consulta
                                        $resultado=mysqli_query($conexion,$sql);
                                        // Obtener el resultado como un array asociativo
                                        $datos = mysqli_fetch_array($resultado);
                                        $Fondos_cantidad = $datos['Total'];
                                        
                                      ?>
                                      <h3> <?php echo "L.". number_format($Fondos_cantidad, 2); ?></h3>
                                      <p style="font-size: 15px">Fondos</p>
                                    </div>
                                    <div class="icon">
                                      <i class="ion-arrow-graph-up-right"></i>
                                    </div>
                                    <a href="../Fondos/FondosAdm.php" class="small-box-footer">Informacion <i class="fas fa-arrow-circle-right"></i></a>
                                  </div>
                                </div>
                                <?php } ?>
                                <!-- ################################ INICIO DE PAGOS ##################################### -->
                                <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where  Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=10");
if ($datos=$sql->fetch_object()) { ?>
                                <div class="col-lg-3 col-6">
                                  <!-- small box -->
                                  <div class="small-box bg-danger">
                                    <div class="inner">
                                    <?php //TABLA PAGOS
                                      // Consulta SQL para contar la cantidad de registros en la tabla "usuarios de ese idProyecto"
                                        $sql = "SELECT SUM(`Monto_pagado`) as Total FROM tbl_pagos_realizados WHERE `ID_de_proyecto` =$ID_Proyect";
                                        // Ejecutar la consulta
                                        $resultado=mysqli_query($conexion,$sql);
                                        // Obtener el resultado como un array asociativo
                                        $datos = mysqli_fetch_array($resultado);
                                        $Pagos_Total = $datos['Total'];
                                        
                                      ?>
                                      <h3> <?php echo "L.". number_format($Pagos_Total, 2); ?></h3>

                                      <p style="font-size: 15px">Pagos</p>
                                    </div>
                                    <div class="icon">
                                      <i class="ion-cash"></i>
                                    </div>
                                    <a href="../pagos/PagosAdm.php" class="small-box-footer">Informacion <i class="fas fa-arrow-circle-right"></i></a>
                                  </div>
                                </div>
                                <?php } ?>
                                <!-- ./col -->
                                <!-- ./col -->
                                <!-- ################################ Regresar a Proyectos ##################################### -->
                                <div class="col-lg-3 col-6">
                                  <!-- small box -->
                                  <div class="small-box bg-warning">
                                    <div class="inner">
                                    <?php //TABLA PROYECTOS
                                      // Consulta SQL para contar la cantidad de registros en la tabla "usuarios de ese idProyecto"
                                        $sql = "SELECT COUNT(*) as Total FROM tbl_proyectos";
                                        // Ejecutar la consulta
                                        $resultado=mysqli_query($conexion,$sql);
                                        // Obtener el resultado como un array asociativo
                                        $datos = mysqli_fetch_array($resultado);
                                        $Proyectos_cantidad = $datos['Total'];
                                        
                                      ?>
                                      <h3> <?php echo $Proyectos_cantidad ?></h3>

                                      <p style="font-size: 15px">Proyectos</p>
                                    </div>
                                    <div class="icon">
                                      <i class="ion-android-clipboard"></i>
                                    </div>
                                    <a href="../proyectos/proyectosAdm.php" class="small-box-footer">Regresar a proyectos <i class="fas fa-arrow-circle-right"></i></a>
                                  </div>
                                </div>
                                <!-- ./col -->
                              </div>
                              <!-- /.row -->


                        <br>
                    </div>
                    <!-- /.box-header -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
		</div>
	</section>


	
	<!--script en java para los efectos-->
  <script src="../../js/Buscador.js"></script>
  <script src="../../js/events.js"></script>
 	<script src="../../js/jquery-3.1.1.min.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>