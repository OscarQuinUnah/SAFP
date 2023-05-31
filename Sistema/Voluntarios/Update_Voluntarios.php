<?php
    include("../../conexion_BD.php");
    require_once "../../EVENT_BITACORA.php";
    
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

<title>Editar Voluntario</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">

</head>
<body>
	<!--Seccion donde va toda la barra lateral -->



    <?php
        if(isset($_POST['Enviar_V'])){

            
         
          
            //aqui entra sio el usuario ha presionado el boton enviar
            $ID_Voluntario=$_POST["ID_Voluntario"];
            $Nombre_Voluntario=$_POST["Nombre_Voluntario"];
            $Telefono_Voluntario=$_POST["Telefono_Voluntario"];
            $Direccion_Voluntario=$_POST["Direccion_Voluntario"];
            $Fecha_actual = date('Y-m-d');


            //si lo que esta en el form esta vacio
            if(empty($Nombre_Voluntario)){
                echo"<p class='error'>* Debes colocar un completo</p>";
            }else if(empty($Telefono_Voluntario)){
                echo"<p class='error'>* Debes colocar el telefono</p>";
            }else if(empty($Direccion_Voluntario)){
                echo"<p class='error'>* Debes colocar la direccion</p>";
            }





            //UPDATE tbl_voluntarios SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_voluntarios SET Nombre_Voluntario = '$Nombre_Voluntario', Telefono_Voluntario ='$Telefono_Voluntario', Direccion_Voluntario ='$Direccion_Voluntario',Modificado_por='$usuario', Fecha_Modificacion='$Fecha_actual' WHERE ID_Voluntario='$ID_Voluntario';";
            $resultado=mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('VoluntariosAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                            $model = new EVENT_BITACORA;
                            session_start();
                            $_SESSION['VOLBitacoraUP']=$Nombre_Voluntario;

                            $model->RegUptVol();
            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('usuariosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }
        else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Voluntario']; //recuperar el id que se envia desde el home.html
            $sql2="SELECT * FROM tbl_voluntarios where ID_Voluntario='".$id."'";
            $resultado=mysqli_query($conexion,$sql2);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_Voluntario=$fila['ID_Voluntario'];
            $Nombre_Voluntario=$fila['Nombre_Voluntario'];
            $Telefono_Voluntario=$fila['Telefono_Voluntario'];//recuperando los datos desde la BD
            $Direccion_Voluntario=$fila['Direccion_Voluntario'];


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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Voluntarios</h1>
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
                          <label>ID Voluntario(*):</label>
                            <input type="hidden" name="ID_Voluntario" id="ID_Voluntario">
                            <input type="text" class="form-control" name="ID_Voluntario" id="ID_Voluntario" maxlength="10" value="<?php echo $ID_Voluntario; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre Voluntario(*):</label>
                            <input type="hidden" name="Nombre_Voluntario" id="Nombre_Voluntario">
                            <input onpaste="return false"  type="text" class="form-control" name="Nombre_Voluntario" id="Nombre_Voluntario" maxlength="30" placeholder="Ingrese el nombre del voluntario"  value="<?php echo $Nombre_Voluntario; ?>" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Telefono(*):</label>
                            <input type="hidden" name="Telefono_Voluntario" id="Telefono_Voluntario">
                            <input onpaste="return false" type="text" class="form-control" name="Telefono_Voluntario" id="Telefono_Voluntario" maxlength="15" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  placeholder="Ingrese el numero telefonico del voluntario" value="<?php echo $Telefono_Voluntario; ?>" oninput="validarTelefono(event)" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Direccion Voluntario(*):</label>
                            <input type="hidden" name="Direccion_Voluntario" id="Direccion_Voluntario">
                            <input onpaste="return false" oninput="this.value = this.value.toUpperCase();" type="text" class="form-control" name="Direccion_Voluntario" id="Direccion_Voluntario" maxlength="100" placeholder="Ingrese la direccion del voluntario" value="<?php echo $Direccion_Voluntario; ?>" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="Enviar_V" value="AGREGAR"><i class="zmdi zmdi-download"></i> Guardar</button>
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
                        

    <?php
        }
    ?>



	<!--script en java para los efectos-->
  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>
  <?php include '../sidebarpro.php'; ?>

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

<script>
    //Confirmar el boton cancelacion
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
    window.location.href = "VoluntariosAdm.php";
  });
}
</script>

</body>
</html>