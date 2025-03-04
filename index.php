<?php
use classes\Services;
use classes\Product;
$title = "Home Page";

require_once 'template/header.php';
require_once 'classes/Services.php';
require_once 'classes/Product.php';
require_once 'config/Database.php';

setcookie('is_admin','0',time()+30*24*60*60);
if (isset($_COOKIE['username'])) {
    echo 'Hello ' . $_COOKIE['username'];
}
$services = new Services();
$products = new Product();
$products->taxRate = .05;
//print_r($service->all());
//$services->taxRate = .3;

?>
<?php isset($_SESSION['contact_form']['user']) ? $sender = $_SESSION['contact_form']['user'] : $sender = '' ?>

<h1><?= $sender ?> Welcome To Our Page</h1>

    <hr>
    <div class="row">
        <?php $query = $pdo->prepare("SELECT * FROM products");
              $query->execute();
              $products = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($products as $product) { ?>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="custom-card-image" style = "background-image: url(<?= $config['app_url'].$product['image'] ?>)" ></div>
                    <div class="card-body">
                        <div class="card-title"><?= $product['name'] ?></div>
                        <p><?= $product['description'] ?></p>
                        <p class = "text-success" ><?= $product['price'] ?> DA</p>
                    </div>
                </div>
            </div>

        <?php } $pdo = null ?>
    </div>

<?php require_once 'template/fouter.php' ?>