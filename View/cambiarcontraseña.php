<?php
include __DIR__ . '/header.php';
?>
<?php
//comprobamos si el token recibido existe en la base de datos
$control_contraseña=$_REQUEST["token"];
if (existetoken($control_contraseña)){
    //si existe el token , mostramos un formulario para cambiar la contraserña
    ?>
    <script>
        $(document).ready(function () {
            $("#cambiarForm").submit(function (event) {
                event.preventDefault();
                //validamos que se haya incluido un valor en el campo contraseña
                if ($("#contraseña").val().length == 0) {
                    mostrarModal("Cambiar Contraseña", "Debe introducir una contraseña");
                    return;
                }
                //validamos que las contraseñas coincidan
                if ($("#contraseña").val() != $("#contraseña2").val()) {
                    mostrarModal("Cambiar Contraseña", "Las contraseñas no coinciden");
                    return;
                }
                let token=$("#token").val();
                console.log("enviando formulario");
 
                $.ajax({
                    url: "<?=$urlws?>?action=docambiarcontraseña",
                    method: "POST",
                    data: {
                        token: token,
                        password: $("#contraseña").val(),
                        password2: $("#contraseña2").val()
                    },
                    success: function (data) {
                        console.log(data);
                        mostrarModal("Cambiar Contraseña", "Se ha cambiado la contraseña correctamente");
                        header("Location: .?action=login");
                    },
                    error: function (error) {
                        console.error(error);
                        mostrarModal("Cambiar Contraseña", "Ha ocurrido un error al cambiar la contraseña");
                    }
                });
            });
        });
    </script>
    <div class="container mt-5">
        <h2>Cambiar Contraseña</h2>
        <form id="cambiarForm">
            <input type="hidden" name="token" id="token" value="<?=$control_contraseña?>"> 

            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="contraseña2">Repite Contraseña:</label>
                <input type="password" class="form-control" id="contraseña2" name="contraseña2" required>
            </div>
            <button type="submit" class="btn btn-primary">Cambiar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </form>
    </div>
<?php
}else{
    //si no existe el token, mostramos un mensaje de error
    ?>
    <div class="container mt-5">
        <h2>Cambiar Contraseña</h2>
        <div class="alert alert-danger" role="alert">
            El token no es válido
        </div>
    </div>
<?php }

include __DIR__ . '/footer.php';
?>