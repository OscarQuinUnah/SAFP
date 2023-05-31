<?php


require '../../conexion_BD.php';
/*esta variable impide que se pueda entrar al sistema principal si no se entra por login (crea un usuario global) */

require_once "../../EVENT_BITACORA.php";


session_start();     
$usuario=$_SESSION['user'];
$ID_Rol=$_SESSION['ID_Rol'];

if (empty($_SESSION['user']) and empty($_SESSION['ID_User'])) {
  header('location:../../Pantallas/Login.php');
exit();
}
//Parte 2
                
$R_Fecha_actual = date('Y-m-d');       /*obtiene la fecha actual*/


$sql1=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE ID_Parametro=7");

    while($row=mysqli_fetch_array($sql1)){
    $diasV=$row['Valor'];
    }
$R_F_Vencida= date("Y-m-j",strtotime($R_Fecha_actual."+ ".$diasV." days")); /*le suma 1 mes a la fecha actual*/
//fin parte 2


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
      return confirm('¿Está Seguro?, se eliminará el registro');
    }
  </script>

</head>
<body>
	<!--Seccion donde va toda la barra lateral -->
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Gestion SAR</h1>
                          <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Insercion=1 and ID_Rol=$ID_Rol and ID_Objeto=11 ");
if ($datos=$sql->fetch_object()) { ?>
                          <button class="btn btn-success" id="btnagregar" name="btnAgregar" onclick="mostrarform(true)"><i class="zmdi zmdi-file-text"></i> Agregar Datos</button>
                          <button class="btn btn-warning" id="generar-reporte" name="generar-reporte" onclick="window.open('../../fpdf/ReporteSAR.php?campo=' + encodeURIComponent(document.getElementById('campo').value), '_blank')" >
                         <i class="zmdi zmdi-collection-pdf"></i> Generar Reporte SAR
                          <div class="box-tools pull-right">
                            <?php } ?>
                        </div>
                        <br>
                    </div>
<!-- ================================================ -->
                    <!-- /.box-header -->
                    <!-- centro -->
                    <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_consultar=1 and ID_Rol=$ID_Rol and ID_Objeto=11");
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
      window.open('../../fpdf/ReporteSAR.php?campo=' + encodeURIComponent(campo), '_blank');
    };
  });
  </script>
            <div class="row py-4">
                <div class="col">
                <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th class="sort asc">ID SAR</th>
                            <th class="sort asc">RTN</th>
                            <th class="sort asc">Numero de Declaracion</th>
                            <th class="sort asc">Tipo de Declaracion</th>
                            <th class="sort asc">Nombre o Razon Social</th>
                            <th class="sort asc">Monto</th>
                            <th class="sort asc">Departamento</th>
                            <th class="sort asc">Municipio</th>
                            <th class="sort asc">Barrio o Colonia</th>
                            <th class="sort asc">Calle o avenida</th>
                            <th class="sort asc">Numero de Casa</th>
                            <th class="sort asc">Bloque</th>
                            <th class="sort asc">Tel. Fijo</th>
                            <th class="sort asc">Tel. Celular</th>
                            <th class="sort asc">Domicilio</th>
                            <th class="sort asc">Correo</th>
                            <th class="sort asc">Profesion u Oficio</th>
                            <th class="sort asc">CAI</th>
                            <th class="sort asc">Fecha Limite de Emision</th>
                            <th class="sort asc">Numero Inicial</th>
                            <th class="sort asc">Numero Final</th>
                            <th class="sort asc">Acciones</th>
                            <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=11");
if ($datos=$sql->fetch_object()) { ?>
                            <th></th>
                            <?php } ?>
                            <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=11");
if ($datos=$sql->fetch_object()) { ?>
                            <th></th>
                            <?php } ?>
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
            let url = "Gestion_tbl_SAR.php"
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
                        <form name="formulario" id="formulario" action="Insert_SAR.php" method="POST">
                        <div class="container">
                          <div class="row">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>RTN(*):</label>
                            <input type="hidden" name="rtn" id="rtn">
                            <input type="text" class="form-control" name="rtn" id="rtn" maxlength="14" placeholder="Ingrese el RTN" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero de declaracion(*):</label>
                            <input type="hidden" name="numDeclaracion" id="numDeclaracion">
                            <input type="text" class="form-control" name="numDeclaracion" id="numDeclaracion" maxlength="11" placeholder="Ingrese el Numero de declaracion" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de declaracion(*):</label>
                              <select class="form-control" name="tipoDeclaracion" id="tipoDeclaracion" required>
                                <option value="">Selecione un tipo de declaracion</option>
                                <option value="VENTA">VENTA</option>
                                <option value="RENTA">RENTA</option>
                              </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Nombre o Razon Social(*):</label>
                            <input type="hidden" name="razonSocial" id="razonSocial">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="100" placeholder="Ingrese el nombre o razon social" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Monto(*):</label>
                            <input type="hidden" name="Monto" id="Monto">
                            <input type="text" class="form-control" name="Monto" id="Monto" maxlength="7" placeholder="Ingrese el Monto" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Departamento(*):</label>
                              <select class="form-control" name="departamento" id="departamento" onchange="cargarOpciones()" required>
                                <option value="">Selecione un departamento</option>
                                <option value="ATLÁNTIDA">ATLÁNTIDA</option>
                                <option value="COLÓN">COLÓN</option>
                                <option value="COMAYAGUA">COMAYAGUA</option>
                                <option value="COPÁN">COPÁN</option>
                                <option value="CORTÉS">CORTÉS</option>
                                <option value="CHOLUTECA">CHOLUTECA</option>
                                <option value="EL PARAÍSO">EL PARAÍSO</option>
                                <option value="FRANCISCO MORAZÁN">FRANCISCO MORAZÁN</option>
                                <option value="GRACIAS A DIOS">GRACIAS A DIOS</option>
                                <option value="INTIBUCÁ">INTIBUCÁ</option>
                                <option value="ISLAS DE LA BAHÍA">ISLAS DE LA BAHÍA</option>
                                <option value="LA PAZ">LA PAZ</option>
                                <option value="LEMPIRA">LEMPIRA</option>
                                <option value="OCOTEPEQUE">OCOTEPEQUE</option>
                                <option value="OLANCHO">OLANCHO</option>
                                <option value="SANTA BÁRBARA">SANTA BÁRBARA</option>
                                <option value="VALLE">VALLE</option>
                                <option value="YORO">YORO</option>

                              </select>
                          </div>

                             
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Municipio:</label>
                            <select class="form-control" name="municipio" id="municipio"></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Barrio o Colonia(*):</label>
                            <input type="hidden" name="barrioColonia" id="barrioColonia">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="barrioColonia" id="barrioColonia" maxlength="100" placeholder="Ingrese el Barrio o Colonia" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Calle o Avenida(*):</label>
                            <input type="hidden" name="calleAvenida" id="calleAvenida">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="calleAvenida" id="calleAvenida" maxlength="100" placeholder="Ingrese la calle o avenida" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero de casa(*):</label>
                            <input type="hidden" name="numCasa" id="numCasa">
                            <input type="text" class="form-control" name="numCasa" id="numCasa" maxlength="100" placeholder="Ingrese el numero de casa" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Bloque(*):</label>
                            <input type="hidden" name="bloque" id="bloque">
                            <input type="text" class="form-control" name="bloque" id="bloque" maxlength="100" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" placeholder="Ingrese el bloque">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Telefono Fijo:</label>
                            <input type="hidden" name="telFijo" id="telFijo">
                            <input type="text" class="form-control" name="telFijo" id="telFijo" maxlength="8" placeholder="Ingrese el Telefono Fijo" oninput="validarTelefono(event)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Celular(*):</label>
                            <input type="hidden" name="telCelular" id="telCelular">
                            <input type="text" class="form-control" name="telCelular" id="telCelular" maxlength="8" placeholder="Ingrese el Telefono Celular" oninput="validarTelefono(event)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Domicilio(*):</label>
                            <input type="hidden" name="domicilio" id="domicilio">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="domicilio" id="domicilio" maxlength="100" placeholder="Ingrese el Domicilio" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Correo electronico(*):</label>
                            <input type="hidden" name="Correo_electronico" id="Correo_electronico">
                            <input type="text" class="form-control" name="Correo_electronico" id="Correo_electronico" maxlength="100" placeholder="Ingrese el correo electronico" onkeypress="validarCorreo(event)" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Profesion u Oficio(*):</label>
                            <input type="hidden" name="profesionOficio" id="profesionOficio">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="profesionOficio" id="profesionOficio" maxlength="100" placeholder="Ingrese la profesion u Oficio" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>CAI(*):</label>
                            <input type="hidden" name="cai" id="cai">
                            <input type="text" class="form-control" name="cai" id="cai" maxlength="36" placeholder="Ingrese el codigo CAI" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Fecha Limite de Emision(*):</label>
                            <input type="hidden" name="fechaEmision" id="fechaEmision">
                            <input type="date" class="form-control" name="fechaEmision" id="fechaEmision" maxlength="100" placeholder="Ingrese la fecha de emision" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero Inicial(*):</label>
                            <input type="hidden" name="numeroInicial" id="numeroInicial">
                            <input type="text" class="form-control" name="numeroInicial" id="numeroInicial" maxlength="6" placeholder="Ingrese el Numero Inicial" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero Final(*):</label>
                            <input type="hidden" name="numeroFinal" id="numeroFinal">
                            <input type="text" class="form-control" name="numeroFinal" id="numeroFinal" maxlength="6" placeholder="Ingrese el Numero Final"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
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
    window.location.href = "SAR_Adm.php";
  });
}
  </script>
 	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>
  <script src="../../js/Buscador.js"></script>


</body>
</html>


<script>
    //Validar Telefono
    function validarTelefono(event) {
    const telefono = event.target.value.trim();
    
    if (telefono.length < 8 || telefono[0] === '0') {
        event.target.setCustomValidity('El número de teléfono no debe comenzar en 0 y debe tener minimo 8 digitos.');
    } else {
        const numeros = telefono.replace(/[^0-9]/g, '');
        const repetidos = numeros.split('').sort().join('').match(/(.)\1{4}/g);
        
        if (repetidos) {
        event.target.setCustomValidity('El número de teléfono contiene más de 5 dígitos repetidos consecutivos.');
        } else {
        const unicos = new Set(numeros);
        const porcentaje = unicos.size / telefono.length;
        
        if (porcentaje < 0.5) {
            event.target.setCustomValidity('El número de teléfono no cumple los requisitos mínimos.');
        } else {
            event.target.setCustomValidity('');
        }
        }
    }
    }
  </script>


<!-- <script>
  function validarInput(input) {
  // Expresión regular que valida que solo se ingresen letras (mayúsculas o minúsculas)
  const regex = /^[a-zA-Z]*$/;
  if (!regex.test(input.value)) {
    // Si no cumple con la expresión regular, se elimina el último caracter ingresado
    input.value = input.value.substring(0, input.value.length - 1);
  }
}
</script> -->

<script>
  function validarNombre(e) {
  var tecla = e.keyCode || e.which;
  var teclaFinal = String.fromCharCode(tecla).toUpperCase();
  var letras = /^[A-Z\s]+$/; // Agregar \s para permitir espacios

  if (!letras.test(teclaFinal)) {
      e.preventDefault();
  }
  }
</script>

<script>
  function cargarOpciones() {
  var departamento = document.getElementById("departamento");
  var municipio = document.getElementById("municipio");
  
  // Vaciar el segundo combobox
  municipio.innerHTML = "";
  
  // Agregar opciones según la opción seleccionada en el primer combobox
  if (departamento.value === "ATLÁNTIDA") {
    municipio.add(new Option("LA CEIBA", "LA CEIBA"));
    municipio.add(new Option("EL PORVENIR", "EL PORVENIR"));
    municipio.add(new Option("TELA", "TELA"));
    municipio.add(new Option("JUTIAPA", "JUTIAPA"));
    municipio.add(new Option("LA MASICA", "LA MASICA"));
    municipio.add(new Option("SAN FRANCISCO", "SAN FRANCISCO"));
    municipio.add(new Option("ARIZONA", "ARIZONA"));
    municipio.add(new Option("ESPARTA", "ESPARTA"));
  } else if (departamento.value === "COLÓN") {
    municipio.add(new Option("TRUJILLO", "TRUJILLO"));
    municipio.add(new Option("BALFATE", "BALFATE"));
    municipio.add(new Option("IRIONA", "IRIONA"));
    municipio.add(new Option("LIMÓN", "LIMÓN"));
    municipio.add(new Option("SABÁ", "SABÁ"));
    municipio.add(new Option("SANTA FE", "SANTA FE"));
    municipio.add(new Option("SANTA ROSA DE AGUÁN", "SANTA ROSA DE AGUÁN"));
    municipio.add(new Option("SONAGUERA", "SONAGUERA"));
    municipio.add(new Option("TOCOA", "TOCOA"));
    municipio.add(new Option("BONITO ORIENTAL", "BONITO ORIENTAL"));
  } else if (departamento.value === "COMAYAGUA") {
    municipio.add(new Option("COMAYAGUA", "COMAYAGUA"));
    municipio.add(new Option("AJUTERIQUE", "AJUTERIQUE"));
    municipio.add(new Option("EL ROSARIO", "EL ROSARIO"));
    municipio.add(new Option("ESQUÍAS", "ESQUÍAS"));
    municipio.add(new Option("HUMUYA", "HUMUYA"));
    municipio.add(new Option("LA LIBERTAD", "LA LIBERTAD"));
    municipio.add(new Option("LAMANÍ", "LAMANÍ"));
    municipio.add(new Option("LA TRINIDAD", "LA TRINIDAD"));
    municipio.add(new Option("LEJAMANÍ", "LEJAMANÍ"));
    municipio.add(new Option("MEÁMBAR", "MEÁMBAR"));
    municipio.add(new Option("MINAS DE ORO", "MINAS DE ORO"));
    municipio.add(new Option("OJOS DE AGUA", "OJOS DE AGUA"));
    municipio.add(new Option("SAN JERÓNIMO", "SAN JERÓNIMO"));
    municipio.add(new Option("SAN JOSÉ DE COMAYAGUA", "SAN JOSÉ DE COMAYAGUA"));
    municipio.add(new Option("SAN JOSÉ DEL POTRERO", "SAN JOSÉ DEL POTRERO"));
    municipio.add(new Option("SAN LUIS", "SAN LUIS"));
    municipio.add(new Option("SAN SEBASTIÁN", "SAN SEBASTIÁN"));
    municipio.add(new Option("SIGUATEPEQUE", "SIGUATEPEQUE"));
    municipio.add(new Option("VILLA DE SAN ANTONIO", "VILLA DE SAN ANTONIO"));
    municipio.add(new Option("LAS LAJAS", "LAS LAJAS"));
    municipio.add(new Option("TAULABÉ", "TAULABÉ"));
  } else if (departamento.value === "COPÁN") {
    municipio.add(new Option("SANTA ROSA DE COPÁN", "SANTA ROSA DE COPÁN"));
    municipio.add(new Option("CABAÑAS", "CABAÑAS"));
    municipio.add(new Option("CONCEPCIÓN", "CONCEPCIÓN"));
    municipio.add(new Option("COPÁN RUINAS", "COPÁN RUINAS"));
    municipio.add(new Option("CORQUÍN", "CORQUÍN"));
    municipio.add(new Option("CUCUYAGUA", "CUCUYAGUA"));
    municipio.add(new Option("DOLORES", "DOLORES"));
    municipio.add(new Option("DULCE NOMBRE", "DULCE NOMBRE"));
    municipio.add(new Option("EL PARAÍSO", "EL PARAÍSO"));
    municipio.add(new Option("FLORIDA", "FLORIDA"));
    municipio.add(new Option("LA JIGUA", "LA JIGUA"));
    municipio.add(new Option("LA UNIÓN", "LA UNIÓN"));
    municipio.add(new Option("NUEVA ARCADIA", "NUEVA ARCADIA"));
    municipio.add(new Option("SAN AGUSTÍN", "SAN AGUSTÍN"));
    municipio.add(new Option("SAN ANTONIO", "SAN ANTONIO"));
    municipio.add(new Option("SAN JERÓNIMO", "SAN JERÓNIMO"));
    municipio.add(new Option("SAN JOSÉ", "SAN JOSÉ"));
    municipio.add(new Option("SAN JUAN DE OPOA", "SAN JUAN DE OPOA"));
    municipio.add(new Option("SAN NICOLÁS", "SAN NICOLÁS"));
    municipio.add(new Option("SAN PEDRO", "SAN PEDRO"));
    municipio.add(new Option("SANTA RITA", "SANTA RITA"));
    municipio.add(new Option("TRINIDAD DE COPÁN", "TRINIDAD DE COPÁN"));
    municipio.add(new Option("VERACRUZ", "VERACRUZ"));
  }else if (departamento.value === "CORTÉS") {
    municipio.add(new Option("SAN PEDRO SULA", "SAN PEDRO SULA"));
    municipio.add(new Option("CHOLOMA", "CHOLOMA"));
    municipio.add(new Option("OMOA", "OMOA"));
    municipio.add(new Option("PIMIENTA", "PIMIENTA"));
    municipio.add(new Option("POTRERILLOS", "POTRERILLOS"));
    municipio.add(new Option("PUERTO CORTÉS", "PUERTO CORTÉS"));
    municipio.add(new Option("SAN ANTONIO DE CORTÉS", "SAN ANTONIO DE CORTÉS"));
    municipio.add(new Option("SAN FRANCISCO DE YOJOA", "SAN FRANCISCO DE YOJOA"));
    municipio.add(new Option("SAN MANUEL", "SAN MANUEL"));
    municipio.add(new Option("SANTA CRUZ DE YOJOA", "SANTA CRUZ DE YOJOA"));
    municipio.add(new Option("VILLANUEVA", "VILLANUEVA"));
    municipio.add(new Option("LA LIMA", "LA LIMA"));
  }else if (departamento.value === "CHOLUTECA") {
    municipio.add(new Option("CHOLUTECA", "CHOLUTECA"));
    municipio.add(new Option("APACILAGUA", "APACILAGUA"));
    municipio.add(new Option("CONCEPCIÓN DE MARÍA", "CONCEPCIÓN DE MARÍA"));
    municipio.add(new Option("DUYURE", "DUYURE"));
    municipio.add(new Option("EL CORPUS", "EL CORPUS"));
    municipio.add(new Option("EL TRIUNFO", "EL TRIUNFO"));
    municipio.add(new Option("MARCOVIA", "MARCOVIA"));
    municipio.add(new Option("MOROLICA", "MOROLICA"));
    municipio.add(new Option("NAMASIGÜE", "NAMASIGÜE"));
    municipio.add(new Option("OROCUINA", "OROCUINA"));
    municipio.add(new Option("PESPIRE", "PESPIRE"));
    municipio.add(new Option("SAN ANTONIO DE FLORES", "SAN ANTONIO DE FLORES"));
    municipio.add(new Option("SAN ISIDRO", "SAN ISIDRO"));
    municipio.add(new Option("SAN JOSÉ", "SAN JOSÉ"));
    municipio.add(new Option("SAN MARCOS DE COLÓN", "SAN MARCOS DE COLÓN"));
    municipio.add(new Option("SANTA ANA DE YUSGUARE", "SANTA ANA DE YUSGUARE"));
  }else if (departamento.value === "EL PARAÍSO") {
    municipio.add(new Option("YUSCARÁN", "YUSCARÁN"));
    municipio.add(new Option("ALAUCA", "ALAUCA"));
    municipio.add(new Option("DANLÍ", "DANLÍ"));
    municipio.add(new Option("EL PARAÍSO", "EL PARAÍSO"));
    municipio.add(new Option("GÜINOPE", "GÜINOPE"));
    municipio.add(new Option("JACALEAPA", "JACALEAPA"));
    municipio.add(new Option("LIURE", "LIURE"));
    municipio.add(new Option("MOROCELÍ", "MOROCELÍ"));
    municipio.add(new Option("OROPOLÍ", "OROPOLÍ"));
    municipio.add(new Option("POTRERILLOS", "POTRERILLOS"));
    municipio.add(new Option("SAN ANTONIO DE FLORES", "SAN ANTONIO DE FLORES"));
    municipio.add(new Option("SAN LUCAS", "SAN LUCAS"));
    municipio.add(new Option("SAN MATÍAS", "SAN MATÍAS"));
    municipio.add(new Option("SOLEDAD", "SOLEDAD"));
    municipio.add(new Option("TEUPASENTI", "TEUPASENTI"));
    municipio.add(new Option("TEXIGUAT", "TEXIGUAT"));
    municipio.add(new Option("VADO ANCHO", "VADO ANCHO"));
    municipio.add(new Option("YAUYUPE", "YAUYUPE"));
    municipio.add(new Option("TROJES", "TROJES"));
  }else if (departamento.value === "FRANCISCO MORAZÁN") {
    municipio.add(new Option("DISTRITO CENTRAL", "DISTRITO CENTRAL"));
    municipio.add(new Option("ALUBARÉN", "ALUBARÉN"));
    municipio.add(new Option("CEDROS", "CEDROS"));
    municipio.add(new Option("CURARÉN", "CURARÉN"));
    municipio.add(new Option("EL PORVENIR", "EL PORVENIR"));
    municipio.add(new Option("GUAIMACA", "GUAIMACA"));
    municipio.add(new Option("LA LIBERTAD", "LA LIBERTAD"));
    municipio.add(new Option("LA VENTA", "LA VENTA"));
    municipio.add(new Option("LEPATERIQUE", "LEPATERIQUE"));
    municipio.add(new Option("MARAITA", "MARAITA"));
    municipio.add(new Option("MARALE", "MARALE"));
    municipio.add(new Option("NUEVA ARMENIA", "NUEVA ARMENIA"));
    municipio.add(new Option("OJOJONA", "OJOJONA"));
    municipio.add(new Option("ORICA", "ORICA"));
    municipio.add(new Option("REITOCA", "REITOCA"));
    municipio.add(new Option("SABANAGRANDE", "SABANAGRANDE"));
    municipio.add(new Option("SAN ANTONIO DE ORIENTE", "SAN ANTONIO DE ORIENTE"));
    municipio.add(new Option("SAN BUENAVENTURA", "SAN BUENAVENTURA"));
    municipio.add(new Option("SAN IGNACIO", "SAN IGNACIO"));
    municipio.add(new Option("SAN JUAN DE FLORES", "SAN JUAN DE FLORES"));
    municipio.add(new Option("SAN MIGUELITO", "SAN MIGUELITO"));
    municipio.add(new Option("SANTA ANA", "SANTA ANA"));
    municipio.add(new Option("SANTA LUCÍA", "SANTA LUCÍA"));
    municipio.add(new Option("TALANGA", "TALANGA"));
    municipio.add(new Option("TATUMBLA", "TATUMBLA"));
    municipio.add(new Option("VALLE DE ÁNGELES", "VALLE DE ÁNGELES"));
    municipio.add(new Option("VILLA DE SAN FRANCISCO", "VILLA DE SAN FRANCISCO"));
    municipio.add(new Option("VALLECILLO", "VALLECILLO"));
  }else if (departamento.value === "GRACIAS A DIOS") {
    municipio.add(new Option("PUERTO LEMPIRA", "PUERTO LEMPIRA"));
    municipio.add(new Option("BRUS LAGUNA", "BRUS LAGUNA"));
    municipio.add(new Option("AHUAS", "AHUAS"));
    municipio.add(new Option("JUAN FRANCISCO BULNES", "JUAN FRANCISCO BULNES"));
    municipio.add(new Option("VILLEDA MORALES", "VILLEDA MORALES"));
    municipio.add(new Option("WAMPUSIRPE", "WAMPUSIRPE"));
  }else if (departamento.value === "INTIBUCÁ") {
    municipio.add(new Option("LA ESPERANZA", "LA ESPERANZA"));
    municipio.add(new Option("CAMASCA", "CAMASCA"));
    municipio.add(new Option("COLOMONCAGUA", "COLOMONCAGUA"));
    municipio.add(new Option("CONCEPCIÓN", "CONCEPCIÓN"));
    municipio.add(new Option("DOLORES", "DOLORES"));
    municipio.add(new Option("INTIBUCÁ", "INTIBUCÁ"));
    municipio.add(new Option("JESÚS DE OTORO", "JESÚS DE OTORO"));
    municipio.add(new Option("MAGDALENA", "MAGDALENA"));
    municipio.add(new Option("MASAGUARA", "MASAGUARA"));
    municipio.add(new Option("SAN ANTONIO", "SAN ANTONIO"));
    municipio.add(new Option("SAN ISIDRO", "SAN ISIDRO"));
    municipio.add(new Option("SAN JUAN", "SAN JUAN"));
    municipio.add(new Option("SAN MARCOS DE LA SIERRA", "SAN MARCOS DE LA SIERRA"));
    municipio.add(new Option("SAN MIGUELITO", "SAN MIGUELITO"));
    municipio.add(new Option("SANTA LUCÍA", "SANTA LUCÍA"));
    municipio.add(new Option("YAMARANGUILA", "YAMARANGUILA"));
    municipio.add(new Option("SAN FRANCISCO DE OPALACA", "SAN FRANCISCO DE OPALACA"));
  }else if (departamento.value === "ISLAS DE LA BAHÍA") {
    municipio.add(new Option("ROATÁN", "ROATÁN"));
    municipio.add(new Option("GUANAJA", "GUANAJA"));
    municipio.add(new Option("JOSÉ SANTOS GUARDIOLA", "JOSÉ SANTOS GUARDIOLA"));
    municipio.add(new Option("UTILA", "UTILA"));
  }else if (departamento.value === "LA PAZ") {
    municipio.add(new Option("LA PAZ", "LA PAZ"));
    municipio.add(new Option("AGUANQUETERIQUE", "AGUANQUETERIQUE"));
    municipio.add(new Option("CABAÑAS", "CABAÑAS"));
    municipio.add(new Option("CANE", "CANE"));
    municipio.add(new Option("CHINACLA", "CHINACLA"));
    municipio.add(new Option("GUAJIQUIRO", "GUAJIQUIRO"));
    municipio.add(new Option("LAUTERIQUE", "LAUTERIQUE"));
    municipio.add(new Option("MARCALA", "MARCALA"));
    municipio.add(new Option("MERCEDES DE ORIENTE", "MERCEDES DE ORIENTE"));
    municipio.add(new Option("OPATORO", "OPATORO"));
    municipio.add(new Option("SAN ANTONIO DEL NORTE", "SAN ANTONIO DEL NORTE"));
    municipio.add(new Option("SAN JOSÉ", "SAN JOSÉ"));
    municipio.add(new Option("SAN JUAN", "SAN JUAN"));
    municipio.add(new Option("SAN PEDRO DE TUTULE", "SAN PEDRO DE TUTULE"));
    municipio.add(new Option("SANTA ANA", "SANTA ANA"));
    municipio.add(new Option("SANTA ELENA", "SANTA ELENA"));
    municipio.add(new Option("SANTA MARÍA", "SANTA MARÍA"));
    municipio.add(new Option("SANTIAGO DE PURINGLA", "SANTIAGO DE PURINGLA"));
    municipio.add(new Option("YARULA", "YARULA"));
  }else if (departamento.value === "LEMPIRA") {
    municipio.add(new Option("GRACIAS", "GRACIAS"));
    municipio.add(new Option("BELÉN", "BELÉN"));
    municipio.add(new Option("CANDELARIA", "CANDELARIA"));
    municipio.add(new Option("COLOLACA", "COLOLACA"));
    municipio.add(new Option("ERANDIQUE", "ERANDIQUE"));
    municipio.add(new Option("GUALCINCE", "GUALCINCE"));
    municipio.add(new Option("GUARITA", "GUARITA"));
    municipio.add(new Option("LA CAMPA", "LA CAMPA"));
    municipio.add(new Option("LA IGUALA", "LA IGUALA"));
    municipio.add(new Option("LAS FLORES", "LAS FLORES"));
    municipio.add(new Option("LA UNIÓN", "LA UNIÓN"));
    municipio.add(new Option("LA VIRTUD", "LA VIRTUD"));
    municipio.add(new Option("LEPAERA", "LEPAERA"));
    municipio.add(new Option("MAPULACA", "MAPULACA"));
    municipio.add(new Option("PIRAERA", "PIRAERA"));
    municipio.add(new Option("SAN ANDRÉS", "SAN ANDRÉS"));
    municipio.add(new Option("SAN FRANCISCO", "SAN FRANCISCO"));
    municipio.add(new Option("SAN JUAN GUARITA", "SAN JUAN GUARITA"));
    municipio.add(new Option("SAN MANUEL COLOHETE", "SAN MANUEL COLOHETE"));
    municipio.add(new Option("SAN RAFAEL", "SAN RAFAEL"));
    municipio.add(new Option("SAN SEBASTIÁN", "SAN SEBASTIÁN"));
    municipio.add(new Option("SANTA CRUZ", "SANTA CRUZ"));
    municipio.add(new Option("TALGUA", "TALGUA"));
    municipio.add(new Option("TAMBLA", "TAMBLA"));
    municipio.add(new Option("TOMALÁ", "TOMALÁ"));
    municipio.add(new Option("VALLADOLID", "VALLADOLID"));
    municipio.add(new Option("VIRGINIA", "VIRGINIA"));
    municipio.add(new Option("SAN MARCOS DE CAIQUÍN", "SAN MARCOS DE CAIQUÍN"));
  }else if (departamento.value === "OCOTEPEQUE") {
    municipio.add(new Option("OCOTEPEQUE", "OCOTEPEQUE"));
    municipio.add(new Option("BELÉN GUALCHO", "BELÉN GUALCHO"));
    municipio.add(new Option("CONCEPCIÓN", "CONCEPCIÓN"));
    municipio.add(new Option("DOLORES MERENDÓN", "DOLORES MERENDÓN"));
    municipio.add(new Option("FRATERNIDAD", "FRATERNIDAD"));
    municipio.add(new Option("LA ENCARNACIÓN", "LA ENCARNACIÓN"));
    municipio.add(new Option("LA LABOR", "LA LABOR"));
    municipio.add(new Option("LUCERNA", "LUCERNA"));
    municipio.add(new Option("MERCEDES", "MERCEDES"));
    municipio.add(new Option("SAN FERNANDO", "SAN FERNANDO"));
    municipio.add(new Option("SAN FRANCISCO DEL VALLE", "SAN FRANCISCO DEL VALLE"));
    municipio.add(new Option("SAN JORGE", "SAN JORGE"));
    municipio.add(new Option("SAN MARCOS", "SAN MARCOS"));
    municipio.add(new Option("SANTA FE", "SANTA FE"));
    municipio.add(new Option("SENSENTI", "SENSENTI"));
    municipio.add(new Option("SINUAPA", "SINUAPA"));
  }else if (departamento.value === "OLANCHO") {
    municipio.add(new Option("JUTICALPA", "JUTICALPA"));
    municipio.add(new Option("CAMPAMENTO", "CAMPAMENTO"));
    municipio.add(new Option("CATACAMAS", "CATACAMAS"));
    municipio.add(new Option("CONCORDIA", "CONCORDIA"));
    municipio.add(new Option("DULCE NOMBRE DE CULMÍ", "DULCE NOMBRE DE CULMÍ"));
    municipio.add(new Option("EL ROSARIO", "EL ROSARIO"));
    municipio.add(new Option("ESQUIPULAS DEL NORTE", "ESQUIPULAS DEL NORTE"));
    municipio.add(new Option("GUALACO", "GUALACO"));
    municipio.add(new Option("GUARIZAMA", "GUARIZAMA"));
    municipio.add(new Option("GUATA", "GUATA"));
    municipio.add(new Option("GUAYAPE", "GUAYAPE"));
    municipio.add(new Option("JANO", "JANO"));
    municipio.add(new Option("LA UNIÓN", "LA UNIÓN"));
    municipio.add(new Option("MANGULILE", "MANGULILE"));
    municipio.add(new Option("MANTO", "MANTO"));
    municipio.add(new Option("SALAMÁ", "SALAMÁ"));
    municipio.add(new Option("SAN ESTEBAN", "SAN ESTEBAN"));
    municipio.add(new Option("SAN FRANCISCO DE BECERRA", "SAN FRANCISCO DE BECERRA"));
    municipio.add(new Option("SAN FRANCISCO DE LA PAZ", "SAN FRANCISCO DE LA PAZ"));
    municipio.add(new Option("SANTA MARÍA DEL REAL", "SANTA MARÍA DEL REAL"));
    municipio.add(new Option("SILCA", "SILCA"));
    municipio.add(new Option("YOCÓN", "YOCÓN"));
    municipio.add(new Option("PATUCA", "PATUCA"));
  }else if (departamento.value === "SANTA BÁRBARA") {
    municipio.add(new Option("SANTA BÁRBARA", "SANTA BÁRBARA"));
    municipio.add(new Option("ARADA", "ARADA"));
    municipio.add(new Option("ATIMA", "ATIMA"));
    municipio.add(new Option("AZACUALPA", "AZACUALPA"));
    municipio.add(new Option("CEGUACA", "CEGUACA"));
    municipio.add(new Option("CONCEPCIÓN DEL NORTE", "CONCEPCIÓN DEL NORTE"));
    municipio.add(new Option("CONCEPCIÓN DEL SUR", "CONCEPCIÓN DEL SUR"));
    municipio.add(new Option("CHINDA", "CHINDA"));
    municipio.add(new Option("EL NÍSPERO", "EL NÍSPERO"));
    municipio.add(new Option("GUALALA", "GUALALA"));
    municipio.add(new Option("ILAMA", "ILAMA"));
    municipio.add(new Option("LAS VEGAS", "LAS VEGAS"));
    municipio.add(new Option("MACUELIZO", "MACUELIZO"));
    municipio.add(new Option("NARANJITO", "NARANJITO"));
    municipio.add(new Option("NUEVO CELILAC", "NUEVO CELILAC"));
    municipio.add(new Option("NUEVA FRONTERA", "NUEVA FRONTERA"));
    municipio.add(new Option("PETOA", "PETOA"));
    municipio.add(new Option("PROTECCIÓN", "PROTECCIÓN"));
    municipio.add(new Option("QUIMISTÁN", "QUIMISTÁN"));
    municipio.add(new Option("SAN FRANCISCO DE OJUERA", "SAN FRANCISCO DE OJUERA"));
    municipio.add(new Option("SAN JOSÉ DE LAS COLINAS", "SAN JOSÉ DE LAS COLINAS"));
    municipio.add(new Option("SAN LUIS", "SAN LUIS"));
    municipio.add(new Option("SAN MARCOS", "SAN MARCOS"));
    municipio.add(new Option("SAN NICOLÁS", "SAN NICOLÁS"));
    municipio.add(new Option("SAN PEDRO ZACAPA", "SAN PEDRO ZACAPA"));
    municipio.add(new Option("SAN VICENTE CENTENARIO", "SAN VICENTE CENTENARIO"));
    municipio.add(new Option("SANTA RITA", "SANTA RITA"));
    municipio.add(new Option("TRINIDAD", "TRINIDAD"));
  }else if (departamento.value === "VALLE") {
    municipio.add(new Option("NACAOME", "NACAOME"));
    municipio.add(new Option("ALIANZA", "ALIANZA"));
    municipio.add(new Option("AMAPALA", "AMAPALA"));
    municipio.add(new Option("ARAMECINA", "ARAMECINA"));
    municipio.add(new Option("CARIDAD", "CARIDAD"));
    municipio.add(new Option("GOASCORÁN", "GOASCORÁN"));
    municipio.add(new Option("LANGUE", "LANGUE"));
    municipio.add(new Option("SAN FRANCISCO DE CORAY", "SAN FRANCISCO DE CORAY"));
    municipio.add(new Option("SAN LORENZO", "SAN LORENZO"));
  }else if (departamento.value === "YORO") {
    municipio.add(new Option("YORO", "YORO"));
    municipio.add(new Option("ARENAL", "ARENAL"));
    municipio.add(new Option("EL NEGRITO", "EL NEGRITO"));
    municipio.add(new Option("EL PROGRESO", "EL PROGRESO"));
    municipio.add(new Option("JOCÓN", "JOCÓN"));
    municipio.add(new Option("MORAZÁN", "MORAZÁN"));
    municipio.add(new Option("OLANCHITO", "OLANCHITO"));
    municipio.add(new Option("SANTA RITA", "SANTA RITA"));
    municipio.add(new Option("SULACO", "SULACO"));
    municipio.add(new Option("VICTORIA", "VICTORIA"));
    municipio.add(new Option("YORITO", "YORITO"));
  }

} 
</script>
