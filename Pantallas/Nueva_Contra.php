<!DOCTYPE html>
<html lang="en">
<head>
<title>Cambio de Contraseña</title>
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
function bloquearEspacio(event) {
  var tecla = event.keyCode || event.which;
  if (tecla == 32) {
    return false;
  }
}
</script>
</head>
<body style="background: rgb(1,5,36);
            background: radial-gradient(circle, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 100%);">.


  
    <section style="width: 400px; height: auto; margin-bottom:35px; margin-top:35px;" class="f_login">

        <form class="New-Pass"  action="../Controladores/controlador_nueva_contra.php" method="post" enctype="multipart/form-data">

           <h2>Nueva Contraseña</h2>
            <div class="log_R">
            <img src="../img/asociacion.jpg"> 
            </div>
            
              <?php
              include ("../conexion_BD.php");
              
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

            <?php 
            if(isset($_GET['error'])) { ?>
             <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

                    

          <h3>Token</h3>
          <input class="controls" maxlength="20" type="text" id="token" name="token" onkeypress="return bloquearEspacio(event)" placeholder="Ingrese su Token" required><br>
        
          <h3>Nueva Contraseña</h3>
          <input class="controls" maxlength="<?php echo $Max_Pass ?>" type="password" id="contrasena_nueva" name="contrasena_nueva" onkeypress="return bloquearEspacio(event)"  placeholder="Ingrese su Nueva Contraseña" onpaste="return false" oncopy="return false"  required><br>
          <h3>Confirmar Nueva contraseña</h3>
          <input class="controls" maxlength="<?php echo $Max_Pass ?>" type="password" id="confirmar_contrasena" name="confirmar_contrasena" onkeypress="return bloquearEspacio(event)"  placeholder="Confirme su nueva Contraseña" onpaste="return false" oncopy="return false"  required><br>

          
          <input type="checkbox" id="mostrar_contrasena">
          <label for="mostrar_contrasena">Mostrar contraseñas</label>
              
          
          <button type="submit" class="btn btn-success" name="btn_enviar_New_Contra">Enviar</button>
          <!--<input class="btn btn-success" type="submit" name="btn_enviar_New_Contra" value="Actualizar"> -->
          <?php
          ?>


    </form>
            
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

      .modal-title{
        color: #000000;
        text-align: center;
        font-size: 20px;
        }
    
        .alert-danger p{
        margin-left: 15px;
        }
    
        .New-Pass h2{
            color: rgb(20, 19, 19);
            font-weight: 600;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    
        .New-Pass h3{
            color: #000000;
            text-align: justify;
            font-size: 20px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    
    
        .btn-success{
            background-color: rgb(1, 49, 7);
            width: 100%;
            height: 40px;
            border: none;
            margin-bottom: 16px;
            
        }

    
        .New-Pass input{
            color: black;
            margin-bottom: 10px;
            background-color: #c1ffcc;
        }

        .btn-success input{
          color: rgb(255, 255, 255);
        }

        .New-Pass button{
            color: rgb(255, 255, 255);

        }


    </style>

    <script>//Mostrar las mayusculas
      var mostrarContrasena = document.getElementById("mostrar_contrasena");
      var contrasena2 = document.getElementById("contrasena_nueva");
      var contrasena3 = document.getElementById("confirmar_contrasena");
      
      mostrarContrasena.addEventListener("click", function() {
        if (mostrarContrasena.checked) {
          contrasena2.type = "text";
          contrasena3.type = "text";
        } else {
          contrasena2.type = "password";
          contrasena3.type = "password";
        }
      });
    </script>






   
</body>

</html>