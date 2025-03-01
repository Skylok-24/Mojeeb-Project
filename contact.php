<?php $title = "Contact";
require_once 'classes/Services.php';
require_once 'template/header.php';
require_once 'includes/uploader.php';
?>
<?php isset($_SESSION['contact_form']['user']) ? $sender = $_SESSION['contact_form']['user'] : $sender = '' ;
//print_r($_SESSION['contact_form']);
if (isset($_COOKIE['username'])) {
    echo 'Hello ' . $_COOKIE['username'];
}
if (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] == 1) {
    echo "<a href = '/admin'>go to admin</a>";
}

$services = new \classes\Services();
$services->taxRate = .05;
?>
    <style>
       form {
           background-color: #b8e3fc;
           padding: 20px;
           border-radius: 10px;
       }
    </style>
    <h1><?= $sender ?> Contact Us</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" value="<?= isset($_SESSION['contact_form']['email']) ? $_SESSION['contact_form']['email'] : '' ?>" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            <span class="text-danger"><?= $emailError ?></span>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Name</label>
            <input type="text" class="form-control" value="<?= isset($_SESSION['contact_form']['user']) ? $_SESSION['contact_form']['user'] : '' ?>" id="exampleInputPassword1" name="name">
            <span class="text-danger"><?= $nameError ?></span>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Your Document</label>
            <input type="file" class="form-control" id="exampleInputPassword1" name="document">
            <span class="text-danger"><?= $fileError ?></span>
        </div>
        <div class="form-group">
            <label for="services" class="form-label">Services</label>
            <select name="services" id="services" class="form-control">
                <?php foreach ($services->all() as $service) { ?>
                    <option value="<?= $service['name'] ?>">
                        <?= $service['name'] ?>
                        (<?= $services->price($service['price']) ?>) DA
                    </option>
               <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Your Text</label>
            <textarea class="form-control" id="exampleInputPassword1" name="text"><?= isset($_SESSION['contact_form']['text']) ? $_SESSION['contact_form']['text'] : '' ?></textarea>
            <span class="text-danger"><?= $textError ?></span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="<?= $uploadDir ?>/3d-rendering-hexagonal-texture-background.jpg" class="btn btn-primary" >Download Your file</a>
    </form>

<?php require_once 'template/fouter.php';
//$input = "<script> $('body').html('<h1>You Are Hacked</h1>') </script>";
//echo $input;
?>