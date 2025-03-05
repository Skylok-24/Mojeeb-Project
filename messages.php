<?php

require_once 'template/header.php';
require_once 'config/Database.php';
require_once 'config/app.php';
$query = $pdo->prepare("
    SELECT *, u.id as user_id, u.name as user_name
    FROM users u 
    LEFT JOIN services s ON u.services_id = s.id 
");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if(!isset($_GET['id'])) { ?>
<h1>Recieved Messages</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Sender name</th>
                <th>Sender email</th>
                <th>Services</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['user_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['document'] ?></td>
                    <td>
                        <a href="?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-primary">View</a>
                        <form style="display: inline-block" action="" method="post" >
                            <input type="hidden" name="delete" value="<?= $user['user_id'] ?>">
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    <?php } else {
    $query = $pdo->prepare("SELECT *, u.id as user_id, u.name as user_name , u.description as user_des , u.document as file FROM users u 
    left join services s 
        on u.services_id = s.id
         WHERE u.id=".$_GET['id']);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1>Message</h1>
    <div class="card">
        <h5 class="card-header">
            Message from : <?= $user[0]['user_name'] ?>
            <div class="small"><?= $user[0]['email'] ?></div>
        </h5>
        <div class="card-body">
            <div>Service : <?php if($user[0]['name']) echo $user[0]['name']; else echo 'no service'  ?></div>
            <?= $user[0]['user_des'] ?>
        </div>
        <div class="card-footer">
            Attachment : <a href="<?= $config['app_url'].$user[0]['file'] ?>">Download attachment</a>
        </div>
    </div>

<?php } ?>
<?php
if(isset($_POST['delete'])) {
    $query = $pdo->prepare("delete from users where id=?");
    $query->execute([$_POST['delete']]);
    header("Location: /mojeeb/messages.php");
}
require_once 'template/fouter.php';
?>