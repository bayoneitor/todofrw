<?php
include 'templates/header.tpl.php';
$email = $_COOKIE['email'] ?? '';
?>

<form class="form-signin" action="<?= $web ?>user/logaction" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesion</h1>
    <label for="inputUser" class="sr-only">Usuario</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" value="<?= $email ?>" required autofocus>

    <label for="inputPassword" class="sr-only">Contraseña</label>
    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="true" name="remember-me"> Recordar correo
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login-button">Iniciar Sesión</button>
</form>

<?php
include 'templates/footer.tpl.php';
