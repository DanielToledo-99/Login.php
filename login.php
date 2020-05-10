<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: bien.php");
    exit;
}
require_once "sesion.php";
$username = $password = "";
$username_err = $password_err = $validate_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if( ! trim($_POST["username"])){
        $username_err = "Por favor ingresa tu usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if( ! trim($_POST["password"])){
        $password_err = "Por favor ingresa tu contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT  usuario, contra FROM encargados
                WHERE usuario = :username";
   	 
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR); 
            $param_username = trim($_POST["username"]);
       	 
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["usuario"] = $username;                        
                            header("location: bienvenida.php");
                        } else{
                            $validate_err = "Credenciales erróneas.";
                        }
                    }
                } else{
                    $validate_err = "Credenciales erróneas.";
                }
            } else{
                echo "Algo salió mal. Intentar después.";
            }
        }
        unset($stmt);
    }
    unset($pdo);
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
    <body> 
  </head>     
  <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <H1 style="color:white">Inicio de sesion</H1> 
  <p class="login-text">
    <span class="fa-stack fa-lg">
      <i class="fa fa-lock fa-stack-1x"></i>
    </span>
  </p>

  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
  <label for="username">Usuario</label>
  <input type="text" name='username' class="login-username" class="form-control"  required="true" placeholder="Usuario" value="<?php echo $username; ?>" />
  <span class="help-block"><?php echo $username_err; ?></span>
  </div> 
  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"> 
  <label for="password">Contraseña</label>
 <input  type="password" name='password' class="login-password" required="true" placeholder="Contraseña" />
 <span class="help-block"><?php echo $password_err; ?></span>
 </div> 
 <div class="form-group <?php echo (!empty($validate_err)) ? 'has-error' : ''; ?>">
            <input type="submit" class="login-submit" value="Inicia sesión">
            <span class="help-block"><?php echo $validate_err; ?></span>
        </div>
            <p style="color:white">¿No tienes una cuenta? <a href="registro.php">Registrate aquí</a>.</p>

</form>
</div>
<a href="#" class="login-forgot-pass">From DAI</a>
<div class="underlay-photo"></div>
<div class="underlay-black"></div>  
</body>  
</html> 