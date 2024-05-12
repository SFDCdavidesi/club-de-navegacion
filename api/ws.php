<?php
if (session_status() == PHP_SESSION_NONE) {
    // Si no hay una sesión activa, inicia una nueva sesión
    session_start();
}


  header('Content-Type: text/html; charset=utf-8');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

  require_once("../Model/BD.php");
  require_once("../Model/usuarios_bd.php");
    require_once("../Model/cursos_bd.php");
    require_once("../Model/calendario_bd.php");
    require_once("../Model/funciones.php");


    $action = (isset($_REQUEST["action"])?$_REQUEST["action"]:"");
    //obtenemos las variables que vienen por POST
    $nombreUsuario=(isset($_REQUEST["nombreUsuario"])?$_REQUEST["nombreUsuario"]:"");
    $nombre=(isset($_REQUEST["nombre"])?$_REQUEST["nombre"]:"");
    $apellidos=(isset($_REQUEST["apellidos"])?$_REQUEST["apellidos"]:"");
    $email=(isset($_REQUEST["email"])?$_REQUEST["email"]:"");
    $telefono = (isset($_REQUEST["telefono"])?$_REQUEST["telefono"]:"");
    $rol=(isset($_REQUEST["rol"])?$_REQUEST["rol"]:"");
    $password=(isset($_REQUEST["password"])?$_REQUEST["password"]:"");
    $password2=(isset($_REQUEST["password2"])?$_REQUEST["password2"]:"");
    $titulo=(isset($_REQUEST["titulo"])?$_REQUEST["titulo"]:"");
    $descripcion=(isset($_REQUEST["descripcion"])?$_REQUEST["descripcion"]:"");
    $nivel_requerido=(isset($_REQUEST["nivel_requerido"])?$_REQUEST["nivel_requerido"]:"");

    $duracion=(isset($_REQUEST["duracion"])?$_REQUEST["duracion"]:"");
    $medida_tiempo=(isset($_REQUEST["medida_tiempo"])?$_REQUEST["medida_tiempo"]:"");
    $ubicacion=(isset($_REQUEST["ubicacion"])?$_REQUEST["ubicacion"]:"");
    $numero_plazas=(isset($_REQUEST["numero_plazas"])?$_REQUEST["numero_plazas"]:"");
    $inscritos=(isset($_REQUEST["inscritos"])?$_REQUEST["inscritos"]:"");
    $id=(isset($_REQUEST["id"])?$_REQUEST["id"]:"");
    $duracion=(isset($_REQUEST["duracion"])?$_REQUEST["duracion"]:"");
    $entradilla=(isset($_REQUEST["entradilla"])?$_REQUEST["entradilla"]:"");
    $unidadDuracion=(isset($_REQUEST["unidadDuracion"])?$_REQUEST["unidadDuracion"]:"");
    $activos=(isset($_REQUEST["activos"])?$_REQUEST["activos"]:"");
    $nombreusuario=(isset($_REQUEST["nombreusuario"])?$_REQUEST["nombreusuario"]:"");
    if (isset($_REQUEST["nombreUsuario"]) && $_REQUEST["nombreUsuario"]!=null){
        $nombreUsuario=$_REQUEST["nombreUsuario"];
    }
    if (isset($nombreUsuario)){
        $nombreusuario=$nombreUsuario;
    }
//datos para alta de curso y calendario
    $curso=(isset($_REQUEST["curso"])?$_REQUEST["curso"]:"");
    $nivel=(isset($_REQUEST["nivel"])?$_REQUEST["nivel"]:"");
    $plazas=(isset($_REQUEST["plazas"])?$_REQUEST["plazas"]:"");
    $fecha=(isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"");
    $activo=(isset($_REQUEST["activo"])?$_REQUEST["activo"]:"");
  
    $unidad_medida=(isset($_REQUEST["unidad_medida"])?$_REQUEST["unidad_medida"]:"");
    $precio=(isset($_REQUEST["precio"])?$_REQUEST["precio"]:"");

    $mes=(isset($_REQUEST["mes"])?$_REQUEST["mes"]:"");
    $anio=(isset($_REQUEST["anio"])?$_REQUEST["anio"]:"");
    $token=(isset($_REQUEST["token"])?$_REQUEST["token"]:"");
    $idCalendario=(isset($_REQUEST["idCalendario"])?$_REQUEST["idCalendario"]:"");
    $id_usuario_curso=(isset($_REQUEST["id_usuario_curso"])?$_REQUEST["id_usuario_curso"]:"");
    $campo=(isset($_REQUEST["campo"])?$_REQUEST["campo"]:"");
    $valor=(isset($_REQUEST["valor"])?$_REQUEST["valor"]:"");
    $usuario_valido=false;
    if (isset($token)&& $token!=null)
    {
        $usuario_valido=validaToken($token);
    } 

    switch($action){
        case "get_fotos_curso":
            $resultArray=get_fotos_curso($id);
            break;
        case "get_nivel_requerido":
            $resultArray=get_niveles_by_id($id);
            break;
        case "get_calendarios":
            
            $resultArray=get_calendarios_by_month_and_year($mes,$anio);
            break;
        case "crea_usuario":
         //   $resultArray=upsert_usuario($nombreUsuario,$password,$nombre,$apellidos,$email,$rol);
            $resultArray=insertar_usuario($nombreUsuario,$password,$nombre,$apellidos,$email,$telefono,$rol);
            break;
        case "login":
            $resultArray=comprueba_usuario($nombreUsuario,$password);
            if ($resultArray["id"]==1){ //si el login es correcto, guardamos la sesión
                $_SESSION["usuario"]=$nombreUsuario;
                $_SESSION["rol"]=$resultArray["rol"];
                $_SESSION["id_usuario"]=$resultArray["id_usuario"];
                $datos_usuario=array("id"=>$resultArray["id_usuario"],"nombre"=>$nombreUsuario,"rol"=>$resultArray["rol"]);
                $_SESSION["token"]=getToken($datos_usuario);
            }
            break;
        case "alta_calendario":
            $resultArray=alta_calendario($curso,$nivel,$plazas,$fecha,$activo,$precio,$duracion,$unidad_medida);
            break;
        case "inscribir":
            if ($usuario_valido){
                $resultArray=inscribirUsuarioEnCalendario($idCalendario);

            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;
       case "actualiza_curso":
       $actualizandocurso=1;
        case "alta_curso":
            $arrayAltaCurso=array("titulo"=>$titulo,"entradilla"=>$entradilla,"descripcion"=>$descripcion,"nivel_requerido"=>$nivel_requerido,"duracion"=>$duracion,"medida_tiempo"=>$unidadDuracion,"lugar_id"=>$ubicacion,"numero_plazas"=>$numero_plazas,
            "activo"=>$activo,
            "inscritos"=>$inscritos);
            $fotosSeleccionadas=$_POST["fotos"];
            if (isset($actualizandocurso) && $actualizandocurso==1){
                $resultArray=upsert_curso($arrayAltaCurso,$fotosSeleccionadas,$id);
            }else{
                          
            $resultArray=upsert_curso($arrayAltaCurso,$fotosSeleccionadas,null);
                        }
            break;
        case "borrar_curso":
            $resultArray=borrar_curso($id);
            break;
        case "docambiarcontraseña":
            $resultArray=actualizarcontraseña($token,$password,$password2);
            break;
       case "recuperarcontraseña":
            $resultArray=recuperar_contraseña($nombreusuario,$email);
            break;
        case "actualiza_datos_curso":
            if ($usuario_valido!=false && $usuario_valido["rol"]=="admin"){
                $resultArray=actualiza_datos_curso($id_usuario_curso,$campo,$valor);
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;
        case "get_asistentes_cursos":
            if ($usuario_valido!=false && $usuario_valido["rol"]=="admin"){
                $resultArray=get_cursos_by_usuario(null);
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;

        case "get_mis_cursos":
            if ($usuario_valido!=false){
                $resultArray=get_cursos_by_usuario($usuario_valido["id"]);
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;
        case "get_usuario":
            if ($usuario_valido!=false && $usuario_valido["rol"]=="admin"){
                $resultArray=get_usuario_by_id($id);
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;

        case "get_usuarios":
            if ($usuario_valido!=false && $usuario_valido["rol"]=="admin"){
                $resultArray=get_usuario_by_id(null);
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;
        case "modificar_usuario":
            if ($usuario_valido!=false && $usuario_valido["rol"]=="admin"){
                $resultArray=actualiza_usuario($id,$nombreUsuario,$password,$nombre,$apellidos,$email,$telefono,$rol);
         
            }else{
                $resultArray=array("error"=>"Usuario no válido");
            }
            break;
        case "get_curso": //sólo un curso
             $resultArray=get_cursos_by_id($id);
            break;
        case "get_niveles":
            foreach(get_niveles_by_id(null) as $nivel){
                $resultArray[]=$nivel;
            }
            break;
        case "get_roles":
            foreach(get_roles_by_id(null) as $rol){
                $resultArray[]=$rol;
            }
            break;
        case "get_cursos":

            foreach(get_cursos_by_id(null) as $curso){
                if ($activos=="true"){
                    if (  $curso["activo"]==1){
                        $resultArray[]=$curso;
                    }
                    
                }else{
                    $resultArray[]=$curso;
                }

               
            }
            break;
        default:
            $resultArray=array("error"=>"No se ha encontrado la acción");
            break;

    }
   // $json = json_encode($resultArray,JSON_PRETTY_PRINT);
    
    /* Output header */
        header('Content-type: application/json');
       echo  json_encode($resultArray, JSON_PRETTY_PRINT);
        
  ?>