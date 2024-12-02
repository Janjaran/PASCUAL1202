<?php  
session_start();
$host = "localhost";
$user = "root";
$password = "";
$PASCUAL1202 = "PASCUAL1202";
$dsn = "mysql:host={$host};dbname={$PASCUAL1202}";

$pdo = new PDO($dsn,$user,$password);
$pdo->exec("SET time_zone = '+08:00';");
date_default_timezone_set('Asia/Manila');

?>