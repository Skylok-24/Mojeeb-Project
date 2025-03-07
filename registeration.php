<?php
session_start();
$title = "Regiter";
$errors = [];
require_once 'template/header.php';
require_once 'config/Database.php';
    require_once 'includes/handleRegi.php';
    if (isset($_SESSION['logen_in'])) header("Location: /mojeeb/index.php");
?>
<style>
    .card {
        margin: 20px auto;
    }
</style>
    <div id="register">
        <h4>Welcom to our website</h4>
        <h5 class="text-info">Please fill in the form below to register a new account</h5>
        <hr>
        <?php require_once 'template/errors.php'?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Your Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?= $email ?>">
                <span class="text-danger"><?= $errorEmail ?></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Your Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Your Name" id="name" value="<?= $name ?>">
                <span class="text-danger"><?= $errorName ?></span>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Your Password:</label>
                <input type="password" name="pass" class="form-control" placeholder="Your Password" id="pass" value="<?= $password ?>">
                <span class="text-danger"><?= $errorPassword ?></span>
            </div>
            <div class="mb-3">
                <label for="confirm_pass" class="form-label">Confirm Password:</label>
                <input type="password" name="confirm_pass" class="form-control" placeholder="Confirm Your Password" id="confirm_pass" value="<?= $password_confirmation ?>">
                <span class="text-danger"><?= $errorconfPassword ?></span>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
        </form>
    </div>

<?php require_once 'template/fouter.php'?>
