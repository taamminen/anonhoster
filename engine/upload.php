<?php



?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Register</h1>
	    <form id="register-form" action="/upload" method="POST">
        <input type="file" name="file" /><br />
        <?php if ($loggedin): ?>
          <input type="checkbox" name="anonymous" />
        <?php endif ?>
		    <input type="password" placeholder="password (not required)" name="password" /><br />
		    <input type="password" placeholder="confirm password" name="confirm_password" /><br />
		    <input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
