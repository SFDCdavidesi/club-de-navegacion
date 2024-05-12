<?php
include(__DIR__ . '/header.php');
?>
<div class="container mt-5 " id="modificarUsuarios">
    <h2 class="mb-4">Formulario de Modificación de Usuarios</h2>
    <form method="POST" id="formulario_de_modificacion">
        <input type="hidden" name="action" value="modificar_usuario">
        <input type="hidden" name="id" value="">
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" minlength="6" maxlength="16"
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="pass1" name="password" minlength="8" >
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Repite contraseña:</label>
            <input type="password" class="form-control" id="pass2" name="password2" minlength="8" >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required>
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
                
            </select>
            <?php
        }
        ?>
        </div>


        <button type="submit" class="btn btn-primary">Modificar Usuario</button>
        <button type="button" class="btn btn-secondary" onclick="history.back()">Cancelar</button>
    </form>
  <script>
    <?php
    if (isset($_SESSION["token"])){
        $token=$_SESSION["token"];
    }?>
    $(document).ready(function() {
        //cargamos los roles
        $.ajax({
            type: "POST",
            url: "<?=$urlws?>",
            data: {
                action: "get_roles",
                token: "<?=$token?>"
            },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }
                response.forEach(function(rol) {
                    $("#rol").append('<option value="' + rol.id + '">' + rol.nombre + '</option>');
                });
            }
        });
        //obtenemos los datos del usuario
        var id = new URLSearchParams(window.location.search).get("id");
        $.ajax({
            type: "POST",
            url: "<?=$urlws?>",
            data: {
                action: "get_usuario",
                id: id,
                token: "<?=$token?>"
            },
            success: function(response) {
                if (response.length>0){
                    response=response[0];
                }
                if (response.id===0) {
                    alert(response.mensaje);
                    return;
                }
         
                $("#nombreUsuario").val(response.nombre_usuario);
                $("#email").val(response.email);
                $("#telefono").val(response.telefono);
                $("#nombre").val(response.nombre);
                $("#apellidos").val(response.apellidos);
                $("#rol").val(response.rol_id);
                $("input[name='id']").val(response.id_usuario);
                //establecemos unos asteriscos en la contraseña
                $("#pass1").attr("placeholder", "******");
                $("#pass2").attr("placeholder", "******");
            },
            error: function(response) {
                alert("Error al obtener los datos del usuario");
            }
        });
        $("#formulario_de_modificacion").submit(function(event) {
            event.preventDefault();
            var pass1 = $("#pass1").val();
            var pass2 = $("#pass2").val();
            if (pass1 != pass2) {
                alert("Las contraseñas no coinciden");
                return;
            }
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?=$urlws?>?action=modificar_usuario&token=<?=$token?>",
                data: parametros,
                success: function(response) {
                    if (response.length>0){
                        response=response[0];
                    }
                    if (response.id===0) {
                        alert(response.mensaje);
                        mostrarModal("Error",response.mensaje);
                        return;
                    }else{
                        mostrarModal("Usuario modificado",response.mensaje);
                    }

                   // location.reload();
                },
                error: function(response) {
                    alert("Error al modificar el usuario");
                }
            });
        });
    });
  </script>
</div>
<?php
include(__DIR__ . '/footer.php');
?>