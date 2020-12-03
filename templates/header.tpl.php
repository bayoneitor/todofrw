<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <?php
    //Css de Register y login
    if ($controller == "register" || $controller == "login") {
    ?>
        <link rel="stylesheet" href="<?= $web ?>public/css/signin.css">
    <?php
    }
    //Extra css por si se quiere añadir alguna otra
    if (isset($css)) {
    ?>
        <link rel="stylesheet" href="<?= $web ?>public/css/<?= $css; ?>.css">
    <?php
    }
    ?>

</head>

<body>
    <?php
    if ($controller != "register" && $controller != "login") {
        echo '  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="' . $web . '">TodoList</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">';
        if ($controller == 'index') {
            echo '<li class="nav-item active">';
        } else {
            echo '<li class="nav-item">';
        }
        echo '<a class="nav-link" href="' . $web . '">Inicio<span class="sr-only">(current)</span></a>
                </li>';


        if (isset($uname)) {
            if ($controller == 'dashboard') {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item">';
            }
            echo '<a class="nav-link" href="' . $web . 'dashboard">Lista</a>
                    </li>';
            echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" style="color: white;" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ' . ucwords($uname) . '
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="' . $web . 'profile">Perfil</a>
                            <a class="dropdown-item" href="' . $web . 'user/logout">Cerrar Sesión</a>
                        </div>
                    </li>';
        } else {
            echo '
                    <li class="nav-item">
                        <a href="user/register" class="btn btn-sm btn-outline-light">Registrarse</a>
                  </li>
                  <li class="nav-item">
                        <a href="user/login" class="btn btn-sm btn-outline-light">Iniciar Sesión</a>
                    </li>
                    ';
        }
        echo ' </ul>
            </div>
        </nav>';
    }
    ?>