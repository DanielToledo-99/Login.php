<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // poner el nombre del usuario entre las comillas
define('DB_PASSWORD', ''); // poner el pass del usuario entre las comillas
define('DB_NAME', 'base_de_datos'); // poner el nombre de la base de datos entre las comillas

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME,
                   DB_USERNAME,
                   DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,
                       PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}
?>



