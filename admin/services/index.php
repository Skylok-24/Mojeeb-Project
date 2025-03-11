<?php
ob_start();
$title = "Services";
$icon = "service";
require_once __DIR__."/../template/header.php";
$query = $pdo->prepare("SELECT * FROM services order by id");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $query = $pdo->prepare("DELETE FROM services WHERE id=?");
    $query->execute([$_POST['delete']]);
    header("Location: index.php");
    exit();
}
?>

<div class="card">
    <div class="content">
        <a href="create.php" class="btn btn-success">Create service</a>
        <p class="header">
            Services : <?= count($users) ?>
        </p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>description</td>
                    <td>Price</td>
                    <td width="200px">Action</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['description'] ?></td>
                        <td><?= $user['price'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edite</a>
                            <form action="" method="post" style="display: inline-block">
                                <button  onclick="return confirm('are you sure ?')" type="submit" class="btn btn-danger">Delete</button>
                                <input  type="hidden" name="delete" value="<?= $user['id'] ?>">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
ob_end_flush();
require_once __DIR__.'/../template/footer.php'?>
