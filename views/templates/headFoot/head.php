<?php

if (!isset($model)) {
    $model = "";
}

if (!isset($styles)) {
    $styles = "";
}

if (!isset($normalizeCss)) {
    $normalizeCss = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $model ?></title>
    <link rel="stylesheet" href="<?= $normalizeCss ?>">
    <link rel="stylesheet" href="<?= $styles ?>">

</head>

<body>