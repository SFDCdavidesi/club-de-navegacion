<?php
include(__DIR__ . '/header.php');


?>
<div class="container mt-5">
    <h2>Asistentes a los Cursos de Navegación</h2>
    <div class="table-responsive">
        <table id="listadoAsistentes" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Fecha de Inscripción</th>
                    <th scope="col">Fecha de Curso</th>
                    <th scope="col">Confirmado</th>
                    <th scope="col">Pagado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se agregarán dinámicamente las filas de la tabla -->
            </tbody>
        </table>

    </div>
    <script>
        <?php
        if (isset($_SESSION["token"])){
            $token=$_SESSION["token"];
        }?>
    $(document).ready(function() {
        var $tablalistado = $('#listadoAsistentes').DataTable({
            "paging": true,
            "pageLength": 10,

            "ajax": {
                "url": "<?=$urlws?>?action=get_asistentes_cursos&token=<?=$token?>",
                "type": "POST",
                "dataSrc": ""                
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json"
            },
            "columns": [
                        { data: 'id_usuario_curso' },
                        { data: 'curso_titulo' },
                        { data: 'nombre' },
                        { data: 'apellidos' },
                        { data: 'email' },
                        { data: 'telefono' },
                        { data: 'calendario_fecha', render: function(data) { return formateaFecha(data); } },
                        { data: 'calendario_fecha', render: function(data) { return formateaFecha(data); }},
                        {
                            data: 'confirmado',
                            render: function(data) {
                                return data === 1 ? '<input type="checkbox" checked  id="confirma">' : '<input type="checkbox" id="confirma">';
                            }
                        },
                        {
                            data: 'pagado',
                            render: function(data) {
                                return data === 1 ? '<input type="checkbox" checked  id="paga">' : '<input type="checkbox" id="paga">';
                            }
                        }
                    ]
        });
        //añadimos un listener a los checkfbox de confirmado y pagado para llamar al servicio web que actualiza el estado
        $('#listadoAsistentes tbody').on('change', 'input[type="checkbox"]', function(e) {
            var data = $tablalistado.row($(this).parents('tr')).data();
    
            var id_usuario_curso = data.id_usuario_curso;
            var campo = $(this).attr('id');
            var valor = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                type: "GET",
                url: "<?=$urlws?>?action=actualiza_datos_curso",
                data: {
                    id_usuario_curso: id_usuario_curso,
                    campo: campo,
                    valor: valor,
                    token: "<?=$token?>"
                },
                success: function(data) {
                   if (data.mensaje){
                       alert(data.mensaje);
                    }
                },
                error: function(data) {
                    alert("Error al actualizar los datos");
                }
            });
        });
    });

    </script>
    <?php
include(__DIR__ . '/footer.php');
?>