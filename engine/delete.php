<?php

include "database.php";

$sql = "SELECT * FROM `files` WHERE filename = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($f));
$file = $stmt->fetch(PDO::FETCH_OBJ);

if (empty($file)) header("Location: /");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] == $file->user_id) ||
    (!empty($file->password) && password_verify($_POST["pswd"], $file->password)))
  {
    $sql = "DELETE FROM `files` WHERE filename = ?";
    $stmt = $conn->prepare($sql);
    $error = $stmt->execute(array($f));
    header("Location: /");
  } else $message = "Wrong password";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Anonhost by @taamminen</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
      <h1>Are you sure want to delete <?= $f ?>?</h1>
      <?php if ($message != ""): ?>
        <p><?= $message ?></p>
      <?php endif; ?>
      <form method="POST" action="/delete/<?= $f ?>">
        <?php if (isset($_SESSION['user_id']) &&
          $_SESSION['user_id'] == $file->user_id): ?>
          <input type="Submit" value="Yes, delete!" />
        <?php elseif (!empty($file->password)): ?>
          <input type="password" name="pswd" placeholder="password" /><br />
          <input type="Submit" value="Yes, delete!" />
        <?php else: ?>
          <p>Sorry, this file doesn't have a password and you are not authorized
            as an uploader of file, it can't be deleted.</p>
        <?php endif; ?>
      </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
