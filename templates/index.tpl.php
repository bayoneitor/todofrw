<?php
include 'templates/header.tpl.php';
?>
<main>
    <article>
        <h2 class="text-center" style="margin-top: 20px;"><?= $title; ?></h2>
        <?php
        if (isset($error)) {
            echo '<h1>' . $error . '</h1>';
        }
        ?>
    </article>

</main>
<?php
include 'templates/footer.tpl.php';
