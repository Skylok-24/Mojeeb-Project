<?php

include_once 'Database.php';

$query = $pdo->prepare("SELECT * FROM settings");
$query->execute();
$settings = $query->fetchAll(PDO::FETCH_ASSOC);


$config = [
    'app_name' => $settings[0]['app_name'],
    'mail_admin' => $settings[0]['admin_email'],
    'dir' => 'ltr',
    'lang' => 'en',
    'app_url' => 'http://localhost/mojeeb',
    'admin_assets' => 'http://127.0.0.1/mojeeb/admin/template/BS3/assets'
];
?>