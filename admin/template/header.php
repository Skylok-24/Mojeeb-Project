<?php
session_start();
require_once __DIR__.'/../../config/app.php';
require_once __DIR__.'/../../config/Database.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
if ($_SESSION['role'] == 'user' || empty($_SESSION))
    header("Location: /mojeeb/index.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="<?= $config['admin_assets'] ?>/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?= $config['app_name'] ?></title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?= $config['admin_assets'] ?>/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?= $config['admin_assets'] ?>/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?= $config['admin_assets'] ?>/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?= $config['admin_assets'] ?>/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="/mojeeb/admin/template/BS3/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="/mojeeb/admin/template/BS3/assets/img/sidebar-4.jpg">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <?php require_once 'sidebar.php'?>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?= $title ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-<?= $icon ?>"></i>
                                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="">
                                <p>Account</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <p>Log out</p>
                            </a>
                        </li>
                        <li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">