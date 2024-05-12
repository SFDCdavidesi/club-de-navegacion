<?php
function alta_calendario($curso,$nivel,$plazas,$fecha,$activo,$precio,$duracion,$unidad_medida){
    try{
        $con =BD::getConexion();
        $query="insert into calendario (curso_id,nivel_requerido,plazas_disponibles,fecha,activo,precio,createdby) values (:curso,:nivel,:plazas,:fecha,:activo,:precio,:createdby)";
        $statement= $con->prepare($query);
        $statement->bindValue(":curso",$curso);
        $statement->bindValue(":nivel",$nivel);
        $statement->bindValue(":plazas",$plazas);
        $statement->bindValue(":fecha",$fecha);
        $statement->bindValue(":activo",$activo=="true"?1:0);
        $statement->bindValue(":precio",$precio);
        $statement->bindValue(":createdby",$_SESSION["id_usuario"]); //añadimos el usuario que está dando de alta el curso
        $statement->execute();
        $statement->closeCursor();
        $resultado=array("id"=>$con->lastInsertId(),
        "mensaje"=>"Curso dado de alta correctamente");
        return $resultado;
    }catch(PDOException $e){
        $error="Ha ocurrido un error dando de alta el curso en la base de datos ";
        $error.= $e->getMessage();
        $resultado=array("id"=>0,"mensaje"=>$error);
        include ("../View/error.php");
        return $resultado;
        exit();
    }
}
//inscribimos al usuario logado en un calendario
//params= idCalendario
function inscribirUsuarioEnCalendario($idCalendario){
    try{
        $con =BD::getConexion();
        //primero comprobamos que no esté ya inscrito
        $query="select * from usuarios_cursos where id_usuario=:idUsuario and id_calendario=:idCalendario";
        $statement= $con->prepare($query);
        $statement->bindValue(":idCalendario",$idCalendario);
        $statement->bindValue(":idUsuario",$_SESSION["id_usuario"]);
        $statement->execute();
        $resultado=$statement->fetchAll();
        $statement->closeCursor();
        if (count($resultado)>0){
            $resultado=array("id"=>0,"mensaje"=>"Ya estás inscrito en este curso");
            return $resultado;
        }else{
        $query = "INSERT INTO `usuarios_cursos`( id_usuario,id_calendario ) VALUES (:idUsuario,:idCalendario)";
        $statement= $con->prepare($query);
        $statement->bindValue(":idCalendario",$idCalendario);
        $statement->bindValue(":idUsuario",$_SESSION["id_usuario"]);
        $statement->execute();
        $statement->closeCursor();
        $resultado=array("id"=>$con->lastInsertId(),
        "mensaje"=>"Inscripción realizada correctamente");
        return $resultado;
    }
    }catch(PDOException $e){
        $error="Ha ocurrido un error inscribiendo al usuario en el calendario en la base de datos ";
        $error.= $e->getMessage();
        $resultado=array("id"=>0,"mensaje"=>$error);
        include ("../View/error.php");
        return $resultado;
        exit();
    }
}
//obtiene los calendarios de un mes y año concretos
function get_calendarios_by_month_and_year($mes,$anio){
    try{
        $con =BD::getConexion();
        $query="select c.id,c.curso_id as idcurso, c.fecha, c.plazas_disponibles, c.activo, c.precio, c.nivel_requerido, n.nombre as nivel, cu.titulo as curso from calendario c inner join niveles n on c.nivel_requerido=n.id inner join cursos cu on c.curso_id=cu.id";
        $statement= $con->prepare($query);
        if ($mes!=null){
            $mes=intval($mes);
            $mes++;
            $query.=" where month(c.fecha)=:mes and year(c.fecha)=:anio";
            $statement= $con->prepare($query);
            $statement->bindValue(":mes",$mes);
            $statement->bindValue(":anio",$anio);

        } 
       
               $statement->execute();
        $resultado=$statement->fetchAll();
        $statement->closeCursor();
        return $resultado;
    }catch(PDOException $e){
        $error="Ha ocurrido un error obteniendo los calendarios en la base de datos ";
        $error.= $e->getMessage();
        include ("../View/error.php");
        exit();
    }
}

?>