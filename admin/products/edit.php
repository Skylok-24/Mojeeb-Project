<?php
ob_start();
$title = "Edit product";
$icon = "users";
require_once __DIR__."/../template/header.php";

function filterString($text)
{
    $text = filter_var(trim($text), FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($text)) {
        return false;
    } else
        return $text;
}

$email = $name = $role = $passwordhash = '';
$errors = [];
if (empty($_GET['id']) && empty($_POST)) die("Missing id parameter");
if (isset($_GET['id'])) {
    $query = $pdo->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
    $query->execute([$_GET['id']]);
    $user = $query->fetch();
    $name = $user['name'];
    $description = $user['description'];
    $price = $user['price'];
}
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $i = 0;
    $errors = [];

    try {
        if (!$id) {
            die("User ID is missing!");
        }

        if (!empty($_POST['name'])) {
            $name = filterString($_POST['name']);
            $query = $pdo->prepare("UPDATE products SET name=? WHERE id=?");
            if ($query->execute([$name, $id])) {
                $i++;
            }
        }

        if (!empty($_POST['description'])) {
            $description = filterString($_POST['description']);
            if ($description) {
                $query = $pdo->prepare("UPDATE products SET description=? WHERE id=?");
                if ($query->execute([$description, $id])) {
                    $i++;
                }
            }
        }

        if (!empty($_POST['price'])) {
            $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
            if ($price) {
                $query = $pdo->prepare("UPDATE products SET price=? WHERE id=?");
                if ($query->execute([$price, $id])) {
                    $i++;
                }
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
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Description" id="description" value="<?= $name ?>">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Description:</label>
                <input type="text" name="description" class="form-control" placeholder="Description" id="description" value="<?= $description ?>">
            </div>
            <div class="form-group">
                <label for="pass" class="form-label">Price:</label>
                <input type="number" name="price" class="form-control" placeholder="Price" id="price" value="<?= $price ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__.'/../template/footer.php' ?>
