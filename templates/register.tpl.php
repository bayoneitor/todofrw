<?php
include 'templates/header.tpl.php';
?>

<form class="form-signin" action="<?= $web ?>user/regaction" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Registrarse</h1>
    <label for="inputUser" class="sr-only">Usuario</label>
    <input type="text" id="inputUser" name="inputUser" class="form-control" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;" placeholder="Usuario" required autofocus>

    <label for="inputEmail" class="sr-only">Correo Electrónico</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" style="border-radius:0px;" placeholder="Correo Electrónico" required autofocus>

    <label for="inputPassword" class="sr-only">Contraseña</label>
    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit" name="register-button">Registrarse</button>
</form>

<?php
include 'templates/footer.tpl.php';
