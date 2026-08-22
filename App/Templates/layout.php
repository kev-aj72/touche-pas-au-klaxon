<?php

/** @var string $content */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Touche pas au klaxon</title>

    <link
        rel="stylesheet"
        href="<?= $this->url(
            '/assets/css/app.css'
        ) ?>"
    >
</head>

<body
    class="bg-light text-dark min-vh-100
        d-flex flex-column"
>
    <?= $this->component('header') ?>

    <div class="container flex-grow-1">
        <?= $content ?>
    </div>

    <?= $this->component('footer') ?>

    <script
        src="<?= $this->url(
            '/assets/js/bootstrap.bundle.min.js'
        ) ?>"
    ></script>
</body>
</html>