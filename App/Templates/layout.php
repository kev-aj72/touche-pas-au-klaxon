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

<body>
    <?= $this->component('header') ?>

    <?= $content ?>

    <?= $this->component('footer') ?>
</body>
</html>