<?php
session_start();
require_once __DIR__.'/../config/app.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
use PDO;
use PDOException;
?>
<!doctype html>
<html dir="<?= $config['dir'] ?>" lang="<?= $config['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $config['app_name'] . ' | ' . $title ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .custom-card-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
<div class="container">