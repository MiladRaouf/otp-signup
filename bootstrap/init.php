<?php
session_start();

date_default_timezone_set('Asia/Tehran');

require 'constans.php';
require 'config.php';
require './libs/helper.php';
require './libs/authLib.php';
require './libs/validation.php';
require BASE_PATH.'vendor/autoload.php';
require 'mail.php';

try {
    $pdo = new PDO(
        "mysql:host=$databaseConfigs->host; dbname=$databaseConfigs->dbname; charset=$databaseConfigs->charset;",
        $databaseConfigs->user,
        $databaseConfigs->password
    );
} catch (PDOException $e) {
    die("Conection Failed: {$e->getMessage()}");
}
