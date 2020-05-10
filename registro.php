<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:hola.php");
    exit;
}

require_once "sesion.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if( ! trim($_POST["username"])){
        $username_err = "Por favor ingresa el nombre del usuario.";
    } else{
        $sql = "SELECT nombre FROM encargados WHERE usuario = :username";
   	 
        if($stmt = $pdo->prepare($sql)){    
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);

        	if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "El usuario ya existe.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Algo salió mal. Intentar después.";
            }
        }
        unset($stmt);
    }

    if( ! trim($_POST["password"])){
        $password_err = "Por favor ingresa una contraseña.";	 
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if( ! trim($_POST["confirm_password"])){
        $confirm_password_err = "Por favor confirma la contraseña.";	 
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
    
    if(empty($username_err) &&
       empty($password_err) &&
       empty($confirm_password_err)){
        
        $sql = "INSERT INTO encargados (usuario, contra)
                VALUES (:username, :password)";
    	 
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
       	 
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);       	 
            if($stmt->execute()){
                header("location: login.php");
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
</head> 
<body>


<form class="login-form"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<H1 style="color:white">Registro</H1> 
    <p style="color:white">Por favor ingresa tus datos</p>
<p class="login-text">
    <span class="fa-stack fa-lg">
      <i class="fa fa-lock fa-stack-1x"></i>
    </span>
  </p>
    <input type="email" name='username' class="login-username"  required="true" placeholder="Usuario" value="<?php echo $username; ?>"> 
    <span class="help-block"><?php echo $username_err; ?></span>
    <input type="password" name="password" class="login-username" required="true" placeholder="Contraseña" value="<?php echo $password; ?>">
    <span class="help-block"><?php echo $password_err; ?></span>
    <div class="login-username <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
    <input type="password" name="confirm_password" class="login-username" placeholder="Confrimar Contraseña" value="<?php echo $confirm_password; ?>">
    <span class="help-block"><?php echo $confirm_password_err; ?></span>

            <input type="submit" class="btn btn-primary" value="Enviar">
            <input type="reset" class="btn btn-default" value="Borrar">

        <p style="color:white">¿Ya estás registrado? <a style="color:white" href="login.php">Accede aquí</a>.</p>
        </form>
<a href="#" class="login-forgot-pass">From DAI</a>
<div class="underlay-photo"></div>
<div class="underlay-black"></div>  
</body>  
</html> 