<?php
if ($mostrarheaderyfooter) {
    include(__DIR__ . '/header.php');
}
//iniciamos la sesión
$token=$_SESSION['token'];
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>


<div id="listado_usuarios" class="container">
    <div class="row justify-content-center">
    <div class="table-responsive">
    <table id="listadoUsuarios" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th scope="col">#id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Nombre de usuario</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Rol</th>
                <th scope="col">Fecha de alta</th>
                <th scope="col">Fecha de último ingreso</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <!-- Aquí se agregarán dinámicamente las filas de la tabla -->
    </tbody>
    </table>
    
</div>


    </div>



</div>

<!-- modal para confirmar el borrado del usuario -->

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar acción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas borrar el usuario?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="noBtn" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="siBtn">Sí</button>
      </div>
    </div>
  </div>
</div>
<style>
    .btn-transparent {
      background-color: transparent;
      border: none;
    }
    .btn-transparent .oi {
      color: #000; /* Cambiar color del símbolo */
      font-size: 1.5rem; /* Ajustar tamaño del símbolo */
    }
  </style>
<script>
    <?php
    if (isset($_SESSION["token"])){
        $token=$_SESSION["token"];
    }?>
$(document).ready(function() {
  $listadoUsuarios = $('#listadoUsuarios').DataTable({
    "paging": true,
    "pageLength": 10,
    "ajax": {
      "url": "<?=$urlws?>?action=get_usuarios&token=<?=$token?>",
      "type": "POST",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json"
    },
    "columns": [
      { data: 'id_usuario' },
      { data: 'nombre' },
      { data: 'apellidos' },
      { data: 'nombre_usuario' },
      { data: 'email' },
      { data: 'telefono' },
      { data: 'rol' },
      { data: 'fecha_creacion' },
      { data: 'fecha_ultimo_ingreso' },
      {
        data: 'id_usuario',
        render: function(data) {
          return '<a href="./?action=editar_usuario&id=' + data + '" class="btn btn-transparent">📝</a> <button class="btn btn-transparent" data-toggle="modal" data-target="#confirmModal" data-id="' + data + '">🗑️</button>';
        }
      }
    ]
  });
});
   





</script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
if ($mostrarheaderyfooter) {
    include(__DIR__ . '/footer.php');
}
?>