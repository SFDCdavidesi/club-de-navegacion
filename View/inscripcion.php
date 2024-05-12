<?php

    include(__DIR__ . '/header.php');

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Inscripción</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">Va a proceder a inscribir en el curso <span id="nombreCurso"></span> en la fecha <span id="fechaCurso"></span> con un precio de <span id="precioCurso"></span>€. ¿Está seguro de que desea continuar?</div> 
           </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var idcurso = urlParams.get('idcurso');
            var fecha = urlParams.get('fecha');
            var precio = urlParams.get('precio');
            var nombre = urlParams.get('nombre');
            $("#nombreCurso").text(nombre);
            $("#fechaCurso").text(fecha);
            $("#precioCurso").text(precio);
            $("#inscribir").click(function() {
                $.ajax({
                    url: "<?=$urlws?>",
                    method: "POST",
                    data: {
                        action: "inscribir",
                        id: id,
                        fecha: fecha,
                        precio: precio
                    },
                    success: function(data) {
                        if (data.id > 0) {
                            alert("Inscripción realizada correctamente");
                            window.location.href = "./";
                        } else {
                            alert("Ha ocurrido un error al realizar la inscripción");
                        }
                    },
                    error: function() {
                        alert("Ha ocurrido un error al realizar la inscripción");
                    }
                });
            });
        }
    </script>
<?php

    include(__DIR__ . '/footer.php');

?>