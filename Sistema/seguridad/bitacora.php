<?php

require '../../conexion_BD.php';
include("../../EVENT_BITACORA.php");
$model = new EVENT_BITACORA;
session_start();
$model->entrarbitacora();
$usuario=$_SESSION['user'];
$ID_Rol=$_SESSION['ID_Rol'];

if (empty($_SESSION['user']) and empty($_SESSION['ID_User'])) {
    header('location:../../Pantallas/Login.php');
	exit();
 }

// Definir la página actual. Si $_GET['pagina'] no está definido, se establece en 1
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';


?>
                      
<!DOCTYPE html>
<html lang="es">
<head>

	<title>Inicio</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


</head>
<body>
<body>
<?php include '../sidebar.php'; ?>
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Bitacora</h1>
                          <!-- PARA GENERAR LOS REPORTES ====================== -->
                          <button class="btn btn-warning" id="generar-reporte" name="generar-reporte" onclick="window.open('../../fpdf/ReporteBitacora.php?campo=' + encodeURIComponent(document.getElementById('campo').value), '_blank')" >
                         <i class="zmdi zmdi-collection-pdf"></i> Generar Reporte Bitacora
                          </button>            
                <!-- Fin Generar Reporte -->
    <main>
        <div class="container py-4 text-center">
            
            <div class="row g-4">

                <div class="col-auto">
                    <label for="num_registros" class="col-form-label">Mostrar: </label>
                </div>

                <div class="col-auto">
                    <select name="num_registros" id="num_registros" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                
                <div class="col-auto">
                    <label for="num_registros" class="col-form-label">registros </label>
                </div>
                <div class="col-5"></div>
                <div class="col-auto">
                    <label for="campo" class="col-form-label">Buscar: </label>
                </div>
                <div class="col-auto">
                    <input type="text" name="campo" id="campo" class="form-control">
                </div>
                <div class="col-auto">
                <label for="fechaInicio" class="col-form-label">Fecha Inicio </label>
</div>
                <div class="col-auto">
                <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
</div>
<div class="col-auto">
<label for="fechaFinal" class="col-form-label">Fecha Final </label>
</div>
<div class="col-auto">
<input type="date" name="fechaFinal" id="fechaFinal" class="form-control">
</div>
            </div>
            <script>
document.getElementById("campo").addEventListener("keyup", function(event) {
  // Obtener el valor del input
  var campo = document.getElementById("campo").value;
  // Actualizar el valor del enlace
  var link = document.getElementById("generar-reporte");
  link.setAttribute("href", "../../fpdf/ReporteBitacora.php?campo=" + encodeURIComponent(campo));
});
  </script>
            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th class="sort asc">ID</th>
                            <th class="sort asc">Fecha</th>
                            <th class="sort asc">Usuario</th>
                            <th class="sort asc">Objeto</th>
                            <th class="sort asc">Accion</th>
                            <th class="sort asc">Descripcion</th>
                        </thead>

                        <!-- El id del cuerpo de la tabla. -->
                        <tbody id="content">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label id="lbl-total"></label>
                </div>

                <div class="col-6" id="nav-paginacion"></div>

                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
            </div>
        </div>
    </main>

    <script>
        /* Llamando a la función getData() */
        getData()

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campo").addEventListener("keyup", function() {
    getData()
}, false)
document.getElementById("fechaInicio").addEventListener("change", function() {
    getData();
}, false);
document.getElementById("fechaFinal").addEventListener("change", function() {
    if (document.getElementById("fechaFinal").value == '') {
        document.getElementById("fechaFinal").value = document.getElementById("fechaInicio").value= null;
        getData();
    } else {
        getData();
    }
}, false);

document.getElementById("num_registros").addEventListener("change", function() {
    getData()
}, false)

        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
    let num_registros = document.getElementById("num_registros").value
    let content = document.getElementById("content")
    let pagina = document.getElementById("pagina").value
    let orderCol = document.getElementById("orderCol").value
    let orderType = document.getElementById("orderType").value
    let fechaInicio = document.getElementById("fechaInicio").value // Nueva variable
    let fechaFinal = document.getElementById("fechaFinal").value // Nueva variable

    if (pagina == null) {
        pagina = 1
    }

    let url = "Gestor_tbl_Bitacora.php"
    let formaData = new FormData()
    formaData.append('campo', input)
    formaData.append('registros', num_registros)
    formaData.append('pagina', pagina)
    formaData.append('orderCol', orderCol)
    formaData.append('orderType', orderType)
    formaData.append('fechaInicio', fechaInicio) // Nueva variable
    formaData.append('fechaFinal', fechaFinal) // Nueva variable


            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err))
        }

        function nextPage(pagina){
            document.getElementById('pagina').value = pagina
            getData()
        }

        let columns = document.getElementsByClassName("sort")
        let tamanio = columns.length
        for(let i = 0; i < tamanio; i++){
            columns[i].addEventListener("click", ordenar)
        }

        function ordenar(e){
            let elemento = e.target

            document.getElementById('orderCol').value = elemento.cellIndex

            if(elemento.classList.contains("asc")){
                document.getElementById("orderType").value = "asc"
                elemento.classList.remove("asc")
                elemento.classList.add("desc")
            } else {
                document.getElementById("orderType").value = "desc"
                elemento.classList.remove("desc")
                elemento.classList.add("asc")
            }

            getData()
        }

    </script>
<!--Fin centro -->
</div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
		</div>
	</section>
    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<!--script en java para los efectos-->

  <script src="../../js/events.js"></script>
 	<script src="../../js/jquery-3.1.1.min.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>
</body>
</html>