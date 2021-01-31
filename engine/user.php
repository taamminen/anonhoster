<?php



?>

<!DOCTYPE html>
<html>
<head>
	<title><?= $user->name ?> @<?= $user->username ?></title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1><?= $user->name ?> @<?= $user->username ?></h1>
      <img src="<?= $user->avatar ?>" />
      <p id="about"><?= $user->about ?></p>
      <?php foreach ($files as $key => $file): ?>
        <a href="/file/<?= $filename ?>"><?= $file->filename ?></a>
      <?php endforeach ?>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
