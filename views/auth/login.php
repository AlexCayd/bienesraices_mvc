<h1>Login</h1>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email y Password</legend>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu email">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Tu password">

        </fieldset>
        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
    </form>
</main>