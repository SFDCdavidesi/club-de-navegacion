<?php

    include(__DIR__ . '/header.php');

//iniciamos la sesión
$token=$_SESSION['token'];
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<br>

<div id="mis_cursos" class="container">
    <div class="row justify-content-center">
        <div class="table-responsive">
            <table id="listadoDeCursos" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Confirmado</th>
                        <th scope="col">Pagado</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán dinámicamente las filas de la tabla -->
                </tbody>
            </table>

        </div>


    </div>



</div>
<?php
include_once 'modal_curso.php';
?>

<script>
<?php
        //obtenemos los cursos del usuario
        if (isset($_SESSION["token"])){
            $token=$_SESSION["token"];
        }else{
            $token="";
        }
        ?>

//obtenemos los cursos del usuario llamando al servicio web

$(document).ready(function() {
    var $tablalistado = $('#listadoDeCursos').DataTable({
        "paging": true,
        "pageLength": 10,

        "ajax": {
            url: "<?=$urlws?>?action=get_mis_cursos&token=<?=$token?>",
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
            "defaultContent": "<button class='btnEditar'>Ver curso</button>"
        }],
        
        "columns": [{
                "data": "curso_id"
            },
            {
                "data": "curso_titulo"
            },
            {
                "data": function (row) {
                    var date = new Date(row.calendario_fecha);
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return day + '-' + month + '-' + year;
                }
            
            },
            {
                "data": function (row) {
                    return row.confirmado == 1 ? "sí" : "no";
                }
            }
            ,
            {
                "data": function (row) {
                    return row.pagado == 1 ? "sí" : "no";
                }
            }   ,
            {
                
                        // Combina nombre y edad en una sola columna
                        "data": null,
                        "render": function (data, type, row) {
                            return data.calendario_precio + ' €' ;
                        }
            }
            
            <?php
            if (esadmin()) {
                ?>,
            {
                "data": "<button class='btnEditar' >Ver curso</button>"
            }
            <?php
            }
            ?>
        ]
    });

     // Controlador de eventos para el botón "Ver curso"
     $('#listadoDeCursos').on('click', '.btnEditar', function() {
        // Obtener el ID del curso de la fila correspondiente
        var data = $tablalistado.row($(this).parents('tr')).data();
        var cursoID = data.curso_id;
        var calendarioID =0;
        // Mostrar ventana con el ID del curso
       ;
        muestraDatosCurso("<?=$urlws?>",cursoID,0,false);

    });

});
</script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php

    include(__DIR__ . '/footer.php');

?>