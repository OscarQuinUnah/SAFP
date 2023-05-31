<!DOCTYPE html>
<html lang="en">
<head>
<title> Recuperar Contraseña </title>
    <link rel="stylesheet" href="../css/normalize.css">
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
</head>
<body style="background: rgb(1,5,36);
            background: radial-gradient(circle, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 100%);">
    
    <section style="width: 400px; height: auto; margin-bottom:35px" class="f_login">
            
    <form  class="contra1" action="../Controladores/recupera_contra_pregunta.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <h2>Recuperacion de Contraseña</h2><div class="log_R">
            <img src="../img/asociacion.jpg"> 
            </div>
            <?php
    include ("../conexion_BD.php");
    //include ("../Controladores/recupera_contra_pregunta.php");
 
    ?>
            <?php if(isset($_GET['error'])) { ?>
             <p class="error"><?php echo $_GET['error']; ?></p>
            <?php }
             ?>
              <?php

    
    
            /* $user=$_POST['Usuario_Recupera'];
               session_start();
    $_SESSION['usuario']=$user;*/
        $sql=$conexion->query("SELECT * FROM tbl_preguntas");
        ?>

 <!-- comienza el while -->
            <i class="fas fa-user-alt"></i>
            <input style="text-transform:uppercase" onkeypress="validarMayusculas(event)" onpaste="return false" oncopy="return false" class="controls" type="text" name="Usuario_Recupera" placeholder="Ingrese el Usuario" required>
         

        <h3>Seleccione una pregunta</h3>
        <select class="controls" type="text" name="Pregunta" required ><br>
            <?php
        while($row=mysqli_fetch_array($sql)){
        ?>
                 <option value="<?php echo $row['ID_Pregunta'];?>"><?php echo $row['Pregunta'];?></option>
          <?php
          }
        ?>

        <input onpaste="return false" oncopy="return false" onkeypress="return /[a-zA-Z0-9\-\_]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" class="controls" type="text" required name="respuesta" placeholder="Ingrese la Respuesta "><br>
     <!-- TERMINA EL WHILE -->

        <!-- <h3>Debe de Realizar cambio de contraseña</h3>-->
        <!--<input class="controls" type="password" name="contranueva" id="contranueva1" required placeholder="Ingrese la Contraseña Nueva " onkeypress="return bloquearEspacio(event);" required><br>-->
        <!-- <input class="controls" type="password" name="contranueva2" id="contranueva2" required placeholder="Ingrese la Contraseña Nueva " onkeypress="return bloquearEspacio(event);" required><br>-->
        

       
        <input class="buttons" type="submit" class="btn" name="btn_enviar_R" value="Enviar"> 


    </form>
    <section>
    <li><a href="../Pantallas/renovar-Contra.php">Volver Atras</a></li>

 

</body>

<style>
       /* Ocultamos el checkbox original */
 input[type=checkbox] {
    display: none;

  }

  /* Estilo del checkbox personalizado */
  label {
    display: inline-block;
    position: relative;
    padding-left: 25px;
    margin-right: 10px;
    cursor: pointer;
    font-size: 16px;
    color: #002406;
    margin-top: 2px;
    margin-bottom: 20px;
    
  }

  /* Estilo del "tick" del checkbox */
  label:before {
    content: "";
    display: inline-block;
    position: absolute;
    left: 0;
    
    width: 16px;
    height: 16px;
    border: 1px solid #bbb;
    background-color: #def7a5;
  }

  /* Estilo del "tick" del checkbox cuando está seleccionado */
  input[type=checkbox]:checked + label:before {
    content: "\2713";
    color: #08e95e;
    font-size: 16px;
    text-align: center;
    line-height: 16px;
    background-color: #181717;
    border: 1px solid #bbb;
  }
     
</style>


<script>//Mostrar las contraseñas
  var mostrarContrasena = document.getElementById("mostrar_contrasena");
      var contrasena1 = document.getElementById("contranueva1");
      var contrasena2 = document.getElementById("contranueva2");

      
      mostrarContrasena.addEventListener("click", function() {
        if (mostrarContrasena.checked) {
          contrasena1.type = "text";
          contrasena2.type = "text";
        } else {
          contrasena1.type = "password";
          contrasena2.type = "password";
        }
      });
</script>

<script>//No permitir espacios
        function bloquearEspacio(event) {
        var tecla = event.keyCode || event.which;
        if (tecla == 32) {
            return false;
        }
        }
</script>

<script>//Validar Mayusculas
		function validarMayusculas(e) {
			var tecla = e.keyCode || e.which;
			var teclaFinal = String.fromCharCode(tecla).toUpperCase();
			var letras = /^[A-Z]+$/;

			if(!letras.test(teclaFinal)){
				e.preventDefault();
			}
		}
</script>




</html>