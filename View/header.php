<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

    <link rel="icon" type="image/jpg" href="../View/img/icono.ico"/>

    <title>Menú de Navegación</title>


    <!-- enlaces bootstrap y jquery-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- jQuery y Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/2.0.0/i18n/Spanish.json"></script>

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="../View/css/estilos.css?v4" rel="stylesheet">
    <script src="../View/js/cursos.js?v3.1"></script>
    <script src="../View/js/funciones.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="./?action=inicio"><img src="../View/img/velero.png" class="w-25"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav" style="width: 90%;">
        <li class="nav-item active">
            <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin"){
                ?>
          <a class="nav-link" href="./?action=gestion_cursos">Gestionar Cursos </a>
          <?php
            }else{
                ?>
          <a class="nav-link" href="./?action=ver_cursos">Ver Cursos </a>
          <?php
            }
            ?>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="./?action=calendario">Calendario</a>
        </li>
        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin"){
                ?>
            <li class="nav-item dropdown float-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Admin
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="http://localhost/phpmyadmin/" target="_blank">Gestionar BBDD</a>
                <a class="dropdown-item" href="?action=gestion_usuarios">Gestión Usuarios</a>
                <a class="dropdown-item" href="?action=asistentes_cursos">Asistentes cursos</a>
            </div>
        </li>
        
        <?php
            }
            ?>
            <?php if (isset($_SESSION) && isset($_SESSION['usuario']) ) {
                ?>
                <li class="nav-item">
          <a class="nav-link"  href="./?action=ver_mis_cursos">Ver mis cursos</a>
        </li>
        <?php
            }
            ?>
      </ul>
      <?php if (isset($_SESSION["usuario"])){
        ?>
              <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" ><?=$_SESSION["usuario"]?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?action=logout"  title="cerrar sesion">📴</a>
        </li>
      </ul>
      <?php
      }else{
        ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./?action=login">Login</a>
        </li>
      </ul>
      <?php
      }
        ?>
    </div>
  </div>
</nav>




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="guardar">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
    

    });
    //la función mostrar modal recibe un parámetro título, otro mensaje conel contenido del mensaje y otro parémetro que puede ser null o puede contener un array con los botones que queremos mostrar en el modal
    
    
    function mostrarModal(titulo,mensaje,botones=null){
    
        $('#exampleModalCenter').modal('show');
        $('#exampleModalLongTitle').html(titulo);
        if (botones!=null){
            var html="";
            for (var i=0;i<botones.length;i++){
                html+="<button type='button' class='btn btn-primary'>"+botones[i]+"</button>";
            }
            $('#exampleModalCenter .modal-footer').html(html);
            //si pulsamos un botón del modal asignamos el valor del botón a la variable global pulsado
            $('#exampleModalCenter .modal-footer button').click(function(){
                pulsado=$(this).html();
            });

        }
        $('.modal-body').html(mensaje);}
</script>
