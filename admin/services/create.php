<?php
ob_start();
$title = "Create user";
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

//echo "lokman2004" !== "lokman20204";
$description = $name = $price = '';
$errors = [];
if( $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; $description = $_POST['description'] ; $price = $_POST['price'];
    if (!empty($_POST['name']) && !empty($_POST['description']) &&  !empty($_POST['price'])) {
        $name = filterString($name);
        $description = filterString($description);
        $price  = (float)filter_var(trim($price),FILTER_VALIDATE_FLOAT);
        if (!$name) {
            array_push($errors,"name is Invalid");
        }
        if (!$description) {
            array_push($errors,"description is Invalid");
        }
        if (!$price) {
            array_push($errors,"price is Invalid");
        }
    }else {
        if (empty($_POST['name'])) array_push($errors," Name is required");
        if (empty($_POST['description'])) array_push($errors,"description is required");
        if (empty($_POST['price'])) array_push($errors,"price is required");
    }

    if (!count($errors)) {
            try {
                $query = $pdo->prepare("INSERT INTO services (name, description, price) VALUES (?, ?, ?)");
                $query->execute([$name,$description,$price]);
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
                <label for="email" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Name" id="name" value="<?= $name ?>">
            </div>
            <div class="form-group">
                <label for="name" class="form-label">Description:</label>
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

<?php require_once __DIR__.'/../template/footer.php';
ob_end_flush();
?>
