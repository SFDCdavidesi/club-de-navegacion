<?php
include(__DIR__ . '/header.php');


?>

<?php
if (isset($_SESSION) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") {

include(__DIR__ . '/listado_usuarios.php');
}
?>
<?php
include(__DIR__ . '/footer.php');
?>