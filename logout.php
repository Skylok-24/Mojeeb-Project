<?php
session_start();
if (isset($_SESSION['logen_in'])) {
    $_SESSION = [];
    $_SESSION['message'] = "You are loged out , see you soon";
    header("Location: /mojeeb/index.php");
    die();
}