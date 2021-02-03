<?php

include "database.php";

$sql = "SELECT * FROM `files` WHERE filename = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($f));
$file = $stmt->fetch(PDO::FETCH_OBJ);
if (empty($file))	header("Location: /");
$filename = "storage/uploads/".$file->filename;
header("Content-Type: " . mime_content_type($filename));
header("Content-Length: " . filesize($filename));
readfile($filename);

?>
