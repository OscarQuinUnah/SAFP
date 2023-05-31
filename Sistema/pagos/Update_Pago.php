<?php 
//Controladores importantes
 require '../../conexion_BD.php'; 
 require_once "../../EVENT_BITACORA.php";
 session_start();     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
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
    $sql1=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$usuario'");

    while($row=mysqli_fetch_array($sql1)){
        $ID_Usuario=$row['ID_Usuario'];
    }
    $ID_Pago=$_POST["ID_de_pago"];
    $Monto=$_POST["Monto_pagado"];
    $T_Monto=$_POST["Pago"];

    $Fecha_de_transaccion=$_POST["FechaTransaccion"];
    $Fecha_actual = date('Y-m-d');
            //si lo que esta en el form esta vacio

            //UPDATE tbl_ms_usuario SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_pagos_realizados SET Monto_pagado = $Monto, ID_T_pago = $T_Monto,ID_de_proyecto = $IDProyecto, ID_usuario = $ID_Usuario, Fecha_de_transaccion ='$Fecha_de_transaccion', Modificado_por= '$usuario' where ID_de_pago = $ID_Pago";
            $resultado = mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
                    location.assign('PagosAdm.php');
                    </script>";
                    require_once "../../EVENT_BITACORA.php";
                    $model = new EVENT_BITACORA;
                    session_start();
                    $_SESSION['idpagoBitacoraUP']=$ID_Pago;
                    $_SESSION['pagoBitacoraUP']=$Monto;
                    $model->RegUptpag();

            }else{
                echo "<script language='JavaScript'>
                alert('Los datos NO se actualizaron');
            location.assign('PagosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_de_pago']; //recuperar el id que se envia desde el home.html
            $sql="SELECT * FROM tbl_pagos_realizados where ID_de_pago='".$id."'";
            $resultado=mysqli_query($conexion,$sql);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_Pago=$fila['ID_de_pago'];
            $Monto=$fila['Monto_pagado'];
            $T_Monto=$fila['ID_T_pago'];
            $ID_Proyecto=$fila['ID_de_proyecto'];
            $ID_Usuario=$fila['ID_Usuario'];
            $Fecha_transaccion=$fila['Fecha_de_transaccion'];
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Pagos</h1>
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
                          <label>ID del Pago(*):</label>
                            <input type="hidden" name="ID_de_pago" id="ID_de_pago">
                            <input style="text" type="text" class="form-control" name="ID_de_pago" id="ID_de_pago" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'   value="<?php echo $ID_Pago; ?>" readonly>
                          </div>
                          <?php require '../../conexion_BD.php';?>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Pagos del Proyecto:</label>
                            <?php 
                            $sql1=$conexion->query("SELECT * FROM `tbl_proyectos` WHERE ID_proyecto='$IDProyecto'");
                               while($row=mysqli_fetch_array($sql1)){
                               $Nombre_del_proyecto=$row['Nombre_del_proyecto'];
                            }?>
                            <input class="form-control" name="Proyecto" id="Proyecto" placeholder="<?php echo $Nombre_del_proyecto?>" readonly>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                          <label>Monto Pagado(*):</label>
                            <input type="hidden" name="Monto_pagado" id="Monto_pagado">
                            <input style="text" type="text" class="form-control" name="Monto_pagado" id="Monto_pagado" value="<?php echo $Monto; ?>" required>
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                           <?php require '../../conexion_BD.php'; ?>
                          <label>Tipo de Pago(*)::</label>
                            <?php
                            $sql = $conexion->query("SELECT * FROM tbl_tipo_pago_r");
                            ?>
                            <select class="form-control" name="Pago" id="Pago" required>
                            <option value="">Seleccione un pago</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($sql)) {
                            $selected = ($row1['ID_T_pago'] == $T_Monto) ? 'selected' : '';
                            echo "<option value='".$row1['ID_T_pago']."' ".$selected.">".$row1['Nombre']."</option>";
                            }
                            ?>
                            </select>
                          </div>
                         
                          <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <label>Fecha de Transaccion:</label>
                            <input type="date" class="form-control" name="FechaTransaccion" id="FechaTransaccion" maxlength="100" placeholder="Ingrese la Fecha de Transaccion"  value="<?php echo $Fecha_transaccion; ?>">
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
    window.location.href = "PagosAdm.php";
  });
}
</script>
    <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
    <script src="../../js/main.js"></script>
  <script src="../../js/usuario.js"></script>
  <?php include '../sidebarpro.php'; ?>

</body>
</html>

