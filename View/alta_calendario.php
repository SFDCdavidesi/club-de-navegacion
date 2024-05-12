<?php
include __DIR__ . '/header.php';
?>
<div class="container mt-5">
    <h2>Formulario de Alta de Calendarios de Cursos</h2>
    <form id="altaCursosForm">
        <div class="form-group">
            <label for="curso">Curso:</label>
            <select class="form-control" id="curso" name="curso">
                <option value="0" selected>Selecciona un curso</option>

            </select>
        </div>
        <div class="form-group">
            <label for="nivel">Nivel requerido:</label>
            <select class="form-control" id="nivel" name="nivel">
            </select>

        </div>
        <div class="form-group">
            <label for="plazas">Plazas disponibles:</label>
            <input type="text" class="form-control" id="plazas" name="plazas" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha">
        </div>
        <div class="form-group">
            <label for="activo">Activo:</label>
            <input type="checkbox" id="activo" name="activo" value="1">
        </div>
        <div class="form-group">
            <label for="duracion">Duración:</label>
            <input type="text" class="form-control" id="duracion" name="duracion" readonly>
        </div>
        <div class="form-group">
            <label for="precio">Precio (€):</label>
            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </form>
    <div id="volver" class="row">
        <div class="col-12 text-center">
            <a href="./?action=calendario" class="btn btn-primary">Volver al calendario</a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var cursoSeleccionado;
    $("#curso").change(function() {
        console.log($(this).val());
        curso = $(this).val();
        $.ajax({
            url: "<?=$urlws?>?action=get_curso&id=" + curso,
            method: "GET",
            dataType: "json",
            success: function(data) {
                data =data[0];
                console.table(data);
                cursoSeleccionado = data;
                console.log(data.nivel_requerido);
                $("#nivel").val(data.nivel_requerido);
                $("#plazas").val(data.numero_plazas);
                $("#duracion").val(data.duracion + " " + data.unidadDuracion);
                $("#precio").val(data.precio);
                $("#activo").prop("checked", data.activo == "1");
            },
            error: function(error) {
                console.error(error);
            }

        });
    });
    $.ajax({
        url: "<?=$urlws?>?action=get_cursos&activos=true",
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
            data.forEach(function(curso) {
                $("#curso").append(`<option value="${curso.id}">${curso.titulo}</option>`);
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    $.ajax({
        url: "<?=$urlws?>?action=get_niveles",
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
           data.forEach(function(nivel) {
                console.table(nivel);
            });
            data.forEach(function(nivel) {
                $("#nivel").append(`<option value="${nivel.id}">${nivel.nombre}</option>`);
            });
        },
        error: function(error) {
            console.error(error);
        }
    });

    $("#altaCursosForm").submit(function(event) {
        event.preventDefault();
        let curso = $("#curso").val();
        let nivel = $("#nivel").val();
        let plazas = $("#plazas").val();
        let fecha = $("#fecha").val();

        let activo = $("#activo").is(":checked");
        let duracion = $("#duracion").val();
        let unidad_medida= cursoSeleccionado.unidadDuracion;
        let precio = $("#precio").val();
        $.ajax({
            url: "<?=$urlws?>?action=alta_calendario",
            method: "POST",
            data: {
                curso: curso,
                nivel: nivel,
                plazas: plazas,
                fecha: fecha,
                activo: activo,
                unidad_medida: unidad_medida,
                duracion: duracion,
                precio: precio
            },
            success: function(data) {
                console.log(data);
                mostrarModal("Alta de calendario", data.mensaje);
                //limpiamos el formulario
                $("#altaCursosForm")[0].reset();
            },
            error: function(error) {
                console.error(error);
                mostrarModal("Alta de curso",
                    "Ha ocurrido un error al dar de alta el curso");
            }
        });
    });
});
</script>
<?php
include __DIR__ . '/footer.php';
?>