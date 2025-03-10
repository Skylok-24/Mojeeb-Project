<?php
$title = "Edit user";
$icon = "users";
require_once __DIR__."/../template/header.php";
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
$email = $name = $password = $role = '';
$errors = [];
if( $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; $email = $_POST['email'] ; $password = $_POST['pass'];$role = $_POST['role'];
    if (!empty($_POST['name']) && !empty($_POST['email']) &&  !empty($_POST['pass']) && !empty($_POST['role'])) {
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
        }
    }else {
        if (empty($_POST['name'])) array_push($errors,"Your Name is required");
        if (empty($_POST['email'])) array_push($errors,"Your Email is required");
        if (empty($_POST['pass'])) array_push($errors,"Your Password is required");
        if (empty($_POST['role'])) array_push($errors,"Role is required");
    }

    if (!count($errors)) {

        $passwordhash = password_hash($password,PASSWORD_DEFAULT);
        try {
            $query = $pdo->prepare("INSERT INTO users (email, name, role, password) VALUES (?, ?, ?, ?)");
            $query->execute([$email, $name, $role, $passwordhash]);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            array_push($errors, "Database Error: " . $e->getMessage());
        }

    }
}
?>

<div class="card">
    <div class="content">
        <?php require_once __DIR__.'/../template/errors.php'?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group">
                <label for="email" class="form-label">Your Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?= $email ?>">
            </div>
            <div class="form-group">
                <label for="name" class="form-label">Your Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Your Name" id="name" value="<?= $name ?>">
            </div>
            <div class="form-group">
                <label for="pass" class="form-label">Your Password:</label>
                <input type="password" name="pass" class="form-control" placeholder="Your Password" id="pass" value="<?= $password ?>">
            </div>
            <div class="form-group">
                <label for="confirm_pass" class="form-label">Role :</label>
                <select name="role" id="role" class="form-control">
                    <option value="user"
                        <?php if ($role == 'user') echo 'selected'?>
                    >User</option>
                    <option value="admin"
                        <?php if ($role == 'admin') echo 'selected'?>
                    >Admin</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__.'/../template/footer.php' ?>
