<?php
ob_start();
$title = "Users";
$icon = "users";
require_once __DIR__."/../template/header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $query = $pdo->prepare("UPDATE settings set app_name=?, admin_email=? where id=1");
    $query->execute([$_POST['app_name'],$_POST['admin_email']]);
    header("Location: index.php");
    exit();
}
?>

<div class="card">
    <div class="content">
        <h3>Update Settings</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="app_name"> Application Name :</label>
                <input type="text" id="app_name" name="app_name" value="<?= $config['app_name'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="app_name">Admin Email</label>
                <input type="text" id="app_name" name="admin_email" value="<?= $config['mail_admin'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Update Settings</button>
            </div>
        </form>
    </div>
</div>

<?php
ob_end_flush();
require_once __DIR__.'/../template/footer.php'?>
