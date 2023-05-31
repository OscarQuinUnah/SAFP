<?php  
    // Llamando a los campos
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $asuntos = $_POST['asuntos'];
    $mensaje = $_POST['mensaje']; 

    // Datos para el correo
    $destinatario = "esal282003@gmail.com";
    $asunto = "Deseo Contactarme Con la Asociacion";

    $carta = "De: $nombre \n";
    $carta .= "Correo: $correo \n";
    $carta .= "Telefono: $telefono \n";
    $carta .= "Asunto: $asuntos \n";
    $carta .= "Mensaje: $mensaje";

    // Enviando Mensaje
    mail($destinatario, $asunto, $carta);
    header('Location:Mensaje-enviado.html');
?>