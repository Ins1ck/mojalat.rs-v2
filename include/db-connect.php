<?php
ob_start();
session_start();

define('BASE_LINK', 'mojalat.rs-v2');

$dsn = 'mysql:host=localhost;dbname=mojalatrs';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$username='Admin';
$password='admin';
define("HOST","localhost");
define("USER","Admin");
define("PASSWORD","admin");

try {
    $db = new PDO($dsn,$username,$password,$options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
} catch(PDOException $e) {
    echo 'Error loading. Try again later.';
    exit();
}