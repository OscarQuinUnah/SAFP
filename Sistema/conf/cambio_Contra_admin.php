<?php
require '../../conexion_BD.php';
/*esta variable impide que se pueda entrar al sistema principal si no se entra por login (crea un usuario global) */
require_once "../../EVENT_BITACORA.php";
session_start();
$usuario=$_SESSION['user'];
$ID_usuario = $_SESSION['ID_User'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<style></style>
	<title>Cambio Contraseña</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


<script>
	function impedirPegar(event) {
  event.preventDefault(); // Impide la acción predeterminada de pegar el texto
}
function mostrarContrasenaGU() {
      let C_contra_A = document.getElementById("C_contra_A");
      let C_contra_N= document.getElementById("C_contra_N");
      let C_contra_N_2= document.getElementById("C_contra_N_2");
      if (C_contra_A.type == "password") {
          C_contra_A.type = "text";
          C_contra_N.type = "text";
      C_contra_N_2.type = "text";
      } else {
      C_contra_A.type = "password";
          C_contra_N.type = "password";
      C_contra_N_2.type = "password";
      }
    }

</script>

<style>
    form {
  background-color: #B1DCDC; /* color de fondo del formulario */
  border: 0.5px solid #000000; /* borde del formulario */
  padding: 20px; /* espacio alrededor del formulario */
  width: auto; /* ancho del formulario */
  height: auto; /* altura del formulario */
  
  
  justify-content: center;
  align-items: center;
}

body {
   
    align-items: center;
    background-color: #007A7A; /* color de fondo de la página */
}

.modal-title{
      color: #000000;
      text-align: center;
      font-size: 20px;
  }

  .alert-danger p{
      margin-left: 15px;
  }


</style>

</head>
<body>
    <section>
        <div class="container">
            <div class="row">
                <!-- Columna de datos personales -->
                <div class="mx-auto my-4" class="col-lg-6">
                    <h2 style="margin-top:20px; font-weight=20px; color:#E2E9F0; text-align:center" class="font-weight-bold pb-2 border-bottom">Cambio de Contraseña</h2>
                    <form  actions2="Controlador_C_contra_admin.php" method="post" style="overflow-y: auto;">
                        <?php
                            include("Controlador_C_Contra_admin.php");
                        ?>
                            <div class="form-group">
                            <label for="nombre">Antigua Contraseña: </label>
                            <input class="form-control" type="password" maxlength="20" name="C_contra_A" id="C_contra_A" onkeypress="return bloquearEspacio(event)"  onpaste="impedirPegar(event)" placeholder="Ingrese su antigua Contraseña" require>
                            </div>
                            
                            <?php
                                $sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro`=10");
                                // Verificar si la consulta devolvió resultados
                                if (mysqli_num_rows($sql2) >= 1) {
                                    // Recorrer los resultados y mostrarlos en pantalla
                                    while($row = mysqli_fetch_array($sql2)) {
                                        if ($row['ID_Parametro'] == 10) {
                                            $Max_Pass=$row['Valor'];
                                        }     
                                    }
                                }
                            ?>

                            <div class="form-group">
                            <label for="nombre">Nueva Contraseña: </label>
                            <input class="form-control" type="password" maxlength="<?php echo $Max_Pass ?>" name="C_contra_N" id="C_contra_N" onkeypress="return bloquearEspacio(event)" onpaste="impedirPegar(event)" placeholder="Ingrese su nueva Contraseña" require>
                            </div>

                            <div class="form-group">
                            <label for="nombre">Confirmar nueva Contraseña: </label>
                            <input class="form-control" type="password" maxlength="<?php echo $Max_Pass ?>" name="C_contra_N_2" id="C_contra_N_2" onkeypress="return bloquearEspacio(event)" onpaste="impedirPegar(event)" placeholder="Confirmar Nueva contraseña" require>
                            </div>

                            <button type="button" class="zmdi zmdi-eye-off" onclick="mostrarContrasenaGU()"></button>

                            <input style="margin-left:30px " type="submit" class="btn btn-success" name="btn_enviar_N_Contra" value="Cambiar contraseña">

                    </form><!-- Fin del formulario -->

                </div><!-- Fin col-lg-6 -->

            </div><!-- Fin row-->
        </div><!-- Fin container -->

    </section>

	<!--script en java para los efectos-->
	<script src="../../js/Buscador.js"></script>
	<script src="../../js/jquery-3.1.1.min.js"></script>
	<script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
    <script src="../../js/usuario.js"></script>


</body>
</html>
