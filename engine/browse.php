<?php

require 'database.php';

if (!Funcs::checkLoginState($conn)) header("Location: /");

$sql = "SELECT filename FROM `files` WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));
$files = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html>
<head>
	<title>All your files</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
      <h1>All your files <a href="/">(home)</a></h1>
      <?php if (count($files) == 0): ?>
      <p>Sorry, you don't have any files. You can <a href="/upload">upload</a> one.</p>
      <?php endif; ?>
      <ul>
      <?php foreach ($files as $key => $file): ?>
        <li><a href="/file/<?= $file->filename ?>"><?= $file->filename ?></a></li>
      <?php endforeach; ?>
      </ul>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
