<!DOCTYPE html>
<html lang="en">
<head>
<title> Registro de Preguntas </title>
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
    
    <link rel="stylesheet" media="screen and (min-device-width: 1025px) and (max-width: 1440px)" href="../css/desktop-style.css" />
    <!-- Para Celular -->
    <link rel='stylesheet' media='screen and (min-width: 100px) and (max-width: 767px)' href='../css/mobile-style.css' />
    <!-- Para Tablet -->
    <link rel='stylesheet' media='screen and (min-width: 768px) and (max-width: 1024px)' href='../css/medium-style.css' />
</head>
<body style="background: rgb(1,5,36);
            background: radial-gradient(circle, rgba(1,5,36,1) 0%, rgba(50,142,190,1) 100%);">

<section style="width: 400px; height: 400px; margin-bottom:40px; margin-top:70px;" class="primer_i">

<form class="content" action="../Controladores/Mas_Preguntas.php" method="post" enctype="multipart/form-data">
<?php 
    if(isset($_GET['error'])) { ?>
     <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php
     include ("../conexion_BD.php");
     //require ("preguntas.php");
$sql=$conexion->query("SELECT * FROM tbl_preguntas");
?>

<h3 style="margin-top:40px; margin-bottom:30px; text-align:center ">Seleccione una pregunta</h3>
<select class="controls" type="text" name="Pregunta" required ><br>
    <?php
while($row=mysqli_fetch_array($sql)){
?>
         <option value="<?php echo $row['ID_Pregunta'];?>"><?php echo $row['Pregunta'];?></option>
  <?php
  }
?>

<input onpaste="return false" oncopy="return false" onkeypress="return /[a-zA-Z0-9\-\_]/i.test(event.key)" oninput="this.value = this.value.toUpperCase();" class="controls" type="text" name="respuesta" placeholder="Ingrese la Respuesta "><br>

<input class="buttons" type="submit" Class="btn" name="btn_enviar_M_P" value="Enviar"> 
</form>
</section>
</html>