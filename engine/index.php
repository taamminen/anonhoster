<!DOCTYPE html>
<html>
<head>
	<title>Anonhost by @taamminen</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Anonhost by @taamminen</h1>
      <p>Welcome to the club, buddy.</p>
      <p>The purpose of this website is to host your files for other people.</p>
      <p>You can <a href="/upload">upload</a> file anonymously or with your
        account. Even if your file is anonymous, you can specify a password
				for deleting it, and also a password for viewing.</p>
      <p>If you are not registered, you can <a href="/register">register</a>,
        or <a href="/login">log in</a>, if you already have an account,
				or <a href="/logout">log out</a>, if you want to stay anonymous.
			</p>
			<p>To delete your file, go to url of your file and replace
				`/file/` in url to `/delete/`. Don't forget your password,
				it's unrevocerable. Also, <a href="/browse">browse</a> your own files.</p>
			<p>Join us on Gitlab: <a href="https://gitlab.com/taamminen/anonhoster">
					gitlab.com/taamminen/anonhoster</a>.</p>
			<p>Maximum file size right now is 20MB.</p>
			<!--<p>Also, you can upload your file via linux terminal:<br />
			$ curl -F "file=@'UPLOAD_PATH'" https://taamminen.ru/upload</p>-->
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
