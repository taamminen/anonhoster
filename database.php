<?php

$host = "127.0.0.1"; $db = "test";
$user = "root"; $pswd = "";

$sql = "mysql:host=$host;dbname=$db;charset=utf8";

try
{
    $conn = new PDO('sqlite:./database'); 
    /* $conn = new PDO($sql, $user, $pswd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false]); */
} catch (PDOException $e) {
    die( "Connection failed: " . $e->getMessage());
}

header("Location: /");

?>
