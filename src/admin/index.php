<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projects/admin/lib/includes.php';

$uman = new UserManager();

if (isset($_POST['btnsign'], $_POST['txtuser'], $_POST['txtpass']))
	$uman->login($_POST['txtuser'], $_POST['txtpass']);

if ($uman->isLoggedIn())
	$user = $uman->getUser();
else
	header("location: ../index.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Administrator</title>
		<link rel="stylesheet" href="style.css" />
		<script src="../js/jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<header>
			<nav>
				<a href=""><?php echo $user; ?></a>
				<a href="signout.php">Sign out</a>
			</nav>
			<h1>Administration</h1>
		</header>
		<div id="content">
			<nav>
				<a href="department/">Departments</a>
				<a href="faculty/">Faculty</a>
				<a href="student/">Student</a>
			</nav>
			<nav>
				<a href="addproject/">Add Project</a>
				<a href="course/">Course Project</a>
				<a href="common/">Common Project</a>
				<!--<a href="#">Interns</a>-->
			</nav>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>