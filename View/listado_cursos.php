<?php
if ($mostrarheaderyfooter) {
    include(__DIR__ . '/header.php');
}
?>

<div id="listado_cursos" class="container">
    <div class="row justify-content-center">
        <table id="listadoCursos" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>

                    <th scope="col">#</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Duración</th>
                </tr>
            </thead>
        </table>
    </div>



</div>

<!-- modal para confirmar el borrado del curso -->

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
        ¿Estás seguro de que deseas borrar el curso?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="noBtn" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="siBtn">Sí</button>
      </div>
    </div>
  </div>
</div>
<script>

$(document).ready(function() {
 var $tablalistado = $('#listadoCursos').DataTable({
    "paging": true,
        "pageLength": 10,

        "ajax": {
            "url": "<?=$urlws?>?action=get_cursos",
            "type": "GET",
            "dataSrc": ""
        },
        "select": false,       
        "language": {
            "url": "//cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json"
        },
         // Agrega una columna para los botones de edición
         "columnDefs": [{
                    "targets": -1, // Última columna
                    "data": null,
                    "defaultContent": "<button class='btnEditar'>Editar</button>"
                }],
        "columns": [{
                "data": "id"
            },
            {
                "data": "titulo"
            },
            {
                "data": "ubicacion"
            },
   
             {
                        // Combina nombre y edad en una sola columna
                        "data": null,
                        "render": function (data, type, row) {
                            return data.duracion + ' ' + data.unidadDuracion + '';
                        }
                   
            }
            <?php
            if (esadmin()) {
                ?>
            ,            
            {
                "data":  "<button class='btnEditar' >Editar</button>"
            }
            <?php
            }
            ?>
        ]
        });


        $('#listadocursos').on('hover', 'tbody tr', function() {
            $(this).css('cursor', 'pointer');
            $(this).css('background-color', 'lightgray');
        });
        $('#listadoCursos').on('click', 'tbody tr button', function() {
           $.ajax({
                type: "GET",
                url: "<?=$urlws?>?action=get_curso&id=" + $(this).closest('tr').find('td').eq(0).text(),
                success: function(data) {
                    data = typeof data === 'string' ? JSON.parse(data) : data;
                    if (data.length>0){
                    data=data[0];
                    }
                  
                    $("#titulo").val(data.titulo);
                    $("#entradilla").val(data.entradilla);
                    $("#descripcion").val(data.descripcion);
                    $("#id_lugar").val(data.lugar_id);
                    $("#duracion").val(data.duracion);
                    $("#unidadDuracion").val(data.medida_tiempo);
                    //el check activo se marca si el campo activo es 1
                   if (data.activo==1){
                    $("#activo").prop('checked', true);
                   }

                    //obtenemos las fotos
                    $.ajax({
                        type: "GET",
                        url: "<?=$urlws?>?action=get_fotos_curso&id=" + data.id,
                        success: function(data) {
                            data = typeof data === 'string' ? JSON.parse(data) : data;
                            //recorremos el array obtenido con las fotos y preseleccionamos el select
                            data.forEach(function(data) {
                                $("#fotos option[value='" + data.foto + "']").prop('selected', true);
                            });
                        }
                    });

                    //cambiamos el texto del botón submit a modificar
                    $('button[type="submit"]').text('Modificar');
                    //mostramos un alert cuando se hace click en el botón de limpiar
                    $('button[type="reset"]').click(function() {
                        $('button[type="submit"]').text('Registrar Curso');
                    });
                    //creamos un campo hidden con el id del curso y lo adjuntamos al formulario
                    var idCurso = $("<input>").attr("type", "hidden").attr("name", "id").val(data.id);
                    $('#cursoForm').append(idCurso);
                    //cambiamos el evento submit del formulario para que haga un update en lugar de un insert
                    //creamos un nuevo botón para borrar el curso
                    var botonBorrar = $("<button>").attr("type", "button").addClass("btn btn-danger").text("Borrar").attr("id", "borrar");

                    //añadimos la funcionalidad de borrar el curso seleccionado al botón borrar
                    botonBorrar.click(function() {  
                        $('#confirmModal').modal('show');
                    });
                    //añadimos el botón al formulario sólo si no existe ningún otro botón con el label "borrar"

                    if ($('#cursoForm button').length <3){
                        $('#cursoForm').append(botonBorrar);
                    }
                    
                 
      
                }
            });

document.getElementById('siBtn').addEventListener('click', function() {
    $('#confirmModal').modal('hide');
    borrarCurso();
  });

  document.getElementById('noBtn').addEventListener('click', function() {
    $('#confirmModal').modal('hide');
  });
        
});
function borrarCurso(){
    var idCurso = $('#cursoForm input[name="id"]').val();
 
        $.ajax({
            type: "GET",
            url: "<?=$urlws?>?action=borrar_curso&id=" + idCurso,
            success: function(data) {
                alert("Curso borrado correctamente");
                var table = $('#listadoCursos').DataTable();
                //vaciamos el formulario
                $('#cursoForm').trigger("reset");
                //eliminamos el campo hidden con el id del curso
                $('#cursoForm input[name="id"]').remove();
                //cambiamos el texto del botón submit a registrar curso
                $('button[type="submit"]').text('Registrar Curso');
                //eliminamos el botón con id="borrar"
                $('#cursoForm button[id="borrar"]').remove();


                table.ajax.reload();
            },
            error: function(data) {
                alert("Error al borrar el curso");
            }
        });
   

}
});

</script>
<?php
if ($mostrarheaderyfooter) {
    include(__DIR__ . '/footer.php');
}
?>