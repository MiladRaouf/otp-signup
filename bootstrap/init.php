<?php

require './constans.php';
require './config.php';

try {
    $pdo = new PDO(
        "mysql:host=$databaseConfigs->host; dbname=$databaseConfigs->dbname; charset=$databaseConfigs->charset;",
        $databaseConfigs->user,
        $databaseConfigs->password
    );
} catch (PDOException $e) {
    die("Conection Failed: {$e->getMessage()}");
}