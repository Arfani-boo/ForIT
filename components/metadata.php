<?php
require_once __DIR__ . '/../config.php';

$title ??= '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForIT <?= $title ? "- $title" : "" ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <?php if (isset($pageCSS)): ?>
        <?php foreach ($pageCSS as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>