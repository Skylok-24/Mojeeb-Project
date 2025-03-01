<?php
use classes\Services;
use classes\Product;
$title = "Home Page";

require_once 'template/header.php';
require_once 'classes/Services.php';
require_once 'classes/Product.php';

setcookie('is_admin','0',time()+30*24*60*60);
if (isset($_COOKIE['username'])) {
    echo 'Hello ' . $_COOKIE['username'];
}
$services = new Services();
$products = new Product();
$products->taxRate = .05
//print_r($service->all());
//$services->taxRate = .3;
?>
<?php isset($_SESSION['contact_form']['user']) ? $sender = $_SESSION['contact_form']['user'] : $sender = '' ?>

<h1><?= $sender ?> Welcome To Our Page</h1>
<div class="row">
    <?php foreach ($services->all() as $service) { ?>

        <div class="col-md-4">
            <div class="card">
                <h4 class="card-header"><?= $service['name'] ?></h4>
                <div class="card-body">
                    <p>Price: <?= $services->price($service['price']) ?></p>
                    <p>Work days: <?php foreach ($service['days'] as $day) {
                        ?>
                            <span><?= $day ?></span>
                        <?php
                        } ?></p>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

    <hr>
    <div class="row">
        <?php foreach ($products->all() as $product) { ?>

            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header"><?= $product['name'] ?></h4>
                    <div class="card-body">
                        <p>Price: <?= $products->price($product['price']) ?></p>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

<?php require_once 'template/fouter.php' ?>