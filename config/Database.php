<?php

$connection = [
    'unix_socket' => '/opt/lampp/var/mysql/mysql.sock',
    'user' => 'root',
    'password' => '',
    'database' => 'app'
];

try{
    $pdo = new PDO(
        "mysql:unix_socket={$connection['unix_socket']};dbname={$connection['database']}",
        "{$connection['user']}",
        ""
    );
}catch (PDOException $e) {
    die("could not connect to database".$e->getMessage());
}