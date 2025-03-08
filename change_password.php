<?php
session_start();
$errors = [];
$title = "Change Password";
require_once 'template/header.php';
require_once 'config/Database.php';
require_once 'config/app.php';
if (isset($_SESSION['logen_in'])) {
    header("Location: /mojeeb/index.php");
}
print_r($_POST);
$token = $_POST['token'] ?? $_GET['token'] ?? null;
if (!$token) {
    die("Token parameter is missing");
}else {
    $date = date("Y-m-d H:i:s");
    $query = $pdo->prepare("SELECT * FROM password_resets WHERE token=? AND expiry_time > ?");
    $query->execute([$_POST['token']??$_GET['token'],$date]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($user)) die("Token parameter is missing");
}
function filterString($text)
{
    $text = filter_var(trim($text), FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($text)) {
        return false;
    } else {
        return $text;
    }
}

function filterEmail($text)
{
    $email = filter_var(trim($text), FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        return false;
    }
}

$email = $name = $password = $password_confirmation = '';
$errors = [];
if( $_SERVER["REQUEST_METHOD"] == "POST") {
     $password = $_POST['pass'];$password_confirmation = $_POST['confirm_pass'];
    if ( !empty($_POST['pass']) && !empty($_POST['confirm_pass'])) {
        if (strlen($password) < 8) {
            array_push($errors,"Password must be at least 8 characters long.");
        }else {
            if ($password !== $password_confirmation)
                array_push($errors,"Password don't match");
        }
    }else {
        if (empty($_POST['pass'])) array_push($errors,"Your Password is required");
        if (empty($_POST['confirm_pass'])) array_push($errors,"Password confirmation is required");
    }

    if (!count($errors)) {
        echo "true";
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $query = $pdo->prepare("UPDATE users SET password='$hashed_password' WHERE id='$user[user_id]'");
        $query->execute();
        $_SESSION['message'] = "Your password has been changed please login";
        header("Location: /mojeeb/index.php");
        exit();
    }
}
require_once 'template/errors.php';

?>
<style>
    .card {
        margin: 20px auto;
    }
</style>
<div id="password_reset">
    <h4>Create new password</h4>
    <hr>
    <?php require_once 'template/errors.php';
          require_once 'template/message.php';
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? $_POST['token'] ?? '') ?>">
        <div class="mb-3">
            <label for="email" class="form-label">New password:</label>
            <input type="password" name="pass" class="form-control" placeholder="Your Password" id="email">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Confirm new password:</label>
            <input type="password" name="confirm_pass" class="form-control" placeholder="Confirm password" id="email">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Change password</button>
        </div>
    </form>
</div>

<?php require_once 'template/fouter.php'?>
