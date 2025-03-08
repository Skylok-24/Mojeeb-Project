<?php
$errors = [];
$title = "Password reset";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'template/header.php';
require_once 'config/Database.php';
require_once 'config/app.php';
if (isset($_SESSION['logen_in'])) {
    header("Location: /mojeeb/index.php");
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

$email = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        $email = filterEmail($email);
        if (!$email) {
            array_push($errors,"Your Email is Invalid");
        }
    }else {
        if (empty($_POST['email'])) array_push($errors,"Your Email is required");
    }
    if (!count($errors)) {
        $query = $pdo->prepare("SELECT id, email FROM users WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (empty($user['email']))
            array_push($errors,"Your email, $email does not exists in our records.");
        else {
            $query = $pdo->prepare("SELECT * FROM password_resets WHERE user_id=".$user['id']);
            $query->execute();
            $pass = $query->fetchAll();
            if (isset($user)){
                $query = $pdo->prepare("DELETE FROM password_resets WHERE user_id=".$user['id']);
                $query->execute();
            }
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s",strtotime("+1 hour"));
            $query = $pdo->prepare("INSERT INTO password_resets (token,expiry_time,user_id) VALUES ('$token','$expiry','$user[id]')");
            $query->execute();
            $reset_link = $config['app_url']."/change_password.php?token=".$token;
            $to = $email;
            $subject = "Reset password";
            $message = "Click on the following link to reset your password : ".$reset_link;
            $headers = "From : lokmanlooka@gmail.com";
//            $mail = new PHPMailer(true);
//
//            try {
//
//                $mail->isSMTP();
//                $mail->Host       = 'smtp.gmail.com';
//                $mail->SMTPAuth   = true;
//                $mail->Username   = 'lokmanlooka@gmail.com';
//                $mail->Password   = 'pajq dkiw tzys ktvk';
//                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//                $mail->Port       = 587;
//
//
//                $mail->setFrom('lokmanlooka@gmail.com', 'Lokman Brahmia');
//                $mail->addAddress($to);
//                $mail->isHTML(true);
//                $mail->CharSet = 'UTF-8';
//                $mail->Subject = "Reset Password";
//                $mail->Body = "
//<div style='font-family: Arial, sans-serif;'>
//    <p>Click on the following link to reset your password:</p>
//    <p><a href='{$reset_link}' style='background-color: #4285f4; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;'>Reset Your Password</a></p>
//    <p>If the button doesn't work, copy and paste this URL: {$reset_link}</p>
//</div>";
//                $mail->send();
//                $_SESSION['message'] = "A password reset link has been sent to your email.";
//            } catch (Exception $e) {
//                array_push($errors,"Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
//            }
        }
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
    <h4>Password reset</h4>
    <h5 class="text-info">Fill in your email to reset your password</h5>
    <hr>
    <?php require_once 'template/errors.php';
          require_once 'template/message.php';
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="mb-3">
<!--            --><?php //if (isset($_GET['token'])) { ?>
            <label for="email" class="form-label">Your Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?= $email ?>">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Request password reset link</button>
        </div>
    </form>
</div>

<?php require_once 'template/fouter.php'?>
