<?php
require_once "../../EVENT_BITACORA.php";
$model = new EVENT_BITACORA;
session_start();
$model->entrarbackup();    
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
	<title>Backups</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../../css/main.css">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<!-- Funcion Confirmar para eliminar-->
  <script type="text/javascript">
    function confirmar(){
      return confirm('¿Está Seguro?, De eliminar la copia de seguridad del sistema');
    }
  </script>

<!-- Funcion confirmar para restarurar -->
<script type="text/javascript">
    function confirmar1(){
      return confirm('¿Está Seguro?, se restaurará la copia de seguridad del sistema');
    }
  </script>


<?php
// Datos de conexión a la base de datos

$host = "localhost";
$user = 'u511180871_root';
$password = '6L^yVk8Hd';
$database = 'u511180871_bd_asociacion';

// Comprobar si se hizo clic en el botón "Crear copia de seguridad"
if(isset($_POST['crear_copia_btn'])) {
  // Nombre del archivo de backup
  $conn = mysqli_connect($host, $user, $password, $database);
$backups_folder = "/home/u511180871/domains/asociacioncreoenti.com/public_html/Sistema/seguridad/Backups/";
  // Nombre del archivo de backup
  $backup_file = $backups_folder . $database ."-" . date("Y-m-d_H-i-s") . ".sql";
  
  // Comando de MySQL para hacer el backup
 // Obtener listado de tablas
 $tables = array();
 $result = mysqli_query($conn, "SHOW TABLES");
 while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
   $tables[] = $row[0];
 }
 
 // Generar archivo de backup
 $handle = fopen($backup_file, 'w');
 foreach ($tables as $table) {
   // Obtener definición de la tabla
   fwrite($handle, "DROP TABLE IF EXISTS `$table`;" . PHP_EOL); // Agrega la sentencia DROP TABLE
   $result = mysqli_query($conn, "SHOW CREATE TABLE `$table`");
   $row = mysqli_fetch_row($result);
   fwrite($handle, $row[1] . ";" . PHP_EOL);
 
   // Obtener contenido de la tabla
   $result = mysqli_query($conn, "SELECT * FROM `$table`");
   while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
     $fields = array();
     foreach ($row as $key => $value) {
       $fields[] = "`$key`='" . mysqli_real_escape_string($conn, $value) . "'";
     }
     fwrite($handle, "INSERT INTO `$table` SET " . implode(',', $fields) . ";" . PHP_EOL);
   }
   fwrite($handle, PHP_EOL);
 }
 
 fclose($handle);
 
 // Cerrar conexión
 mysqli_close($conn);
 
  // Comprobación de errores
  if (file_exists($backup_file)) {
    echo "<script language='JavaScript'>
                alert('Backup Creado con éxito, el archivo se a guardado dentro del servidor en /public_html/Sistema/seguridad/Backups/ y puedes seleccionarlo en los botones de abajo para restaurar la copia de seguridad o eliminar el archivo.');
            location.assign('Backups_BD.php');
            </script>";
            require_once "../../EVENT_BITACORA.php";
            $model = new EVENT_BITACORA;
            session_start();
            $model->backupcrea();

  } else {
    echo "<script language='JavaScript'>
                alert('Error al Crear el backup.');
            location.assign('Backups_BD.php');
            </script>";
  }
}

?>
</head>

<body>
<?php include '../sidebar.php'; ?>
<!-- Formulario para crear y restaurar una copia de seguridad -->
<section class="full-box dashboard-contentPage" style="overflow-y: auto;">
		<!-- Barra superior -->
		<nav class="full-box dashboard-Navbar">
			<ul class="full-box list-unstyled text-right">
				<li class="pull-left">
					<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
				</li>
			</ul>
		</nav>

    <div class="container" style="width:850px">
        <h1 style="text-align:center;" class="my-4">Administracion de Base de Datos</h1><hr>

         <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_consultar=1 and ID_Rol=$ID_Rol and ID_Objeto=12");
          if ($datos=$sql->fetch_object()) { ?>
        <!-- Inicio permiso insertar Copia de Seguridad -->
          <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Insercion=1 and ID_Rol=$ID_Rol and ID_Objeto=12");
          if ($datos=$sql->fetch_object()) { ?>
            <!-- Inicio formulario Copia de Seguridad -->
            <div class="card mb-4">
              <div class="card-header" style="background-color: #F6DDCC; font-family: Arial, sans-serif;">Copia de Seguridad</div>
              <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                <label>Preciona el boton si deseas realizar una Copia de Seguridad</label>
                  <div class="form-group" style="margin-top:10px">
                  <button class="btn btn-success" style="background-color: #28B463 ;" type="submit" name="crear_copia_btn">
                    <i class="	fas fa-cloud-download-alt"></i> Crear copia de seguridad
                  </button>
                  </div>
                </form>
              </div>
            </div><!-- Fin Copia de seguridad -->
          <?php } ?> <!-- Fin Del permiso de insercion -->

          <!-- Inicio permiso actualizar (restaurar) Copia de Seguridad -->
          <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Actualizacion=1 and ID_Rol=$ID_Rol and ID_Objeto=12");
          if ($datos=$sql->fetch_object()) { ?>
          <!-- Inicio formulario restaurar Copia de Seguridad -->
          <div class="card mb-4">
            <div class="card-header" style="background-color: #F6DDCC; font-family: Arial, sans-serif;"> Restaurar una Copia de Seguridad</div>
              <div class="card-body">
                <form action="restore.php" method="post">
                  <div class="form-group">
                    <label>Seleccionar el archivo a restaurar</label>
                    <select class="form-control" id="backup_file" name="backup_file">
                      <option value="">Seleccione un archivo</option>
                        <?php
                        // Ruta absoluta de la carpeta de backups
                        $backups_folder = "/home/u511180871/domains/asociacioncreoenti.com/public_html/Sistema/seguridad/Backups/";

                        // Obtener la lista de archivos de backup disponibles
                        $backup_files = glob($backups_folder . "*.sql");

                        // Mostrar la lista de archivos de backup en el formulario
                        foreach ($backup_files as $backup_file) {
                          echo "<option value=\"" . basename($backup_file) . "\">" . basename($backup_file) . "</option>";
                        }
                        ?>
                      </select>
                  </div>
                  <button type="submit" style="background-color: #2E86C1" class="btn btn-primary" onclick='return confirmar1()'> <i class="fa fa-upload"> </i> Restaurar Copia de Seguridad </button>
                  </form>
                </div>
          </div><!-- Fin restaurar Copia de seguridad -->
          <?php } ?><!-- Fin Del permiso de actualizar -->

            <!-- Inicio permiso eliminar Copia de Seguridad -->
            <?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Permiso_Eliminacion=1 and ID_Rol=$ID_Rol and ID_Objeto=12");
              if ($datos=$sql->fetch_object()) { ?>
              <!-- Inicio formulario eliminar Copia de Seguridad -->
              <div class="card mb-4">
                <div class="card-header" style="background-color: #F6DDCC; font-family: Arial, sans-serif;">Eliminar una Copia de Seguridad</div>
                <div class="card-body">
                  <form action="Eliminar_backup.php" method="post">
                    <div class="form-group">
                      <label>Seleccione el archivo a eliminar</label>
                      <select class="form-control" id="backup_file" name="backup_file" >
    
                            <option value="">Seleccione un Archivo </option>
                            <?php
                            // Ruta absoluta de la carpeta de backups
                            $backups_folder = "/home/u511180871/domains/asociacioncreoenti.com/public_html/Sistema/seguridad/Backups/";

                            // Obtener la lista de archivos de backup disponibles
                            $backup_files = glob($backups_folder . "*.sql");

                            // Mostrar la lista de archivos de backup en el formulario
                            foreach ($backup_files as $backup_file) {
                                echo "<option value=\"" . basename($backup_file) . "\">" . basename($backup_file) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-danger" style="background-color: #CB4335 ;" type="submit" onclick='return confirmar()'> <i class="fa fa-trash"> </i> Eliminar Copia de Seguridad</button>
                  </form>
                  </div>
                </div><!-- Fin eliminar Copia de seguridad -->
              <?php } ?><!-- Fin Del permiso eliminar -->    

      </div>
     </section>
  <?php } ?>
  
  <script src="../../js/Buscador.js"></script>
  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/events.js"></script>
	<script src="../../js/main.js"></script>
  
  </body>
</html>
