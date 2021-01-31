<?php

header("Content-Type: " . mime_content_type($filename));
header("Content-Disposition: attachment; filename=\".basename($filename).\"");
header("Content-Length: " . filesize($filename));
readfile($filename);

?>

<!DOCTYPE html>
<html>
<head>
	<title><?= $file->filename ?></title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1><?= $file->filename ?> <?php if (!$file->anon): ?> <?php get_user($file->user_id)->username ?> <?php endif; ?></h1>
      <p id="about"><?= $file->about ?></p>
      <?php if ($password): ?>
        <input type="password" name="password" placeholder="" />
      <?php endif; ?>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
