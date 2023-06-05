<?php
// Obtener el nombre del archivo de backup a eliminar
$backup_file = $_POST['backup_file'];

// Ruta absoluta del archivo de backup a eliminar
$backup_file_path = "/home/u221487857/domains/asociacionasfp.site/public_html/Sistema/seguridad/Backups/" . $backup_file;

// Eliminar el archivo de backup
if (unlink($backup_file_path)) {
    echo "<script language='JavaScript'>
                alert('El archivo de backup ha sido eliminado exitosamente.');
            location.assign('Backups_BD.php');
            </script>";
            require_once "../../EVENT_BITACORA.php";
            $model = new EVENT_BITACORA;
            session_start();
            $model->backuDEL();
} else {
    echo "<script language='JavaScript'>
                alert('Ha ocurrido un error al intentar eliminar el archivo de backup.');
            location.assign('Backups_BD.php');
            </script>";
}
?>
