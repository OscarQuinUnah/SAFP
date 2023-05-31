<?php
    include("../../conexion_BD.php");
    session_start();
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

    <?php include '../sidebarpro.php'; ?>
    <?php
        if(isset($_POST['enviar_F2'])){
            //aqui entra si el usuario ha presionado el boton enviar
            
            $Usuario=$_SESSION['usuario'];       
    include("../../conexion_BD.php");
    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$Usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $ID_Usuario=$row['ID_Usuario'];
    }
    $ID_Fondo=$_POST["ID_Fondo"];
    $ID_Tipo_Fondo=$_POST["tipos_de_fondos"];
    $Nombre_del_Objeto=$_POST["Nombre_del_Objeto"];
    $Cantidad_Rec=$_POST["Cantidad_Rec"];
    $Valor_monetario=$_POST["Valor_monetario"];
    $Fecha_Adquisicion=$_POST["FechaAdquisicion"];
    $ID_Proyecto=$IDProyecto;
    $ID_Donador=$_POST["Donante"];
    $Fecha_actual = date('Y-m-d');
            //si lo que esta en el form esta vacio

            $sql="UPDATE tbl_fondos SET ID_Tipo_Fondo=$ID_Tipo_Fondo, Nombre_del_Objeto='$Nombre_del_Objeto', Cantidad_Rec=$Cantidad_Rec ,Valor_monetario=$Valor_monetario, Fecha_de_adquisicion_F  ='$Fecha_Adquisicion', ID_Donante = $ID_Donador, ID_Proyecto = $ID_Proyecto, ID_usuario = $ID_Usuario, Modificado_por= '$Usuario', Fecha_Modificacion = '$Fecha_actual' where ID_de_fondo = $ID_Fondo";
            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('FondosAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                    session_start();
                    $_SESSION['IDFondoBitacoraUP']=$Nombre_del_Objeto;
                    $model->RegUptFondo();

            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('FondosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_de_fondo']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_fondos where ID_de_fondo='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_Fondo=$fila['ID_de_Fondo'];
            $ID_Tipo_Fondo=$fila['ID_Tipo_Fondo'];
            $Nombre_del_Objeto=$fila['Nombre_del_Objeto'];
            $Cantidad_Rec=$fila['Cantidad_Rec'];
            $Valor_monetario=$fila['Valor_monetario'];
            $Fecha_Adquisicion=$fila['Fecha_de_adquisicion_F'];
            $ID_Proyecto=$fila['ID_Proyecto'];
            $ID_Donador=$fila['ID_Donante'];
            $ID_Usuario=$fila['ID_Usuario'];
            
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Fondos</h1>
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
                            <label>ID del fondo(*):</label>
                            <input type="hidden" name="ID_Fondo" id="ID_Fondo">
                            <input style="text" type="text" class="form-control" name="ID_Fondo" id="ID_Fondo" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value="<?php echo $ID_Fondo; ?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Proyecto al que esta siendo donado:</label>
                            <?php include("../../conexion_BD.php");
                            $sql1=$conexion->query("SELECT * FROM `tbl_proyectos` WHERE ID_proyecto='$IDProyecto'");
                            while($row=mysqli_fetch_array($sql1)){
                            $Nombre_del_proyecto=$row['Nombre_del_proyecto'];
                             }?>
                            <input class="form-control" name="Proyecto" id="Proyecto" placeholder="<?php echo $Nombre_del_proyecto?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Usuario</label>
                            <?php     
                            $usuario=$_SESSION['usuario'];?>
                            <input type="text" class="form-control"  name="Usuario" id="Usuario" maxlength="100" value="<?php echo $usuario; ?>" style="text-transform:uppercase" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Tipo de Fondo(*):</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_tipos_de_fondos");
                            ?>
                            <select class="form-control" name="tipos_de_fondos" id="tipos_de_fondos" required>
                            <option value="">Seleccione tipo de fondo:</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_tipo_fondo'] == $ID_Tipo_Fondo) ? 'selected' : '';
                            echo "<option value='".$row1['ID_tipo_fondo']."' ".$selected.">".$row1['nombre_T_Fondo']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Nombre del Objeto</label>
                            <input type="text" class="form-control"  name="Nombre_del_Objeto" id="Nombre_del_Objeto" oninput="this.value = this.value.toUpperCase();" placeholder="Ingrese el nombre del objeto" value="<?php echo $Nombre_del_Objeto; ?>" require>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Cantidad recibida</label>
                            <input type="text" class="form-control"  name="Cantidad_Rec" id="Cantidad_Rec" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" pattern="^\d+(\.\d{1,2})?$" placeholder="Ingrese la cantidad de fondos recibidos" value="<?php echo $Cantidad_Rec; ?>" require>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Valor monetario</label>
                            <input type="text" class="form-control"  name="Valor_monetario" id="Valor_monetario" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" placeholder="Ingrese el Valor monetario" value="<?php echo $Valor_monetario; ?>" require>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Donante del fondo(*):</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_donantes");
                            ?>
                            <select class="form-control" name="Donante" id="Donante" required>
                            <option value="">Seleccione un Donante:</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_Donante'] == $ID_Donador) ? 'selected' : '';
                            echo "<option value='".$row1['ID_Donante']."' ".$selected.">".$row1['Nombre_D']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Fecha de Adquisicion:</label>
                            <input type="date" class="form-control" name="FechaAdquisicion" id="FechaAdquisicion" maxlength="100" value="<?php echo $Fecha_Adquisicion; ?>">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="enviar_F2" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
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
    window.location.href = "FondosAdm.php";
  });
}
</script>
  
    <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
    <script src="../../js/main.js"></script>
  <script src="./js/usuario.js"></script>

</body>
</html>
