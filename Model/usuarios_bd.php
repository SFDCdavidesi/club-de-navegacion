<?php
// Path: club-navegacion/Model/usuarios_bd.php
// obtiene un listado de usuarios. Si se le pasa un id, devuelve solo el usuario con ese id
function get_usuario_by_id($id):array{
    $con =BD::getConexion();
    $query="select u.id_usuario,u.nombre,u.apellidos,u.nombre_usuario,u.email,u.telefono,r.nombre as rol,u.rol_id as rol_id, u.fecha_creacion,u.fecha_ultimo_ingreso,u.instructor from usuarios u left join roles r on u.rol_id=r.id";
    if ($id && $id!=null){
        $query.=" where id_usuario=:id";
    }
   $statement= $con->prepare($query);
    if ($id && $id!=null){
        $statement->bindValue(":id",$id);
    }
    $statement->execute();
    $resultado=$statement->fetchAll();
    $statement->closeCursor();
    return $resultado;
}   
function comprueba_usuario($usu,$pass):array{
    $con=BD::getConexion();
    $query="select usuarios.id_usuario, usuarios.nombre_usuario,usuarios.password,roles.nombre as rol FROM
    usuarios left JOIN roles ON usuarios.rol_id=roles.id where usuarios.nombre_usuario=:usuario";
   $statement= $con->prepare($query);
    $statement->bindValue(":usuario",$usu);
    $statement->execute();
    if ($statement->rowCount()==1){
        $resultado=$statement->fetch(PDO::FETCH_ASSOC);
        $userOK=password_verify($pass,$resultado["password"]);
        $statement->closeCursor();
        if ($userOK==true){
            actualizaLoginDate($usu);
            crearSesion($usu,$resultado["rol"]);
            $resultado = array("id"=>1,
            "usuario"=>$usu,
            "rol"=>$resultado["rol"],
            "id_usuario"=>$resultado["id_usuario"],
            "mensaje"=>"Usuario y contraseña correctos");
        }else{
            $recuperarcontraseña="<a href='index.php?action=recuperarcontraseña'>Restablecer contraseña</a>";
            $resultado = array("id"=>-1,
            "mensaje"=>"Contraseña incorrecta " . $recuperarcontraseña);
        }
    }else{
        $statement->closeCursor();
        $resultado = array("id"=>-1,
            "mensaje"=>"Usuario no existe");
    }
    return $resultado;

}
function recuperar_contraseña($nombreusuario,$email):array{
    //comprobamos que el usuario o el email existen
    try{
    $con=BD::getConexion();
    if($nombreusuario!=""){
        $query="select * from usuarios where nombre_usuario=:nombre_usuario";
        if ($email!=""){
            $query.=" AND email=:email";
        }
    }else{
        $query="select * from usuarios where email=:email";
        if ($nombreusuario!=""){
            $query.=" AND nombre_usuario=:nombre_usuario";
        }
    }
  
    $statement= $con->prepare($query);
    if ($nombreusuario!=""){
        $statement->bindValue(":nombre_usuario",$nombreusuario);
    }
    if ($email!=""){
        $statement->bindValue(":email",$email);
    }
    $statement->execute();
    if ($statement->rowCount()==1){
        $resultado=$statement->fetch(PDO::FETCH_ASSOC);
        $nombreusuario=$resultado["nombre_usuario"];
        $statement->closeCursor();
        //enviamos un correo  con un enlace para restablecer la contraseña
        //generamos un token de 25 caracteres y lo guardamos en el registro del usuario
        $token=bin2hex(random_bytes(25));
        //guardamos los primeros 25 caracteres en $token
        $token=substr($token,0,25);
        $query="update usuarios set control_contraseña=:token where nombre_usuario=:nombre_usuario";
        $statement= $con->prepare($query);
        $statement->bindValue(":token",$token);
        $statement->bindValue(":nombre_usuario",$nombreusuario);
        $statement->execute();
        $statement->closeCursor();
        //creamos el cuerpo del correo con el enlace a la página de cambio de contraseña
        $cuerpo="<html><head><title> Cambio de Contraseña</title></head><body>Se ha solicitado un restablecimiento de contraseña para el usuario " . $nombreusuario . ".<br> Para restablecer la contraseña, haga click en el siguiente enlace: <a href='http://localhost/club-navegacion/controller/index.php?action=cambiarcontraseña&token=" . $token . "'>Restablecer contraseña</a>";
        $cuerpo.="<p>Si no ha solicitado el restablecimiento de contraseña, ignore este mensaje</p></body></html>";
     
      
        // Envío del correo
        $para=$resultado["email"];
        $asunto="Restablecimiento de contraseña";
        $mensaje=$cuerpo;
        include __DIR__ . '/enviarcorreo.php'; //incluimos la función 'enviar_correo' que se encuentra en el archivo 'enviarcorreo.php'
        
        $resultado=array("mensaje"=>enviar_correo($para,$asunto,$mensaje));

    }else{
        $resultado=array("id"=>0,
        "mensaje"=>"No se ha encontrado el usuario o el email en la base de datos");
    }
    }catch(PDOException $e){
        $resultado=array("id"=>0,
        "mensaje"=>"Ha ocurrido un error recuperando la contraseña en la base de datos " . $e->getMessage()
    );
    }
}

function existetoken ($token):bool{
    $con=BD::getConexion();
    $query="select * from usuarios where control_contraseña=:token";
    $statement= $con->prepare($query);
    $statement->bindValue(":token",$token);
    $statement->execute();
    if ($statement->rowCount()==1){
        return true;
    }else{
        return false;
    }
}
function actualizarcontraseña($token,$contraseña,$contraseña2):array{
    if ($contraseña!=$contraseña2){
        $resultado=array("id"=>0,
        "mensaje"=>"Las contraseñas no coinciden");
    }else{
        $con=BD::getConexion();
        $query="update usuarios set password=:password,control_contraseña=null where control_contraseña=:token";
        $statement= $con->prepare($query);
        $hashedpassword= password_hash($contraseña,PASSWORD_DEFAULT);
        $statement->bindValue(":password",$hashedpassword);
        $statement->bindValue(":token",$token);
        $statement->execute();
        if ($statement->rowCount()==1){
            $resultado=array("id"=>1,
            "mensaje"=>"Contraseña actualizada correctamente");
        }else{
            $resultado=array("id"=>0,
            "mensaje"=>"Ha ocurrido un error actualizando la contraseña");
        }
    }
    return $resultado;
}  
function insertar_usuario($nombre_usuario,$password,$nombre,$apellidos,$email,$telefono,$rol):array{
    if ($rol==""){
        $rol=2; //por defecto, el rol es usuario
    }
    try{
        $con =BD::getConexion();
    $query="select * from usuarios where nombre_usuario=:nombre_usuario or email=:email";
    $statement= $con->prepare($query);
    $statement->bindValue(":nombre_usuario",$nombre_usuario);
    $statement->bindValue(":email",$email);
    $statement->execute();
    if ($statement->rowCount()>0){
        $resultado=array("id"=>0,
        "mensaje"=>"El usuario o el email ya existen en la base de datos");
    }else{


    $query="insert into usuarios (nombre_usuario,nombre,apellidos,email,telefono,password,rol_id) values (:nombre_usuario,:nombre,:apellidos,:email,:telefono,:password,:rol)";
   $statement= $con->prepare($query);
    $statement->bindValue(":nombre_usuario",$nombre_usuario);
    $hashedpassword= password_hash($password,PASSWORD_DEFAULT);
    $statement->bindValue(":password",$hashedpassword);
    $statement->bindValue(":nombre",$nombre);
    $statement->bindValue(":apellidos",$apellidos);
    $statement->bindValue(":email",$email);
    $statement->bindValue(":telefono",$telefono);
    $statement->bindValue(":rol",$rol);
    $statement->execute();
    $statement->closeCursor();
    $last_id = $con->lastInsertId();
$resultado=array("id"=>1,
"mensaje"=>"Usuario insertado correctamente " . $last_id);
    }
    }catch(PDOException $e){
        $resultado=array("id"=>0,
        "mensaje"=>"Ha ocurrido un error insertando el usuario en la base de datos " . $e->getMessage()
    );
    }
    return $resultado;
}
/*
Función que actualiza un usuario.
Si actualiza el nombre de usuario, se verificará que no exista
 */
function actualiza_usuario($id,$nombre_usuario,$password,$nombre,$apellidos,$email,$telefono,$rol):array{
    //obtengo todos los datos del usuario con id recibido
    $datos_usuario=get_usuario_by_id($id);
    $usuario=$datos_usuario[0];
    //compruebo si se ha actualizado el nombre de usuario. En caso afirmativo compruebo que el nuevo nombre de usuario no exista
    if ($usuario["nombre_usuario"]!=$nombre_usuario){
        $con =BD::getConexion();
        $query="select * from usuarios where nombre_usuario=:nombre_usuario";
        $statement= $con->prepare($query);
        $statement->bindValue(":nombre_usuario",$nombre_usuario);
        $statement->execute();
        if ($statement->rowCount()>0){
            $resultado=array("id"=>0,
            "mensaje"=>"El nombre de usuario ya existe en la base de datos",
            "error"=>"El nombre de usuario ya existe en la base de datos");
            return $resultado;
        }
    }
    try{
        $con =BD::getConexion();
        //quiero verificar que la variable password no es nula y no está vacía
        
    if (null==$password || $password==""){
        $query="update usuarios set nombre_usuario=:nombre_usuario,nombre=:nombre,apellidos=:apellidos,email=:email,telefono=:telefono,rol_id=:rol where id_usuario=:id";
    }else{
        $query="update usuarios set nombre_usuario=:nombre_usuario,nombre=:nombre,apellidos=:apellidos,email=:email,telefono=:telefono,rol_id=:rol,password=:password where id_usuario=:id";
    }
    $statement= $con->prepare($query);
    $statement->bindValue(":id",$id);
    $statement->bindValue(":nombre_usuario",$nombre_usuario);
    if ($password!=""){
        $hashedpassword= password_hash($password,PASSWORD_DEFAULT);
        $statement->bindValue(":password",$hashedpassword);
    }
    $statement->bindValue(":nombre",$nombre);
    $statement->bindValue(":apellidos",$apellidos);
    $statement->bindValue(":email",$email);
    $statement->bindValue(":telefono",$telefono);
    $statement->bindValue(":rol",$rol);
    $statement->execute();
    $statement->closeCursor();
    $resultado=array("id"=>1,
    "mensaje"=>"Usuario actualizado correctamente");


    }catch(PDOException $e){
        $resultado=array("id"=>0,
        "error"=> "Ha ocurrido un error actualizando el usuario en la base de datos " . $e->getMessage(),
        "mensaje"=>"Ha ocurrido un error actualizando el usuario en la base de datos " . $e->getMessage()
    );
}
    return $resultado;

    



}
function upsert_usuario($nombre_usuario,$password,$nombre,$apellidos,$email,$telefono,$rol):array{
    
    if (!isset($rol) || $rol==""){
        $rol=2; //por defecto, el rol es usuario
    }
    
    try{
        $con =BD::getConexion();
    $query="select * from usuarios where nombre_usuario=:nombre_usuario or email=:email"; //compruebo si existe ya un usuario . recordamso que usuario es primary key
   $statement= $con->prepare($query);
    $statement->bindValue(":nombre_usuario",$nombre_usuario);
    $statement->bindValue(":email",$email);
    $statement->execute();
    $actualizapassword=false;
    if ($statement->rowCount()>0){
        //ya existe el usuario, lo actualizamos
        //comprobamos si hemos actualizado la password
      $res=$statement->fetch();
      if ($res["password"]!=$password){$actualizapassword=true;
        $query="update usuarios set email=:email,nombre=:nombre,apellidos=:apellidos,password=:password,rol_id=:rol where nombre_usuario=:nombre_usuario";
    }else{
        $query="update usuarios set email=:email,nombre=:nombre,apellidos=:apellidos,rol_id=:rol where nombre_usuario=:nombre_usuario";
    }


    }else{
        //no existe el usuario, lo insertamos
        $query="insert into usuarios (nombre_usuario,nombre,apellidos,email,password,rol_id) values (:nombre_usuario,:nombre,:apellidos,:email,:password,:rol)";
    }
   $statement= $con->prepare($query);
    $statement->bindValue(":nombre_usuario",$nombre_usuario);
    if($actualizapassword || $statement->rowCount()==0){
        $hashedpassword= password_hash($password,PASSWORD_DEFAULT);
        $statement->bindValue(":password",$hashedpassword);
    }

    $statement->bindValue(":nombre",$nombre);
    $statement->bindValue(":apellidos",$apellidos);
    $statement->bindValue(":email",$email);
    $statement->bindValue(":rol",$rol);
    $statement->execute();
    $statement->closeCursor();
 $resultado=array("id"=>1,
 "mensaje"=>"Usuario insertado / actualizado correctamente");
    }catch(PDOException $e){
        $resultado=array("id"=>0,
        "mensaje"=>"Ha ocurrido un error insertando / actualizando el usuario en la base de datos " . $e->getMessage()
    );
    }
    return $resultado;
}
function delete_usuario($usuario):bool{
    try{
        $con =BD::getConexion();
    $query="delete from usuarios where usuario=:usuario"; //compruebo si existe ya un usuario . recordamso que usuario es primary key
   $statement= $con->prepare($query);
    $statement->bindValue(":usuario",$usuario);
    $statement->execute();
    
    $statement->closeCursor();
    return true;
    }catch(PDOException $e){
        $error="Ha ocurrido un error borrando  el usuario en la base de datos ";
        $error.= $e->getMessage();
        include ("View/error.php");
        exit();
    }
}
function validaUsuarioRol($usuario,$rol):bool{
    $con =BD::getConexion();
    $query="select * FROM usuarios left JOIN roles ON usuarios.rol_id=roles.id WHERE usuarios.nombre_usuario=:usuario and roles.nombre=:rol";
   $statement= $con->prepare($query);
    $statement->bindValue(":usuario",$usuario);
    $statement->bindValue(":rol",$rol);
    $statement->execute();
    if ($statement->rowCount()>0){
        return true;
    }else{
        return false;
    }
}
//obtiene un listado de roles. Si se le pasa un id, devuelve solo el rol con ese id
function get_roles_by_id($id):array{
    $con =BD::getConexion();
    $query="select * from roles ";
    if ($id && $id!=null){
        $query.=" where id=:id";
    }
    $query.=" order by nombre";
   $statement= $con->prepare($query);
    if ($id && $id!=null){
        $statement->bindValue(":id",$id);
    }
    $statement->execute();
    $resultado=$statement->fetchAll();
    $statement->closeCursor();
    return $resultado;
}
function get_usuarios_by_username($username){

        $con =BD::getConexion();
        $query="select * from usuarios ";

        if ($username){ //el autor está definido, lo incluimos para filtrarlo
            $query.=" where usuario=:usuario";
        }
        $query.=" order by nombre";
       $statement= $con->prepare($query);
        if ($username){
            $statement->bindValue(":usuario",$username);
        }

        $statement->execute();
        $resultado=$statement->fetchAll();
        $statement->closeCursor();
        return $resultado;

}
function actualizaLoginDate($usuario){
    $con =BD::getConexion();
    $query="update usuarios set fecha_ultimo_ingreso=NOW() where nombre_usuario=:usuario"; 
   $statement= $con->prepare($query);
    $statement->bindValue(":usuario",$usuario);
    $statement->execute();

}


function borra_sesion($usuario){
    setcookie("usuario",null,time()-86400);
    setcookie("rol",null,time()-(3600*24));
    //destruimos también la sesión
    session_destroy();
    unset($_SESSION["carrito"]);

}
//creamos una cookie de usuario con duración de un día
function crearSesion($usuario,$rol){
    $_SESSION["usuario"]=$usuario;
    $_SESSION["rol"]=$rol;
    if (session_status() == PHP_SESSION_NONE) {
        // Si no hay una sesión activa, inicia una nueva sesión
        session_start();
    }
}  
/**
    setcookie("usuario",$usuario,time()+(3600*24));
    if($rol){
        setcookie("rol",$rol,time()+(3600*24));
    }
*/