<?php
include(__DIR__ . '/header.php');
require_once(__DIR__ . '/../Model/funciones.php');
?>
<script>
$(document).ready(function() {
    $("#iniciar_sesion, #crear_cuenta").click(function() {
        $("#alta_usuarios").toggleClass("d-none");
        $("#inicio_sesion").toggleClass("d-none");
    });
    $("#formulario_de_alta").submit(function(event) {
        event.preventDefault();
        var pass1 = $("#pass1").val();
        var pass2 = $("#pass2").val();
        if (pass1 != pass2) {
            alert("Las contraseñas no coinciden");
            return;
        }
        if (!event.target.checkValidity()) {
            event.target.reportValidity();
            return;
        }
        var datos = $(this).serialize();
        $('button[type="submit"]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?=$urlws?>?action=crea_usuario",
            data: datos,
            success: function(response) {
                
                $('button[type="submit"]').prop('disabled', false);
                var respuesta = respuesta === 'string' ? JSON.parse(response) : response;
              
                console.table(respuesta);
                if (respuesta.id == 1) {
                    mostrarModal('info', respuesta.mensaje);
                } else {
                    mostrarModal('Error', respuesta.mensaje);
                }
            }

        });
    });
    $("#inicio_de_sesion").submit(function(event) {
        event.preventDefault();
        if (!event.target.checkValidity()) {
            event.target.reportValidity();
            return;
        }
        var datos = $(this).serialize();
        $('button[type="submit"]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?=$urlws?>?action=login",
            data: datos,
            success: function(response) {
                $('button[type="submit"]').prop('disabled', false);
            
                var respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (respuesta.length>0){
                    respuesta=respuesta[0];
                }
                if (respuesta.id == 1) {
                  window.location.href="./?action=menu_principal";

                } else {
                    mostrarModal('Error', respuesta.mensaje);
                }
                console.table(respuesta);
   
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            mostrarModal('Error', errorThrown);
        });
      });
      $('button[type="submit"]').prop('disabled', false);
});
</script>
<div class="container mt-5 d-none" id="alta_usuarios">
    <h2 class="mb-4">Formulario de Alta de Usuarios</h2>
    <form method="POST" id="formulario_de_alta">
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" minlength="6" maxlength="16"
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="pass1" name="password" minlength="8" required>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Repite ontraseña:</label>
            <input type="password" class="form-control" id="pass2" name="password2" minlength="8" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre :</label>
            <input type="text" class="form-control" id="nombre" name="nombre" min="3" max="64" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos :</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" min="3" max="64" required>
        </div>

        <!--div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <input type="text" class="form-control" id="rol" name="rol" required>
        </div-->
        <?php
        if (isset($_SESSION) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin"){
            ?>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" id="rol" name="rol" required>
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            <?php
        }
        ?>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
    <br>
    <div class="mb-3">
        ¿Ya tienes cuenta? <span id="iniciar_sesion" class="custom-link">Inicia sesión</span>
    </div>
</div>
<div class="container mt-5 " id="inicio_sesion">
    <h2 class="mb-4">Formulario de inicio de sesión</h2>
    <form method="POST"  id="inicio_de_sesion">
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
       
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
    <br>
    <div class="mb-3">
        ¿No tienes cuenta? <span id="crear_cuenta" class="custom-link"> crea una cuenta</span>
    </div>
</div>

<?php
include(__DIR__ . '/footer.php');
?>