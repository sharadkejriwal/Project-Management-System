<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Projects</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<header>
			<nav>
				<a href="home.php">HOME</a>
			</nav>
			<h1>Projects</h1>
		</header>
		<div id="admin">
			<h2>Administrator Sign in</h2>
			<form action="admin/index.php" method="post">
				<input type="text" name="txtuser" id="txtuser" placeholder="username" /><br />
				<input type="password" name="txtpass" id="txtpass" placeholder="password" /><br />
				<input type="submit" name="btnsign" id="btnsign" value="Sign in" />
			</form>
		</div>
		<div id="info">
			This portal provides information of on going projects in the College.
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>