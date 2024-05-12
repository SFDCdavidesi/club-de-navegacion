<?php
include(__DIR__ . '/header.php');


?>
<script>
    $(document).ready(function () {
        $("#recuperarForm").submit(function (event) {
            event.preventDefault();
            //validamos que se haya incluido un valor en el campo email o nombre de usuario
            if ($("#email").val().length == 0 && $("#nombreUsuario").val().length == 0) {
                mostrarModal("Recuperar Contraseña", "Debe introducir un email o un nombre de usuario");
                return;
            }
            let email = $("#email").val();
            let nombreUsuario = $("#nombreUsuario").val();
           
            $.ajax({
                url: "<?=$urlws?>?action=recuperarcontraseña",
                method: "POST",
                data: {
                    email: email,
                    nombreUsuario: nombreUsuario
                },
                success: function (data) {
                    console.log(data);
                    mostrarModal("Recuperar Contraseña", "Se ha enviado un correo con las instrucciones para recuperar la contraseña");
                },
                error: function (error) {
                    console.error(error);
                    mostrarModal("Recuperar Contraseña", "Ha ocurrido un error al recuperar la contraseña");
                }
            });
        });
    });
</script>
<div class="container mt-5">
    <h2>Recuperar Contraseña</h2>
    <form id="recuperarForm">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" >
        </div>
        <div class="form-group">
            <label for="nombreUsuario">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" >
        </div>
        <button type="submit" class="btn btn-primary">Recuperar</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </form>
</div>
<?php
include __DIR__ . '/footer.php';
?>