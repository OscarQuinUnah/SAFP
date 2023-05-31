<!DOCTYPE html>
<html lang="en">
<head>
<title> Nueva contraseña </title>
    <link rel="stylesheet" href="../css/normalize.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&family=Staatliches&display=swap" rel="stylesheet">
    
    <!--Libreria de bosstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!-- Preload -->
    <link rel="preload" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/normalize.css">

    <link rel="preload" href="../css/style.css">
    <link rel="stylesheet" href="../css/style.css">


</head>
<body  style="background: rgb(1,5,36);
            background: radial-gradient(circle, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 100%);">
        <section style="width: 400px; height: auto; margin-bottom:35px; margin-top:35px; " class="primer_i">

        <form id="formulario_contra" class="contra1" method="POST" action="../Controladores/New_pass_pregun.php" enctype="multipart/form-data"  onsubmit="return validarFormulario()">
          <?php 
              if(isset($_GET['error'])) { ?>
              <p class="error"><?php echo $_GET['error']; ?></p>
              <?php } ?>

              <?php
              include ("../conexion_BD.php");
              //include("../Controladores/New_pass_pregun.php")
              
                $sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro` in (9,10)");
                // Verificar si la consulta devolvió resultados
                if (mysqli_num_rows($sql2) >= 1) {
                    // Recorrer los resultados y mostrarlos en pantalla
                    while($row = mysqli_fetch_array($sql2)) {
                      if ($row['ID_Parametro'] == 9) {
                        $Min_Pass=$row['Valor'];
                    } 

                        if ($row['ID_Parametro'] == 10) {
                            $Max_Pass=$row['Valor'];
                        }     
                    }
                }
              ?>

      

          <span class="fas fa-user-lock"></span>
          <h2> Es necesario un cambio de contraseña</h2>
         <!--  <small id="passwordHelp" class="form-text text-muted">La contraseña debe tener al menos 8 caracteres, una letra minúscula, una letra mayúscula y un número.</small>-->
         <?php
         include("../Controladores/New_pass_pregun.php");
         ?>
          
          <h3>Ingrese una nueva contraseña</h3>
          <input class="controls" type="password" name="p_contranueva" id="contranueva" maxlength="<?php echo $Max_Pass ?>" placeholder="Ingrese la Contraseña Nueva" onpaste="return false" oncopy="return false" onkeypress="return bloquearEspacio(event);" required><br>

          <h3>Confirma tu nueva contraseña</h3>
          <input onpaste="return false" oncopy="return false" class="controls" type="password" name="p_confir_contranueva" id="confir_contranueva" maxlength="<?php echo $Max_Pass ?>" placeholder="Confirmacion de la nueva contraseña" onkeypress="return bloquearEspacio(event);" required><br>
          
          <input type="checkbox" id="mostrar_contrasena">
            <label for="mostrar_contrasena">Mostrar contraseñas</label>


        <button type="submit" class="btn btn-success" name="btn_enviar_P">Enviar</button>
        </form>

        </section>

        <section ><!-- Mensaje modal si las contraseñas no coinciden-->
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Advertencia</h4>
              </div>
              <div class="alert alert-danger" >
                <p>Las contraseñas no coinciden.</p>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
         </div>
        </section>

   
     
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


  .modal-title{
      color: #000000;
      text-align: center;
      font-size: 20px;
  }

  .alert-danger p{
      margin-left: 15px;
  }

      .contra1 h2{
          color: rgb(20, 19, 19);
          font-weight: 600;
          text-align: center;
          font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      }

      .contra1 h3{
          color: rgb(240, 235, 235);
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

      .contra1 input{
          color: black;
      }

      .fa-eye{
          color: black;
      }

      .contra1 span{
          color: rgb(1, 49, 7);
          text-align: center;
          font-size: 90px;
          display: block;
          margin-top:20px;
      }
    
</style> 

<script>//Mostrar las contraseñas
  var mostrarContrasena = document.getElementById("mostrar_contrasena");
      var contrasena1 = document.getElementById("contranueva");
      var contrasena2 = document.getElementById("confir_contranueva");

      
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

<script>//No permitir espacios en las contraseñas
        function bloquearEspacio(event) {
        var tecla = event.keyCode || event.which;
        if (tecla == 32) {
            return false;
        }
        }
</script>

<script>//Validar que las contraseñas sean iguales

  function validarFormulario() {
    var password1 = document.getElementById("contranueva").value;
    var password2 = document.getElementById("confir_contranueva").value;

    if (password1 != password2) {
      $('#myModal').modal('show');
      return false;
    }
    
  }

 
</script>


</html>
