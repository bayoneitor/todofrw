<?php
include 'templates/header.tpl.php';
?>
<main>
    <article>
        <h2 class="text-center" style="margin-top: 20px;"><?= $title; ?></h2>
    </article>
    <section>
        <p>Nombre Usuario: <?= $uname ?></p>
        <p>Correo electronico: <?= $email ?></p>
        <p>Total entregas: x</p>
    </section>
</main>
<?php
include 'templates/footer.tpl.php';
