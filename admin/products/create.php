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

function canUpload($file)
{
    $allowed = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
    ];

    $filetype = $file['type'];
    $filemimetype = mime_content_type($file['tmp_name']);

    $maxfilesize = 1024 * 1024;
    $filesize = $file['size'];
//        echo $filemimetype;
//    echo $filesize;
    if (!in_array($filemimetype,$allowed)) {
        return 'File Type Not Allowed';
    }
    if ($filesize > $maxfilesize) {
        return 'File Size Not Allowed . Allowed size : '.$maxfilesize;
    }else {
        return true;
    }
}

$uploadDir = __DIR__ . '/../../uploads/products';

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
        if (empty($_FILES['document']['name'])) array_push($errors,"Image is required");
    }


    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
//        print_r($_FILES);
        if (canUpload($_FILES['document'])) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir,0775);
            }

            $fileName = time().$_FILES['document']['name'];
            if (file_exists($uploadDir.'/'.$fileName)) {
                array_push($errors,'file already exists');
            }else {
                if (!move_uploaded_file($_FILES['document']['tmp_name'], "$uploadDir/$fileName")) {
                    array_push($errors, "Failed to move uploaded file.");
                }
                $filePath = '/uploads/products/'.$fileName;
            }
        }else {
            array_push($errors,canUpload($_FILES['document']));
        }
    }

    if (!count($errors)) {
            try {
                $query = $pdo->prepare("INSERT INTO products (name, description, price,image) VALUES (?,?,?,?)");
                $query->execute([$name,$description,$price,$filePath]);
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
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
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
                <label for="pass" class="form-label">Image:</label>
                <input type="file" name="document" class="form-control" placeholder="Image" id="image">
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
