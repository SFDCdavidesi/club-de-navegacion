<?php


function upsert_autor($codigo_autor,$nombre,$apellidos,$año_nacimiento):bool{
    
    
    try{
        $con =BD::getConexion();
    if ($codigo_autor){
        //ya existe el autor, lo actualizamos
        $query="update autores set nombre=:nombre,apellidos=:apellidos,año_nacimiento=:anio_nacimiento where codigo_autor=:codigo_autor";
    }else{
        //no existe el usuario, lo insertamos
        $query="insert into autores (nombre,apellidos,año_nacimiento) values (:nombre,:apellidos,:anio_nacimiento)";
  
    }
   $statement= $con->prepare($query);
    if($codigo_autor){
        $statement->bindValue(":codigo_autor",$codigo_autor);

    }
    $statement->bindValue(":nombre",$nombre);
    $statement->bindValue(":apellidos",$apellidos);
    $statement->bindValue(":anio_nacimiento",$año_nacimiento);


    $statement->execute();
    $statement->closeCursor();
    return true;
    }catch(PDOException $e){
        $error="Ha ocurrido un error insertando / actualizando el autor en la base de datos ";
        $error.= $e->getMessage();
        include ("../View/error.php");
        exit();
    }

}
function delete_autor($codigo_autor):bool{
    try{
        $con =BD::getConexion();
    $query="delete from autores where codigo_autor=:codigo_autor"; //compruebo si existe ya un usuario . recordamso que usuario es primary key
   $statement= $con->prepare($query);
    $statement->bindValue(":codigo_autor",$codigo_autor);
    $statement->execute();
    
    $statement->closeCursor();
    return true;
    }catch(PDOException $e){
        $error="Ha ocurrido un error borrando  el autor en la base de datos ";
        $error.= $e->getMessage();
        include ("View/error.php");
        exit();
    }
}
function get_autores_by_autor($autor){
    try{
        $con =BD::getConexion();
        $query="select * from autores ";

        if ($autor){ //el autor está definido, lo incluimos para filtrarlo
            $query.=" where codigo_autor=:autor";
        }
        $query.=" order by apellidos";
       $statement= $con->prepare($query);
        if ($autor){
            $statement->bindValue(":autor",$autor);
        }

        $statement->execute();
        $resultados=$statement->fetchAll();
        $statement->closeCursor();
        return $resultados;
    }catch(PDOException $e){
        $error="Ha ocurrido un error obteniendo  el libro en la base de datos ";
        $error.= $e->getMessage();
        include ("View/error.php");
        exit();
    }
}

?>