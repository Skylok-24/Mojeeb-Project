<?php
$title = "Users";
$icon = "users";
require_once __DIR__."/../template/header.php";
$query = $pdo->prepare("SELECT * FROM users order by id");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="content">
        <a href="create.php" class="btn btn-success">Create user</a>
        <p class="header">
            Users : <?= count($users) ?>
        </p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Email</td>
                    <td>Name</td>
                    <td>Role</td>
                    <td width="200px">Action</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edite</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../template/footer.php'?>
