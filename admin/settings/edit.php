<?php
ob_start();
$title = "Edit user";
$icon = "users";
require_once __DIR__."/../template/header.php";

function filterString($text)
{
    $text = filter_var(trim($text),FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($text)) {
        return false;
    }else
        return $text;
}

function filterEmail($text)
{
    $text = filter_var(trim($text),FILTER_SANITIZE_EMAIL);
    if (filter_var($text,FILTER_VALIDATE_EMAIL)){
        return $text;
    }else
        return false;
}

$email = $name = $role = $passwordhash = '';
$errors = [];
if (empty($_GET['id']) && empty($_POST)) die("Missing id parameter");
if (isset($_GET['id'])) {
    $query = $pdo->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
    $query->execute([$_GET['id']]);
    $user = $query->fetch();
    $name = $user['name'];
    $email = $user['email'];
    $role = $user['role'];
}
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $i = 0;
    $errors = [];

    try {
        if (!$id) {
            die("User ID is missing!");
        }

        if (!empty($_POST['pass'])) {
            $passwordhash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $query = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
            if ($query->execute([$passwordhash, $id])) {
                $i++;
            }
        }

        if (!empty($_POST['name'])) {
            $name = filterString($_POST['name']);
            if ($name) {
                $query = $pdo->prepare("UPDATE users SET name=? WHERE id=?");
                if ($query->execute([$name, $id])) {
                    $i++;
                }
            }
        }

        if (!empty($_POST['email'])) {
            $email = filterEmail($_POST['email']);
            if ($email) {
                $query = $pdo->prepare("UPDATE users SET email=? WHERE id=?");
                if ($query->execute([$email, $id])) {
                    $i++;
                }
            }
        }

        if (!empty($_POST['role'])) {
            $query = $pdo->prepare("UPDATE users SET role=? WHERE id=?");
            if ($query->execute([$_POST['role'], $id])) {
                $i++;
            }
        }

        if ($i > 0) {
            header("Location: index.php");
            exit();
        }

    } catch (PDOException $e) {
        array_push($errors, $e->getMessage());
    }
}

ob_end_flush();
?>

<div class="card">
    <div class="content">
        <?php require_once __DIR__.'/../template/errors.php'?>
        <form action="<?= $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'] ?>" method="post">
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
                <input type="password" name="pass" class="form-control" placeholder="Your Password" id="pass" value="">
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
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__.'/../template/footer.php' ?>
