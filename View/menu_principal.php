<?php
include(__DIR__ . '/header.php');
?>
<?php
if (isset($error)){
?>
<div class="muestra-error">
    <?=$error?>

</div>
<?php
}
?>

<!-- Video de fondo -->
<video autoplay muted loop id="videoBackground">
    
  <source src="../View/video/intro.mp4" type="video/mp4">
  Tu navegador no soporta la reproducción de video.
</video>

<!-- Contenido de la página -->
<div class="content container-fluid">
  <div class="row">
    <div class="col-12 text-center mt-5">
      <h1>Bienvenid@</h1>
      <p>CLUB DE NAVEGACIÓN.</p>
    </div>
  </div>
</div>

<!-- Enlace al script de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include(__DIR__ . '/footer.php');
?>