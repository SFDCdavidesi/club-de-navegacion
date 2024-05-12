<?php
    session_start();

    require('../Model/BD.php');
    require("../Model/usuarios_bd.php");
    require("../Model/cursos_bd.php");
    require_once ("../Model/funciones.php");


 
    $action = (isset($_REQUEST["action"])?$_REQUEST["action"]:"");
    $usuario=(isset($_REQUEST["nombreUsuario"])?$_REQUEST["nombreUsuario"]:"");
    $password=(isset($_REQUEST["password"])?$_REQUEST["password"]:"");
    $nombre=(isset($_REQUEST["nombre"])?$_REQUEST["nombre"]:"");
    $apellidos=(isset($_REQUEST["apellidos"])?$_REQUEST["apellidos"]:"");
    $email=(isset($_REQUEST["email"])?$_REQUEST["email"]:"");
    $rol=(isset($_REQUEST["rol"])?$_REQUEST["rol"]:"");
    $token=(isset($_REQUEST["token"])?$_REQUEST["token"]:"");




    switch($action) {
        case "login": 

            include('../View/login.php');
            break;
        case "editar_usuario":
            //mostramos la página del usuario donde se podrá editar
            //validamos que el usuario tenga permisos para editar
            if (isset($_SESSION) && isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin"){
  
            include('../View/editar_usuarios.php');
            }else{
                header("Location: .?action=menu_principal");
            }
            break;
        case "ver_mis_cursos":
            //mostramos la página del usuario donde se mostrarán todos sus cursos
            include('../View/mis_cursos.php');
            break;

        case "crea_usuario": 
            $params = array("action"=>"crea_usuario",
                            "nombreUsuario"=>$usuario,
                            "password"=>$password,
                            "nombre"=>$nombre,
                            "apellidos"=>$apellidos,
                            "email"=>$email,
                            "rol"=>$rol);
            $response= makeCurlRequest($params);
          
         
            break;
        case "logout": 
            borra_sesion($_SESSION["usuario"]);
            header("Location: .?action=menu_principal");

            break;
        case "guarda_sesion":
            $usuario=$_POST["usuario"];
            $rol=$_POST["rol"];
            if(validaUsuarioRol($usuario,$rol)){
                $_SESSION["usuario"]=$usuario;
                $_SESSION["rol"]=$rol;
                $arrayResultado=array("id"=>1,"mensaje"=>"Sesión guardada correctamente");
            }else{
                $arrayResultado=array("id"=>0,"mensaje"=>"Error guardando la sesión");
            }
            $json= json_encode($arrayResultado);
            /* Output header */
                header('Content-type: application/json');
               echo  json_encode($json, JSON_PRETTY_PRINT);
            
            break;
            case "cambiarcontraseña":
                include ("../View/cambiarcontraseña.php");
                break;
            case "recuperarcontraseña":
                include ("../View/recuperarcontraseña.php");
                break;
            case "inscripcion":
                if (isset($_SESSION) && isset($_SESSION['rol']) ) {
            
                include ("../View/inscripcion.php");
                }else{
                    header("Location: .?action=menu_principal");
                }
                break;
            case "alta_actividades":
             
                include ("../View/alta_calendario.php");
                break;
                
                case "ver_cursos":
                    $verFormularioGestionCursos=false;
                    $mostrarheaderyfooter=true;
                    include ("../View/listado_cursos.php");
                    break;
                case "calendario":
                    if (isset($_SESSION) && isset($_SESSION['rol']) ) {
                        $verFormularioGestionCursos=true;
                    }
                    include ("../View/calendario.php");
                    break;
    case "gestion_usuarios":
        $mostrarheaderyfooter=false;
        include('../View/gestion_usuarios.php');
        break;
    case "asistentes_cursos":
        if (isset($_SESSION) && isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin"){
            $mostrarheaderyfooter=false;
            include('../View/asistentes_cursos.php');
        }else{
            header("Location: .?action=menu_principal");
        }
        break;
     case "gestion_cursos": 
                //$cursos = get_cursos_by_id(null);
                if ($_SESSION["rol"]=="admin"){
                    $verFormularioGestionCursos=true;
                   
                }
                $mostrarheaderyfooter = false;
                $lugares=get_lugar_by_id(null);
                $tiempos=get_tiempo_by_id(null);
                $fotos=get_fotos_by_directory("img/fotosCursos");
                include('../View/gestion_cursos.php');
                break;
    
        case "mostrar_login":
            include ("../View/login.php");
            break;
        case "dologin":
            $resultadologin= comprueba_usuario($usuario,$password);
            if ($resultadologin==2){
                $error="El usuario y contraseña no son correctos";
                include ("../View/login.php");
                exit();
            }else if ($resultadologin==3){
                $error="El usuario no existe";
                include ("../View/login.php");
                exit(); 
            }else{
                header("Location: .?action=list_libros");
            }
         
           break;
    
      
        case "menu_principal":
            include ("../View/menu_principal.php");
            break;
        default:
       
            header("Location: .?action=menu_principal");
    }

    