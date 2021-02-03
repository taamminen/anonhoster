<?php

$host = "127.0.0.1";
$db = "anonhost";
$user = "root";
$pswd = "";

$sql = "mysql:host=$host;dbname=$db;charset=utf8";

try {
  $conn = new PDO($sql, $user, $pswd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false]);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

session_start();
$loggedin = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;
$message = "";

?>
