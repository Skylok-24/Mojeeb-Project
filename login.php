<?php
$errors = [];
require_once 'template/header.php';
require_once 'config/Database.php';
require_once 'includes/handelLogin.php';
require_once 'template/errors.php';

?>
<style>
    .card {
        margin: 20px auto;
    }
</style>
<div id="register">
    <h4>Welcome back</h4>
    <h5 class="text-info">Please fill in the form below to Login</h5>
    <hr>
    <?php require_once 'template/errors.php'?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Your Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?= $email ?>">
<!--            <span class="text-danger">--><?php //= $errorEmail ?><!--</span>-->
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Your Password:</label>
            <input type="password" name="pass" class="form-control" placeholder="Your Password" id="pass" value="<?= $password ?>">
<!--            <span class="text-danger">--><?php //= $errorPassword ?><!--</span>-->
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Login</button>
            <a href="/mojeeb/password_rest.php">Forgot your passsword?</a>
        </div>
    </form>
</div>

<?php require_once 'template/fouter.php'?>
