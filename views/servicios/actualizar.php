<h1 class='nombre-pagina'>Actualizar Servicios</h1>
<p class="descripcion-pagina">Modifica los valores del Formulario</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="form">
    <?php include_once __DIR__ . '/formulario.php';?>
    <input type="submit" class="boton" value="Actualizar">
</form>