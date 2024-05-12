<?php
include(__DIR__ . '/header.php');


?>
<!-- alta cursos -->
<div class="container mt-5">
        <h2>Registro de Cursos de Navegación</h2>
        <form id="cursoForm">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="entradilla">Entradilla:</label>
                <textarea class="form-control" id="entradilla" name="entradilla" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <select class="form-control" id="id_lugar" name="ubicacion" required>
<?=pintaOptionsSelect($lugares,"id","nombre")?>

                </select>
            </div>
            <div class="form-group">
                <label for="duracion">Duración:</label>
                <input type="number" class="form-control" id="duracion" name="duracion" required>
                <select class="form-control mt-2" id="unidadDuracion" name="unidadDuracion" required>
                <?=pintaOptionsSelect($tiempos,"id","nombre")?>
</select>
            </div>
            <div class="form-group">
                <label for="activo">Activo:</label>
                <input type="checkbox" id="activo" name="activo" value="1">
            </div>
            <div class="form-group">
                <label for="fotos">Fotos:</label>
                <table ><tr><td>     <select multiple class="form-control" id="fotos" name="fotos[]">
                   <?php
                    foreach ($fotos as $foto) {
                        echo "<option value='" . $foto["ruta"] . "'>" . $foto["nombre"] . "</option>";
                    }
                    ?>
                </select></td><td><img class="hand-cursor" id="fotoMostrada" ></td></tr></table>
           
            </div>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Registrar Curso</button>
        </form>
    </div>


        <script>
            //creamos una variable global para almacenar el resultado de la pulsación de modal llamada "pulsado"
            var pulsado = "";
                    
            $(document).ready(function () {
      
                $("#cursoForm").submit(function (event) {
                    event.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    var formData = new FormData(form[0]);
                    //cormpruebo si el formulario tiene un campo llamado id
                    let esModificacion=form.find("input[name='id']").length>0?true:false;
                    //compruebo si el checkbox está marcado
                    let checkboxMarcado=form.find("input[name='activo']").is(":checked");
                    formData.append('activo', checkboxMarcado);
// Convertir el valor del checkbox a booleano y agregarlo a FormData
formData.append('miCheckbox', checkboxMarcado);
                    if (esModificacion){
                        $.ajax({
                        type: "POST",
                        url: "<?=$urlws?>?action=actualiza_curso",
                        data: formData,
                        processData: false,
                        contentType: false,
                        //nos aseguramos que el campo de tipo checkbox se envíe como booleano

                        success: function (data) {
                            // Remove unnecessary variable assignment
                            var data=typeof data === 'string' ? JSON.parse(data) : data;
                            alert("Curso registrado correctamente" + data.id);
                    
                            var table = $('#listadoCursos').DataTable();
                            table.ajax.reload();
                        },
                        error: function (data) {
                            alert("Error al modificar el curso");
                        }
                    });
                    }else{
                    $.ajax({
                        type: "POST",
                        url: "<?=$urlws?>?action=alta_curso",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            // Remove unnecessary variable assignment
                            var data=typeof data === 'string' ? JSON.parse(data) : data;
                            alert("Curso registrado correctamente" + data.id);
                    
                            var table = $('#listadoCursos').DataTable();
                            table.ajax.reload();
                        },
                        error: function (data) {
                            alert("Error al registrar el curso");
                        }
                    });
                }
                });


                //cargar la imagen seleccionada
                $("#fotos").change(function () {
                    var foto = $(this).val();
                    if (foto.length){
                        foto=foto[foto.length-1];
                    }
                    console.log(foto);
                    $("#fotoMostrada").attr("src",foto);
                    $("#fotoMostrada").attr("width","300px");
                    $("#fotoMostrada").attr("height","300px");
                    $("#fotoMostrada").attr("class","hand-cursor");
                    $("#fotoMostrada").click(function(){
                     var ventana=window.open(foto,"_blank");
                    });
                });

                //editamos el curso

            });
            </script>
</div>
<?php
include(__DIR__ . '/listado_cursos.php');
?>
<?php
include(__DIR__ . '/footer.php');
?>