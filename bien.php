<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">  
  <head>    
    <title>Inicio de Sesion</title>    
    <meta charset="UTF-8">
    <meta name="title" content="Inicio de Sesion">
    <meta name="description" content="Inicar sesion en el sistema de Control">    
    <link href="estilo.css" rel="stylesheet" type="text/css"/>  
    </head> 
    <body> 
    
  <form class="login-form" >
<H1 style="color:white">SISTEMA DE CONTROL</H1> 
  <p class="login-text">
    <span class="fa-stack fa-lg">
      <i class="fa fa-lock fa-stack-1x"></i>
    </span>
  </p>
  <p>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </p>

</form>

<a href="#" class="login-forgot-pass">From DAI</a>
<div class="underlay-photo"></div>
<div class="underlay-black"></div>  
</body>  
</html> 