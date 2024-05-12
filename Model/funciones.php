<?php
require __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$auxarray=explode("/",$_SERVER['REQUEST_URI']);

$urlws = "http://" . $_SERVER['SERVER_NAME'] . "/" . $auxarray[1] . "/api/ws.php";
function makeCurlRequest($params)
{
global $urlws;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlws);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$resp=curl_exec($ch);
$response =(object) json_decode($resp, true);
//var_dump($response);
curl_close($ch);
return $response;

}

function get_fotos_by_directory($directory){
    $directory="../View/".$directory;
    $fotos = array();
    $files = scandir($directory);
    foreach($files as $file){
        if (is_file($directory . "/" . $file)){
          // $fotos[]=$file;
          $fotos[]=["nombre"=>$file,"ruta"=>$directory . "/" . $file,"size"=>filesize($directory . "/" . $file)];
        }
    }

      
        return $fotos;
    }
//función para comprobar si el usuario es administrador
    function esadmin(){

        return (isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin");
    }
      
    //función que lee del fichero jwt.ini y genera un token
    function getToken($datos_usuario):string{
        $ini_array = parse_ini_file(__DIR__. "/../config/jwt.ini");
        $clave = $ini_array["jwt.clave"];
                // Configurar el token (tiempo de expiración, algoritmo de firma, etc.)
        $tiempo_expiracion = time() + (60 * 60); // 1 hora de expiración
        $algoritmo = 'HS256';

        // Generar el token JWT
        $token = JWT::encode($datos_usuario, $clave, $algoritmo);
        return $token;
    }
    //función que usando JWT recibe un token y lo valida
    function validaToken($token){
        $ini_array = parse_ini_file(__DIR__. "/../config/jwt.ini");
        $clave = $ini_array["jwt.clave"];
        $algoritmo = 'HS256';
        try {
            $datos = JWT::decode($token, new Key($clave, 'HS256'));

            return (array)$datos;
        } catch (Exception $e) {
            return false;
        }
    }
?>