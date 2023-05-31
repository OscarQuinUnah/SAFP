<!DOCTYPE html>
<html lang="en">
<head>
<title> Recuperar contraseña </title>
    <link rel="stylesheet" href="css/normalize.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&family=Staatliches&display=swap" rel="stylesheet">
    <!-- Preload -->
    <link rel="preload" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/normalize.css">

    <link rel="preload" href="../css/style.css">
    <link rel="stylesheet" href="../css/style.css">


    <script>
		function validarMayusculas(e) {
			var tecla = e.keyCode || e.which;
			var teclaFinal = String.fromCharCode(tecla).toUpperCase();
			var letras = /^[A-Z]+$/;

			if(!letras.test(teclaFinal)){
				e.preventDefault();
			}
		}
	</script>


</head>
<body style="background: rgb(1,5,36);
            background: radial-gradient(circle, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 100%);">

    <section style="width: 400px; height: auto; margin-bottom:35px" class="f_login">
            
    <form class="content" action="../Controladores/recupera_contra_correo.php" method="post" enctype="multipart/form-data">
            <h2>Recuperacion de Contraseña</h2>         
            <div class="log_R">
            <img src="../img/asociacion.jpg"> 
            </div>
            <?php
            
    include ("../conexion_BD.php");
    include ("../Controladores/recupera_contra_correo.php");
    ?>
            <?php if(isset($_GET['error'])) { ?>
             <p class="error"><?php echo $_GET['error']; ?></p>
            <?php }
             ?>
             


            <i class="fas fa-user-alt"></i>
            <input onkeypress="validarMayusculas(event)" style="text-transform:uppercase" class="controls" type="text" name="Usuario_Recupera" placeholder="Ingrese el Usuario" onpaste="return false" oncopy="return false" required>
         


       <input class="buttons" type="submit" Class="btn" name="btn_enviar_C" value="Enviar Correo"> 
       
    </form>
    <section>
    <li><a href="../Pantallas/renovar-Contra.php">volver atras</a></li>
</body>

</html>