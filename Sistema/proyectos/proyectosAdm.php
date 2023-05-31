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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script type="text/javascript">
    function confirmar(){
      return confirm('¿Está Seguro?, se eliminará el proyecto');
    }
  </script>
</head>

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
		<div class="container-fluid">
        <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Gestion Proyectos</h1>
                          <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Insercion=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) { ?>
                          <button class="btn btn-success" id="btnagregar" name="btnAgregar" onclick="mostrarform(true)"><i class="zmdi zmdi-calendar-note"></i> Agregar Proyecto</button>
                          <!-- PARA GENERAR LOS REPORTES ====================== -->
                          <button class="btn btn-warning" id="generar-reporte" name="generar-reporte" onclick="window.open('../../fpdf/Reporteproyec.php?campo=' + encodeURIComponent(document.getElementById('campo').value), '_blank')" >
                         <i class="zmdi zmdi-collection-pdf"></i> Generar Reporte Proyectos
                          </button>
                <!-- Fin Generar Reporte -->
                          <div class="box-tools pull-right">
                            <?php } ?>
                        </div>
                        <br>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_consultar=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) { ?>
<div class="panel-body" id="listadoregistros">
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
    // Actualizar el valor del botón
    var btn = document.getElementById("generar-reporte");
    btn.onclick = function() {
      window.open('../../fpdf/Reporteproyec.php?campo=' + encodeURIComponent(campo), '_blank');
    };
  });
</script>
  

            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th class="sort asc">ID</th>
                            <th class="sort asc">Proyecto</th>
                            <th class="sort asc">Fecha de Inicio</th>
                            <th class="sort asc">Fecha de finalización</th>
                            <th class="sort asc">Fondos proyectados</th>
                            <th class="sort asc">Estado Proyecto</th>

                            <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) {?>
                            <th></th>
                            <?php } ?>
                            <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) { ?>
                            <th></th>
                            <?php } ?>
                            <th></th>
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
</div>
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
            let url = "Gestion_tbl_proyectos.php"
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

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php } ?>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" action="insertproyec.php" method="POST">
                        <div class="container">
                          <div class="row">
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre del proyecto(*):</label>
                            <input type="hidden" name="Nombre_proyecto" id="Nombre_proyecto">
                            <input type="text" class="form-control" name="Nombre_proyecto" id="Nombre_proyecto" maxlength="100" placeholder="Ingrese el nombre del proyecto:"  oninput="this.value = this.value.toUpperCase();"  onkeypress="return /[a-zA-Z\s]/i.test(event.key)" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Fecha de Inicio:</label>
                          <input type="date" class="form-control" name="Fechaini" id="Fechaini" maxlength="100" placeholder="Ingrese la Fecha de inicio">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Fecha final:</label>
                          <input type="date" class="form-control" name="Fechafinal" id="Fechafinal" maxlength="100" placeholder="Ingrese la Fecha final" min="<?= date('Y-m-d') ?>">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Fondos proyectados(*):</label>
                            <input type="hidden" name="Monto_proyectados" id="Monto_proyectados">
                            <input style="text" type="text" class="form-control" name="Monto_proyectados" id="Monto_proyectados" maxlength="10" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" oninput="this.value = this.value.replace(/(\.\d*)\./g, '$1')" placeholder="Ingrese los fondos proyectados:" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Estado:</label>
                            <select class="form-control" name="estado" id="estado" required>
                              <option value="">Selecione un estado</option>
                              <option value="ACTIVO">ACTIVO</option>
                              <option value="INACTIVO">INACTIVO</option>
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



  <script src="../../js/Buscador.js"></script>
  <script src="../../js/events.js"></script>
 	<script src="../../js/jquery-3.1.1.min.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>