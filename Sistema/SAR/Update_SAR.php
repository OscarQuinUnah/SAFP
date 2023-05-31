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


            $id_sar=$_POST['id_sar'];//id obtenido desde el formulario

            //$ID_SAR = $_POST['id_sar'];
            $RTN = $_POST['rtn'];
            $num_declaracion = $_POST['numDeclaracion'];

            $tipoDeclaracion = $_POST['tipoDeclaracion'];

            $nombre_razonSocial = strtoupper($_POST['razonSocial']);

            $Monto = $_POST['Monto'];

            $departamento = $_POST['departamento'];
            $municipio = $_POST['municipio'];
            $barrio_colonia = strtoupper($_POST['barrioColonia']);
            $calle_avenida = strtoupper($_POST['calleAvenida']);
            $num_casa = $_POST['numCasa'];
            $bloque = $_POST['bloque'];
            $telefono = $_POST['telFijo'];
            $celular = $_POST['telCelular'];
            $domicilio = strtoupper($_POST['domicilio']);
            $correo = $_POST['Correo_electronico'];
            $profesion_oficio = strtoupper($_POST['profesionOficio']);
            $cai = $_POST['cai'];
            $fecha_limite_emision = $_POST['fechaEmision'];
            $num_inicial = $_POST['numeroInicial'];
            $num_final = $_POST['numeroFinal'];






            //UPDATE tbl_ms_usuario SET Usuario=$user WHERE Nombre_Usuario=$id;
            // $sql="UPDATE tbl_r_sar SET RTN = $RTN, num_declaracion = $num_declaracion, nombre_razonSocial = '$nombre_razonSocial', departamento = '$departamento', municipio = '$municipio', barrio_colonia = '$barrio_colonia', calle_avenida = '$calle_avenida', num_casa = $num_casa, bloque = $bloque, telefono = $telefono, celular = $celular, domicilio = '$domicilio', correo = '$correo', profesion_oficio = '$profesion_oficio', cai = '$cai', fecha_limite_emision = '$fecha_limite_emision', num_inicial = $num_inicial, num_final = $num_final = $bloque WHERE ID_SAR='$id_sar';";


            $sql = "UPDATE tbl_r_sar SET RTN = '$RTN', num_declaracion = $num_declaracion, nombre_razonSocial = '$nombre_razonSocial', Monto = $Monto,tipo_declaracion='$tipoDeclaracion', departamento = '$departamento', municipio = '$municipio', barrio_colonia = '$barrio_colonia', calle_avenida = '$calle_avenida', num_casa = $num_casa, bloque = '$bloque', telefono = $telefono, celular = $celular, domicilio = '$domicilio', correo = '$correo', profesion_oficio = '$profesion_oficio', cai = '$cai', fecha_limite_emision = '$fecha_limite_emision', num_inicial = $num_inicial, num_final = $num_final WHERE ID_SAR = $id_sar;";

            $resultado=mysqli_query($conexion,$sql);



            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('SAR_Adm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                     session_start();                       
                            $_SESSION['$RTNsarBitUP']= $RTN;
                            $model->RegUptSar(); 
                    
            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('SAR_Adm.php');
            </script>";
            }
            mysqli_close($conexion);
        
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id_sar=$_GET['ID_SAR']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_r_sar where ID_SAR ='".$id_sar."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);


            //$ID_SAR = $fila['ID_SAR']; //recuperando los datos desde la BD
            $RTN = $fila['RTN'];
            $num_declaracion = $fila['num_declaracion'];

            $tipo_declaracion = $fila['tipo_declaracion'];

            $nombre_razonSocial = $fila['nombre_razonSocial'];

            $monto = $fila['Monto'];

            $departamento = $fila['departamento'];
            $municipio = $fila['municipio'];
            $barrio_colonia = $fila['barrio_colonia'];
            $calle_avenida = $fila['calle_avenida'];
            $num_casa = $fila['num_casa'];
            $bloque = $fila['bloque'];
            $telefono = $fila['telefono'];
            $celular = $fila['celular'];
            $domicilio = $fila['domicilio'];
            $correo = $fila['correo'];
            $profesion_oficio = $fila['profesion_oficio'];
            $cai = $fila['cai'];
            $fecha_limite_emision = $fila['fecha_limite_emision'];
            $num_inicial = $fila['num_inicial'];
            $num_final = $fila['num_final'];

            if($fila['departamento'] == "ATLÁNTIDA"){
              $strDept = "ATLÁNTIDA";
            }else if($fila['departamento']=="COLÓN"){
              $strDept = "COLÓN";
            }else if($fila['departamento']=="COMAYAGUA"){
              $strDept = "COMAYAGUA"; 
            }else if($fila['departamento']=="COPÁN"){
              $strDept = "COPÁN"; 
            }else if($fila['departamento']=="CORTÉS"){
              $strDept = "CORTÉS"; 
            }else if($fila['departamento']=="CHOLUTECA"){
              $strDept = "CHOLUTECA"; 
            }else if($fila['departamento']=="EL PARAÍSO"){
              $strDept = "EL PARAÍSO"; 
            }else if($fila['departamento']=="FRANCISCO MORAZÁN"){
              $strDept = "FRANCISCO MORAZÁN"; 
            }else if($fila['departamento']=="GRACIAS A DIOS"){
              $strDept = "GRACIAS A DIOS"; 
            }else if($fila['departamento']=="INTIBUCÁ"){
              $strDept = "INTIBUCÁ"; 
            }else if($fila['departamento']=="ISLAS DE LA BAHÍA"){
              $strDept = "ISLAS DE LA BAHÍA"; 
            }else if($fila['departamento']=="LA PAZ"){
              $strDept = "LA PAZ"; 
            }else if($fila['departamento']=="LEMPIRA"){
              $strDept = "LEMPIRA"; 
            }else if($fila['departamento']=="OCOTEPEQUE"){
              $strDept = "OCOTEPEQUE"; 
            }else if($fila['departamento']=="OLANCHO"){
              $strDept = "OLANCHO"; 
            }else if($fila['departamento']=="SANTA BÁRBARA"){
              $strDept = "SANTA BÁRBARA"; 
            }else if($fila['departamento']=="VALLE"){
              $strDept = "VALLE"; 
            }else if($fila['departamento']=="YORO"){
              $strDept = "YORO"; 
            }


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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar datos</h1>
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
                            <label>ID SAR:</label>
                            <input type="hidden" name="id_sar" id="id_sar">
                            <input type="number" class="form-control" name="id_sar" id="id_sar" maxlength="100" placeholder="Ingrese el ID SAR"  value="<?php echo $id_sar; ?>" readonly required>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>RTN(*):</label>
                            <input type="hidden" name="rtn" id="rtn">
                            <input type="text" class="form-control" name="rtn" id="rtn" maxlength="14" placeholder="Ingrese el RTN" value="<?php echo $RTN; ?>"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero de declaracion(*):</label>
                            <input type="hidden" name="numDeclaracion" id="numDeclaracion">
                            <input type="text" class="form-control" name="numDeclaracion" id="numDeclaracion" maxlength="11" placeholder="Ingrese el Numero de declaracion" value="<?php echo $num_declaracion; ?>"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de declaracion(*):</label>
                              <select class="form-control" name="tipoDeclaracion" id="tipoDeclaracion" required>
                              <option selected><?php echo $tipo_declaracion?></option>
                                <option value="VENTA">VENTA</option>
                                <option value="RENTA">RENTA</option>
                              </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Nombre o Razon Social(*):</label>
                            <input type="hidden" name="razonSocial" id="razonSocial">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="100" placeholder="Ingrese el nombre o razon social" value="<?php echo $nombre_razonSocial; ?>" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Monto(*):</label>
                            <input type="hidden" name="Monto" id="Monto">
                            <input type="text" class="form-control" name="Monto" id="Monto" maxlength="7" placeholder="Ingrese el Monto" value="<?php echo  $monto ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <!-- <div class="form-floating">
                            <select class="form-select" id="floatingSelectDisabled" aria-label="Floating label disabled select example">
                              <option selected><?php echo $departamento ?></option>
                              <option value="">Selecione un departamento</option>
                                <option value="ATLÁNTIDA">Atlántida</option>
                                <option value="COLÓN">Colón</option>
                                <option value="COMAYAGUA">Comayagua</option>
                                <option value="COPÁN">Copán</option>
                                <option value="CORTÉS">Cortés</option>
                                <option value="CHOLUTECA">Choluteca</option>
                                <option value="EL PARAÍSO">El Paraíso</option>
                                <option value="FRANCISCO MORAZÁN">Francisco Morazán</option>
                                <option value="GRACIAS A DIOS">Gracias a Dios</option>
                                <option value="INTIBUCÁ">Intibucá</option>
                                <option value="ISLAS DE LA BAHÍA">Islas de la Bahía</option>
                                <option value="LA PAZ">La Paz</option>
                                <option value="LEMPIRA">Lempira</option>
                                <option value="OCOTEPEQUE">Ocotepeque</option>
                                <option value="OLANCHO">Olancho</option>
                                <option value="SANTA BÁRBARA">Santa Bárbara</option>
                                <option value="VALLE">Valle</option>
                                <option value="YORO">Yoro</option>
                            </select>
                            <label for="floatingSelectDisabled">Works with selects</label>
                          </div> -->


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Departamento(*):</label>
                              <select class="form-control" name="departamento" id="departamento" onchange="cargarOpciones()">
                                <option selected><?php echo $departamento ?></option>
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
                            <select class="form-control" name="municipio" id="municipio">
                            <option selected><?php echo $municipio ?></option>
                            </select>                            
                          </div> 

                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Barrio o Colonia(*):</label>
                            <input type="hidden" name="barrioColonia" id="barrioColonia">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="barrioColonia" id="barrioColonia" maxlength="100" placeholder="Ingrese el Barrio o Colonia" value="<?php echo $barrio_colonia; ?>" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Calle o Avenida(*):</label>
                            <input type="hidden" name="calleAvenida" id="calleAvenida">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="calleAvenida" id="calleAvenida" maxlength="100" placeholder="Ingrese la calle o avenida" value="<?php echo $calle_avenida; ?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero de casa(*):</label>
                            <input type="hidden" name="numCasa" id="numCasa">
                            <input type="text" class="form-control" name="numCasa" id="numCasa" maxlength="100" placeholder="Ingrese el numero de casa" value="<?php echo $num_casa; ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Bloque(*):</label>
                            <input type="hidden" name="bloque" id="bloque">
                            <input type="text" class="form-control" name="bloque" id="bloque" maxlength="100" placeholder="Ingrese el bloque" value="<?php echo $bloque; ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Telefono Fijo:</label>
                            <input type="hidden" name="telFijo" id="telFijo">
                            <input type="text" class="form-control" name="telFijo" id="telFijo" maxlength="8" placeholder="Ingrese el Telefono Fijo" value="<?php echo $telefono; ?>" oninput="validarTelefono(event)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Celular(*):</label>
                            <input type="hidden" name="telCelular" id="telCelular">
                            <input type="text" class="form-control" name="telCelular" id="telCelular" maxlength="8" placeholder="Ingrese el Telefono Celular" value="<?php echo $celular; ?>" oninput="validarTelefono(event)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Domicilio(*):</label>
                            <input type="hidden" name="domicilio" id="domicilio">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="domicilio" id="domicilio" maxlength="100" placeholder="Ingrese el Domicilio" value="<?php echo $domicilio; ?>" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Correo electronico(*):</label>
                            <input type="hidden" name="Correo_electronico" id="Correo_electronico">
                            <input type="text" class="form-control" name="Correo_electronico" id="Correo_electronico" maxlength="100" placeholder="Ingrese el correo electronico" value="<?php echo $correo; ?>" onkeypress="validarCorreo(event)" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Profesion u Oficio(*):</label>
                            <input type="hidden" name="profesionOficio" id="profesionOficio">
                            <input style="text-transform:uppercase" type="text" class="form-control" name="profesionOficio" id="profesionOficio" maxlength="100" placeholder="Ingrese la profesion u Oficio" value="<?php echo $profesion_oficio; ?>" onkeypress="validarNombre(event)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>CAI(*):</label>
                            <input type="hidden" name="cai" id="cai">
                            <input type="text" class="form-control" name="cai" id="cai" maxlength="36" placeholder="Ingrese el codigo CAI" value="<?php echo $cai; ?>" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Fecha Limite de Emision(*):</label>
                            <input type="hidden" name="fechaEmision" id="fechaEmision">
                            <input type="date" class="form-control" name="fechaEmision" id="fechaEmision" maxlength="100" placeholder="Ingrese la fecha de emision" value="<?php echo $fecha_limite_emision; ?>" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero Inicial(*):</label>
                            <input type="hidden" name="numeroInicial" id="numeroInicial">
                            <input type="text" class="form-control" name="numeroInicial" id="numeroInicial" maxlength="6" placeholder="Ingrese el Numero Inicial" value="<?php echo $num_inicial; ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Numero Final(*):</label>
                            <input type="hidden" name="numeroFinal" id="numeroFinal">
                            <input type="text" class="form-control" name="numeroFinal" id="numeroFinal" maxlength="6" placeholder="Ingrese el Numero Final" value="<?php echo $num_final; ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" required>
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
    window.location.href = "SAR_Adm.php";
  });
}
  </script>
	<script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>

</body>
</html>

<script>
    
    if (condition) {
    
  }
</script>


<script>
  function cargarOpciones() {
  var departamento = document.getElementById("departamento");
  var municipio = document.getElementById("municipio");
  
  municipio.innerHTML = "";


  // var select = document.getElementById("municipio");
  // var opcion = select.querySelector("option[value='$municipio']");
  // select.removeChild(opcion);

  // var formulario = document.getElementById("municipio");
  // formulario.reset();
  // var formulario = document.getElementById("departamento");
  // formulario.reset();

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