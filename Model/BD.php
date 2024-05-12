<?php
class BD{
   
    public static function getConexion(){
        try{
            $rutaArchivoIni = __DIR__ . '/../config/bbdd.ini';

            $config = parse_ini_file($rutaArchivoIni);
            $dsn="mysql:host=" . $config["database.host"] . ";dbname=" . $config["database.dbname"] . ";";
           return  new PDO($dsn, $config["database.username"], $config["database.password"]);
    
        }catch(PDOException $e){
            $error="Error de base de datos: ";
            $error.= $e->getMessage();
            include ("../View/error.php");
            exit();
        }
 

    }
}
?>