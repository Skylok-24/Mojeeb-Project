<?php
function filterString($text)
{
    $text = filter_var(trim($text),FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($text)) {
        return false;
    }else {
        return $text;
    }
}

function filterEmail($text)
{
    $email = filter_var(trim($text),FILTER_SANITIZE_EMAIL);
    if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
        return $email;
    }else {
        return false;
    }
}
//echo "lokman2004" !== "lokman20204";

$errorName = $errorEmail = $errorPassword = $errorconfPassword = '';
$email = $name = $password = $password_confirmation = '';
$errors = [];
if( $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; $email = $_POST['email'] ; $password = $_POST['pass'];$password_confirmation = $_POST['confirm_pass'];
    if (!empty($_POST['name']) && !empty($_POST['email']) &&  !empty($_POST['pass']) && !empty($_POST['confirm_pass'])) {
        $name = filterString($name);
        $email = filterEmail($email);
        if (!$name) {
            array_push($errors,"Your Name is Invalid");
        }
        if (!$email) {
            array_push($errors,"Your Email is Invalid");
        }
        if (strlen($password) < 8) {
            array_push($errors,"Password must be at least 8 characters long.");
        }else {
            if ($password !== $password_confirmation)
                array_push($errors,"Password don't match");

        }
    }else {
        if (empty($_POST['name'])) array_push($errors,"Your Name is required");
        if (empty($_POST['email'])) array_push($errors,"Your Email is required");
        if (empty($_POST['pass'])) array_push($errors,"Your Password is required");
        if (empty($_POST['confirm_pass'])) array_push($errors,"Password confirmation is required");
    }

    if (!count($errors)) {
        $query = $pdo->prepare("SELECT id,email FROM users WHERE email=?");
        $query->execute([$email]);
        if ($query->fetch()) {
            array_push($errors,"User Already Exists");
        }else {
            $password = password_hash($password,PASSWORD_DEFAULT);
            $query = $pdo->prepare("INSERT INTO users (email,name,password) VALUES (?,?,?)");
            $success = $query->execute([$email,$name,$password]);
            if ($success) {
                $_SESSION['logen_in'] = true;
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                $_SESSION['message'] = $name." Welcome back .";
                header("Location: /mojeeb/index.php");
            }else {
                array_push($errors,"regestred error");
            }
        }
    }
//    if (!$errorPassword && !$errorEmail && !$errorName && !$errorconfPassword) {
//        $created_at = date("Y-m-d H:i:s");
//        $query = $pdo->prepare("INSERT INTO users (email,name,password) VALUES (?,?,?)");
//        $query->execute([$email,$name,$password]);
//        header("Location: /mojeeb/registeration.php");
//    }
}