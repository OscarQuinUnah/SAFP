<?php
    include("../../conexion_BD.php");
    require_once "../../EVENT_BITACORA.php";
    
    session_start();     
$usuario=$_SESSION['usuario'];
$ID_Rol=$_SESSION['ID_Rol'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parametros</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="../../css/main.css">

</head>
<body>
  <!--Seccion donde va toda la barra lateral -->
  <?php include '../sidebar.php'; ?>

    <?php
        if(isset($_POST['Enviar_P'])){        
            //aqui entra sio el usuario ha presionado el boton enviar
            $ID_Parametro=$_POST['ID_Parametro'];
            $Parametro=$_POST['Parametro'];
            $Descripcion_Parametro=$_POST['Descrip_Parametro'];
            $Valor=$_POST['Valor'];
            $Fecha_actual = date('Y-m-d');

            //si lo que esta en el form esta vacio
            if(empty($Valor)){
                echo"<p class='error'>* Debe colocar un valor</p>";
            }




            //UPDATE tbl_voluntarios SET Usuario=$user WHERE Nombre_Usuario=$id;
            $sql="UPDATE tbl_ms_parametros SET Descripcion_P = '$Descripcion_Parametro' ,Valor = '$Valor', ID_Usuario='$ID_Rol', Fecha_Modificacion='$Fecha_actual' WHERE ID_Parametro='$ID_Parametro';";
            $resultado=mysqli_query($conexion,$sql);

            if($resultado){
                echo "<script language='JavaScript'>
                        alert('Los datos se actualizaron correctamente');
            location.assign('ParametrosAdm.php');
            </script>";
            require_once "../../EVENT_BITACORA.php";
            $model = new EVENT_BITACORA;
             session_start();                       
                    $_SESSION['paraBitUP']=$Parametro;
                    $_SESSION['IDUsuarioBitUP']=$id;
                    $model->RegUptpara();
                    

            }else{
                echo "<script language='JavaScript'>
                alert('Error!!!, Los datos no se actualizaron');
            location.assign('ParametrosAdm.php');
            </script>";
            }
            mysqli_close($conexion);
        }
        else{
            //si el usuario NO ha presionado el boton enviar
            $id=$_GET['ID_Parametro']; //recuperar el id que se envia desde el home.html
            $sql2="SELECT * FROM tbl_ms_parametros where ID_Parametro='".$id."'";
            $resultado=mysqli_query($conexion,$sql2);

            $fila=mysqli_fetch_assoc($resultado);

            $ID_Parametro=$fila['ID_Parametro'];
            $Parametro=$fila['Parametro'];
            $Descripcion_Parametro=$fila['Descripcion_P'];
            $Valor=$fila['Valor'];//recuperando los datos desde la BD
           
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
                          <h1 style="text-align:center; margin-top:15px; margin-bottom:20px" class="box-title">Editar Parametro</h1>
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
                            <label>ID Parametros (*):</label>
                            <input type="hidden" name="ID_Parametro" id="ID_Parametro">
                            <input type="text" class="form-control" name="ID_Parametro" id="ID_Parametro" maxlength="10" value="<?php echo $ID_Parametro; ?>" readonly>
                          </div>
                            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                              <label>Parametros (*):</label>
                              <input type="hidden" name="Parametro" id="Parametro">
                              <input style="text-transform:uppercase" type="text" class="form-control" name="Parametro" id="Parametro" maxlength="50" value="<?php echo $Parametro; ?>" readonly>
                            </div>
                            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                              <label>Descripcion (*):</label>
                              <input type="hidden" name="Descrip_Parametro" id="Descrip_Parametro">
                              <input type="text" class="form-control" name="Descrip_Parametro" id="Descrip_Parametro" maxlength="80" value="<?php echo $Descripcion_Parametro; ?>" onkeypress="return /[a-zA-Z\s_,.]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" require>
                            </div>

                            <?php 
                            //Permitir solo ingresar numeros enteros
                          if ($ID_Parametro==1 or $ID_Parametro==2 or $ID_Parametro==4 or $ID_Parametro==7 or $ID_Parametro==9 or $ID_Parametro==10) { ?>
                            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                              <label>Valor (*):</label>
                              <input type="hidden" name="Valor" id="Valor">
                              <input onpaste="return false" oncopy="return false"  type="text" class="form-control" name="Valor" id="Valor" maxlength="3" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>" onkeypress="return /\d/.test(event.key)" required>
                            </div>
                          <?php }?>

                          <?php
                          //Permitir ingresar, caraceres, letras mayusculas y munisculas
                                if($ID_Parametro==3 or $ID_Parametro==6 or $ID_Parametro==15){ ?>
                                      <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Valor (*):</label>
                                        <input type="hidden" name="Valor" id="Valor">
                                        <input oncopy="return false" onpaste="return false" type="text" class="form-control" name="Valor" id="Valor" maxlength="40" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>"  onkeypress="return bloquearEspacio(event);" onkeypress="return validateInput(event);" required>
                                      </div>
                          <?php }     ?>

                          <?php
                          //Permitir MAYUSCULAS, Y ESPACIOS
                                if($ID_Parametro==5 or $ID_Parametro==8  or $ID_Parametro==12){ ?>
                                      <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Valor (*):</label>
                                        <input type="hidden" name="Valor" id="Valor">
                                        <input onpaste="return false" oncopy="return false" type="text" class="form-control" name="Valor" id="Valor" maxlength="65" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>" onkeypress="return /[a-zA-Z_\s]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" required>
                                      </div>
                          <?php }     ?>

                          <?php
                          //Permitir Y VALIDAR NUMEROS TELEFONICOS
                                if($ID_Parametro==13){ ?>
                                      <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Valor (*):</label>
                                        <input type="hidden" name="Valor" id="Valor">
                                        <input onpaste="return false" oncopy="return false"type="text" class="form-control" name="Valor" id="Valor" maxlength="65" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>" onkeypress="return /\d/.test(event.key)" oninput="validarTelefono(event)" required>
                                      </div>
                          <?php }     ?>

                          <?php
                          //Permitir MAYUSCULAS, PUNTOS, COMAS, Y ESPACIOS
                                if($ID_Parametro==14 ){ ?>
                                      <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Valor (*):</label>
                                        <input type="hidden" name="Valor" id="Valor">
                                        <input onpaste="return false" oncopy="return false" type="text" class="form-control" name="Valor" id="Valor" maxlength="90" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>" onkeypress="return /[a-zA-Z\s_,.]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();"  required>
                                      </div>
                          <?php }     ?>

                          <?php
                          $allowed_ids = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15); // Arreglo con los valores

                                if(!in_array($ID_Parametro, $allowed_ids)){ ?>
                                      <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Valor (*):</label>
                                        <input type="hidden" name="Valor" id="Valor">
                                        <input onpaste="return false" oncopy="return false" type="text" class="form-control" name="Valor" id="Valor" maxlength="40" placeholder="Ingrese el valor" value="<?php echo $Valor; ?>" onkeypress="this.value = this.value.toUpperCase();" required>
                                      </div>
                          <?php }     ?>



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" name="Enviar_P" value="AGREGAR"><i class="zmdi zmdi-upload"></i> Guardar</button>
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

  <script>
      
    //Validar Mayusculas, Minusculas, espacios y signo de interrogacion(¿,?)
    function validateInput(event) {
      const patron =  /^[a-zA-Z0-9\.\-_]+$/;
      const tecla = String.fromCharCode(event.keyCode || event.which);
      return patron.test(tecla);
      }

</script>

<script>
    //Validar Mayusculas, Minusculas, espacios
    function EspaciosMayus_Y_Minus(event) {
      const patron = /[A-Za-z\s]/;
      const tecla = String.fromCharCode(event.keyCode || event.which);
      return patron.test(tecla);
      }
  </script>

  
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
    window.location.href = "ParametrosAdm.php";
  });
}
</script> 

</body>
</html>
