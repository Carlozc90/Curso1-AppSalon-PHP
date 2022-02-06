<h1 class='nombre-pagina'>Recuperar Password</h1>
<p class="descripcion-pagina">Inicio sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" action="/olvide" method="POST">

    <div class="campo">
        <label for="email">E-mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            id="email"
        >
    </div>

<input type="submit" class="boton" value="Iniciar Sesion">
</form>


<div class="acciones">
    <a href="/">Ya tienes cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crea Una</a>
</div>