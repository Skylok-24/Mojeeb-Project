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
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $config['app_url'] ?>"><?= $config['app_name'] ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><li class="nav-item">
                </li>
                    <a class="nav-link active" aria-current="page" href="<?= $config['app_url'] ?>">Home</a>
                </li>
                <a class="nav-link" href="<?= $config['app_url'] ?>/contact.php">Contact</a>
            </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (empty($_SESSION['logen_in'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $config['app_url'] ?>/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $config['app_url'] ?>/registeration.php">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $config['app_url'] ?>/registeration.php"><?= $_SESSION['user_name'] ?></a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $config['app_url'] ?>/logout.php">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
        </div>
    </div>
</nav>
<div class="container pt-5">