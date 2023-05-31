<?php 
//Controladores importantes
 require '../../conexion_BD.php'; 
 require_once "../../EVENT_BITACORA.php";
 session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
 
 if (empty($_SESSION['user']) and empty($_SESSION['ID_User'])) {
    header('location:../../Pantallas/Login.php');
	exit();
 }
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
	

	<!-- Theme style -->
	<link rel="stylesheet" href="../../css/adminlte.min.css">

</head>
<style>
	.container-fluid h1{
    text-align: center;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    color: black;
    margin-top: 20px;
    margin-bottom: 20px;

	}

	.knob-label{
		font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
		font-weight: 100;
		font-size: large;
	}

	.card-header{
		background: #FF9A6E;
		font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
		font-weight: 100;
		font-size: large;


	}

	.card-header{
		background: #FF9A6E;
		font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
		font-weight: 100;
		font-size: large;


	}

	/* Modal */
	.modal {
	display: none; 
	position: fixed; 
	z-index: 1000; 
	padding-top: 20px; 
	left: 0;
	top: 0;
	width: 100%; 
	height: 100%; 
	overflow: auto; 
	background-color: rgba(0,0,0,0.4); 
	}

	/* Modal Content/Box */
	.modal-content {
	background-color: #fefefe;
	margin: auto;
	padding: 20px;
	border: 1px solid #888;
	width: 100%;
	max-width: 500px;
	border-radius: 10px;
	}

	/* Modal Header */
	.modal-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 10px 0;
	}

	/* Close Button */
	.close {
	color: #aaa;
	float: right;
	font-size: 28px;
	font-weight: bold;
	padding: 0 10px;
	}

	.close:hover,
	.close:focus {
	color: black;
	text-decoration: none;
	cursor: pointer;
	}

	/* Modal Body */
	.modal-body {
	padding: 20px 0;
	}

	/* Modal Footer */
	.modal-footer {
	display: flex;
	justify-content: flex-end;
	align-items: center;
	padding: 10px 0;
	}

	/* Buttons */
	.btn {
	border-radius: 5px;
	padding: 10px 20px;
	font-size: 18px;
	font-weight: bold;
	}

	.btn-primary {
	background-color: #007bff;
	border: none;
	color: white;
	margin-right: 10px;
	}

	.btn-primary:hover {
	background-color: #0069d9;
	}

	.btn-warning {
	background-color: #ffc107;
	border: none;
	color: white;
	}

	.btn-warning:hover {
	background-color: #e0a800;
	}


</style>


<body >


<section><!-- INICIO DEL MENSAJE MODAL_______________________________________ -->
    <?php
    // Obtener la fecha de vencimiento de la tabla de usuario
    $sql = "SELECT Fecha_Vencimiento FROM tbl_ms_usuario WHERE Usuario='$usuario'";
    $resultado = mysqli_query($conexion, $sql);
    $fecha_vencimiento = mysqli_fetch_assoc($resultado)['Fecha_Vencimiento'];

    // Comparar la fecha de vencimiento con la fecha actual
    $fecha_actual = date("Y-m-d");
    if ($fecha_vencimiento < $fecha_actual) {
        // Si la fecha de vencimiento ha pasado, actualizar el estado del usuario a "inactivo" en la base de datos
        $sql1 = "UPDATE tbl_ms_usuario SET Estado_Usuario = 'INACTIVO' WHERE Usuario='$usuario'";
        mysqli_query($conexion, $sql1);
		session_unset(); // Clear all session variables
		session_destroy();// Destroy the session  
		echo "<script languaje='JavaScript'>
		alert('Tu contraseña ha expirado, contacese con uno de los Administradores');
		location.assign('../../Pantallas/Login.php');
		</script>"; 
        exit;

    } else if (date_diff(date_create($fecha_actual), date_create($fecha_vencimiento))->days < 7) {
        // Si la fecha de vencimiento está próxima y el modal no se ha mostrado antes, mostrar un mensaje modal de advertencia utilizando JavaScript y Bootstrap
        if (!isset($_SESSION['modalShown'])) {
            echo "<script>
            window.onload = function() {
                // Obtener la modal
                var modal = document.getElementById('myModal');

                // Mostrar la modal
                modal.style.display = 'block';

                // Cuando el usuario hace clic fuera del modal, cerrarlo y establecer la variable de sesión
            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
                // Enviar una petición al servidor para establecer la variable de sesión
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'setModalShown.php', true);
                xhr.send();
            }
            }
        }
        </script>";

        }
    }
?>

 
    <!-- The Modal -->
    <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">¡Atención!</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
            <p>Tu contraseña está próxima a expirar.</p>
            <p>Por favor, actualízala para mantener tu cuenta segura.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button id="cancelBtn" type="button" class="btn btn-primary" onclick="location.href='../conf/gestion.php'">Actualizar</button>
            <button id="updateBtn" type="button" class="btn btn-warning" data-dismiss="modal" onclick="closeModal()">Más tarde</button>
        </div>
        </div>
    </div>
    </div>

    <script>
    function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
    }
    </script>
</section><!-- FIN DEL MENSAJE MODAL_______________________________________ -->


<!--+Barra lateral -->
	<?php include '../sidebar.php'; ?>

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
		<div style="background: rgb(1,5,36);
			background: linear-gradient(125deg, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 49%, rgba(1,5,36,1) 100%);" class="container-fluid" class="full-box cover dashboard-sideBar" style="overflow-y: auto;">
			<h1 class="panel_informativo">Panel Informativo</h1>
			 <!-- Main content -->
		</div>
			 <section class="content">

	<!-- Contador de registros -->
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
          <div class="col-12">
            <!-- jQuery Knob -->
            <div style="margin-top: 30px;" class="card">
              <div class="card-header" style="background: #A0FF6A;">
                <h3 class="card-title"><i class="zmdi zmdi-bookmark"></i> Registros</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-6 col-md-3 text-center">
					<?php //TABLA USUARIO
					// Consulta SQL para contar la cantidad de registros en la tabla "usuario"
						$sql = "SELECT COUNT(*) as total FROM tbl_ms_usuario";
						// Ejecutar la consulta
						$resultado=mysqli_query($conexion,$sql);
						// Obtener el resultado como un array asociativo
						$datos = mysqli_fetch_array($resultado);
						$Usuario_cantidad = $datos['total'];
					?>
                    <input type="text" class="knob" value="<?php echo $Usuario_cantidad; ?>" data-width="90" data-height="90" data-fgColor="#3c8dbc" data-readonly="true">
                    <div class="knob-label">Usuarios</div>
                  </div>
                  <!-- ./col -->

                  <div class="col-6 col-md-3 text-center">
					<?php //TABLA PROYECTOS
						// Consulta SQL para contar la cantidad de registros en la tabla "usuario"
							$sql = "SELECT COUNT(*) as total FROM tbl_proyectos";
							// Ejecutar la consulta
							$resultado=mysqli_query($conexion,$sql);
							// Obtener el resultado como un array asociativo
							$datos = mysqli_fetch_array($resultado);
							$Proyecto_cantidad = $datos['total'];
						?>
                    <input type="text" class="knob" value="<?php echo $Proyecto_cantidad; ?>" data-width="90" data-height="90"data-fgColor="#f56954" data-readonly="true">

                    <div class="knob-label">Proyectos</div>
                  </div>
                  <!-- ./col -->

                  <div class="col-6 col-md-3 text-center">
				  <?php //TABLA DONACIONES
						// Consulta SQL para contar la cantidad de registros en la tabla "usuario"
							$sql = "SELECT COUNT(*) as total FROM tbl_donantes";
							// Ejecutar la consulta
							$resultado=mysqli_query($conexion,$sql);
							// Obtener el resultado como un array asociativo
							$datos = mysqli_fetch_array($resultado);
							$Donantes_cantidad = $datos['total'];
						?>
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $Donantes_cantidad; ?>" data-width="90" data-height="90" data-fgColor="#00a65a">
                    <div class="knob-label">Donantes</div>
                  </div>
                  <!-- ./col -->

                  <div class="col-6 col-md-3 text-center">
				  <?php //TABLA VOLUNTARIOS
						// Consulta SQL para contar la cantidad de registros en la tabla "usuario"
							$sql = "SELECT COUNT(*) as total FROM tbl_voluntarios";
							// Ejecutar la consulta
							$resultado=mysqli_query($conexion,$sql);
							// Obtener el resultado como un array asociativo
							$datos = mysqli_fetch_array($resultado);
							$Voluntarios_cantidad = $datos['total'];
						?>
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $Voluntarios_cantidad; ?>" data-width="90" data-height="90" data-fgColor="#00c0ef">
                    <div class="knob-label">Voluntarios</div>
                  </div>

				  <div class="col-6 text-center">
				  <?php //TABLA SAR
						// Consulta SQL para contar la cantidad de registros en la tabla "sar"
							$sql = "SELECT COUNT(*) as total FROM tbl_r_sar";
							// Ejecutar la consulta
							$resultado=mysqli_query($conexion,$sql);
							// Obtener el resultado como un array asociativo
							$datos = mysqli_fetch_array($resultado);
							$Sar_cantidad = $datos['total'];
						?>
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $Sar_cantidad; ?>" data-width="90" data-height="90" data-fgColor="#DBDF37">
                    <div class="knob-label">SAR</div>
                  </div>
                  <!-- ./col -->
				  <div class="col-6 text-center">
				  <?php //TABLA Pagos
						// Consulta SQL para contar la cantidad de registros en la tabla "pagos"
							$sql = "SELECT COUNT(*) as total FROM tbl_pagos_realizados";
							// Ejecutar la consulta
							$resultado=mysqli_query($conexion,$sql);
							// Obtener el resultado como un array asociativo
							$datos = mysqli_fetch_array($resultado);
							$pagos_cantidad = $datos['total'];
						?>
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $pagos_cantidad; ?>" data-width="90" data-height="90" data-fgColor="#DF37CF">
                    <div class="knob-label">Pagos</div>
                  </div>

                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
   	</div>

	<div><!-- FONDOS -->
			<!-- jQuery Knob -->
			<div style="margin-top: 30px;" class="card">
				<div class="card-header" style="background: #A0FF6A;">
					<h3 class="card-title"><i class="zmdi zmdi-money"></i> Fondos</h3>
				</div>
					<?php
						// Consulta SQL para obtener los datos
						require '../../conexion_BD.php'; 
						$sql = "SELECT `Fecha_de_adquisicion_F`, SUM(`Valor_monetario`) AS Total_Fondos FROM tbl_fondos GROUP BY `Fecha_de_adquisicion_F`;";

						// Ejecutar la consulta
						$resultado = mysqli_query($conexion, $sql);

						// Formatear los datos en formato JSON
						$data = array();
						while ($fila = mysqli_fetch_assoc($resultado)) {
						$data[] = array('Fecha_de_adquisicion_F' => $fila['Fecha_de_adquisicion_F'], 'Total_Tondos' => $fila['Total_Fondos']);
						}
						$json_data = json_encode($data);

						// Crear el gráfico de barras utilizando Chart.js
					?>
					<canvas id="grafico" height="350"></canvas>
		</div>

	</div>

	<div><!-- PROYECTOS POR CATEGORIA -->
			<!-- jQuery Knob -->
			<div style="margin-top: 30px;" class="card">
				<div class="card-header" style="background: #A0FF6A;">
					<h3 class="card-title"><i class="zmdi zmdi-chart-donut"></i> Proyectos por Categoria</h3>
				</div>
					<?php
						// Consulta SQL para obtener los datos
						require '../../conexion_BD.php'; 
						$sql2 = "SELECT `Estado_Proyecto`, COUNT(*) as Cantidad FROM tbl_proyectos GROUP BY `Estado_Proyecto`;";

						// Ejecutar la consulta
						$resultado = mysqli_query($conexion, $sql2);

						// crear dos arreglos con los datos
                        $estados = [];
                        $cantidades = [];

                        while ($fila = mysqli_fetch_assoc($resultado)) {
                        $estados[] = $fila['Estado_Proyecto'];
                        $cantidades[] = $fila['Cantidad'];
                        }

                        // generar el gráfico circular

					?>
						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
					<canvas id="grafico_cant_proyectos" height="200"></canvas>	
		</div>
	</div>

	<div><!-- PROYECTOS POR NOMBRE Y LOS FONDOS DESTINADOS -->
			<!-- jQuery Knob -->
			<div style="margin-top: 30px;" class="card">
				<div class="card-header" style="background: #A0FF6A;">
					<h3 class="card-title"><i class="zmdi zmdi-chart"></i> Proyectos</h3>
				</div>
					<?php
						// Consulta SQL para obtener los datos
						require '../../conexion_BD.php'; 
						// Consulta SQL para obtener los datos
						$sql2 = "SELECT `Nombre_del_proyecto`, `Fecha_Creacion`, `Fondos_proyecto` FROM tbl_proyectos WHERE `Estado_Proyecto` = 'activo' ORDER BY `Fecha_Creacion` ASC;";

						// Ejecutar la consulta
						$resultado = mysqli_query($conexion, $sql2);

						// Crear arrays para los datos del gráfico
						$labels = [];
						$data = [];

						while ($row = mysqli_fetch_assoc($resultado)) {
							$labels[] = $row['Fecha_Creacion'];
							$data[] = $row['Fondos_proyecto'];
							$nombre[] = $row['Nombre_del_proyecto'];
						}

						// Crear el gráfico utilizando Chart.js
					?>
						
					<canvas id="grafico_proyectos" height="350" ></canvas>	
		</div>
	</div>
	
	</section>

	


	
	<!--script en java para los efectos-->
	<script src="../../js/usuario.js"></script>
	<script src="../../js/jquery-3.1.1.min.js"></script>
	<script src="../../js/main.js"></script>
	<script src="../../js/jquery.knob.min.js"></script><!-- jQuery Knob -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


	<!-- Para los graficos de dona-->
	<script>
		$(function () {
			/* jQueryKnob */

			$('.knob').knob({
			draw: function () {
			}
			})
		})

	</script>

	<!-- Para el grafico lineal del total de fondos-->
	<script>
        var data = <?php echo $json_data; ?>;
        var labels = [];
        var valores = [];
        data.forEach(function(item) {
            labels.push(item.Fecha_de_adquisicion_F);
            valores.push(item.Total_Tondos);
        });
        var ctx = document.getElementById("grafico").getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad de Fondos por Fecha',
                    data: valores,
					fill: false,
                    borderColor: 'rgba(4, 113, 163, 0.61)',
                    tension: 0.1 
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Fecha'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Cantidad de Fondos'
                        }
                    }]
                }
            }
        });
    </script>

	<!-- Para el grafico circular de las categorias de proyectos-->
	<script>
		var ctx = document.getElementById('grafico_cant_proyectos').getContext('2d');
		var grafico = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: <?php echo json_encode($estados); ?>,
			datasets: [{
			data: <?php echo json_encode($cantidades); ?>,
			backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)'
			],
			
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)'
			],
			borderWidth: 1,

			}]
		},
		options: {
			maintainAspectRatio: true,
			layout: {
			padding: {
				bottom: 20
			}
			}
		}
		});
	</script>

	<!-- Para el grafico circular de los fondos de proyectos-->
	<script>
			var ctx = document.getElementById('grafico_proyectos').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($nombre); ?>,
					datasets: [{
						label: 'Cantidad de fondos',
						data: <?php echo json_encode($data); ?>,
						backgroundColor: 'rgba(0, 156, 21, 0.76)',
						borderColor: 'rgba(82, 5, 0, 1)',
						borderWidth: 1
					}]
				},
				options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Proyectos Activos'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Fondos'
                        }
                    }]
                }
            }
        });
	</script>

	
</body>
</html>