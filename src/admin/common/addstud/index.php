<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projects/admin/lib/includes.php';
$uman = new UserManager();

if (isset($_POST['btnsign'], $_POST['txtuser'], $_POST['txtpass']))
	$uman->login($_POST['txtuser'], $_POST['txtpass']);

if ($uman->isLoggedIn())
	$user = $uman->getUser();
else
	header("location: ../../../index.php");

if (!isset($_GET['proj_no']))
	header("location: ../");

$proj_no = $_GET['proj_no'];

$dbman = new DBManager();

$query = "select title from project where proj_no='$proj_no';";
$res = $dbman->query($query);
if (mysqli_num_rows($res) == 0)
	header("location: ../");
$fclt_name = mysqli_fetch_row($res)[0];

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Student</title>
		<link rel="stylesheet" href="style.css" />
		<script src="../../../js/jquery.min.js"></script>
		<script src="script.js"></script>
		<script>
			projno = <?php echo '"' . $proj_no . '"'; ?>
		</script>
	</head>
	<body>
		<header>
			<nav>
				<a href="../../"><?php echo $user; ?></a>
				<a href="../../signout.php">Sign out</a>
			</nav>
			<h1>Administration</h1>
		</header>
		<div id="content">
			<a href=".." class="goback">Back to Common project</a>
			<h2>Members</h2>
			<label id="lblprojno"><?php echo $proj_no; ?></label>
			<label id="lblprojtitle"><?php echo $title; ?></label>
			<table id="stud">
			</table>
			<span id="addstud">
				<span>+</span>
				Add student
			</span>
		</div>
		<div id="addpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Add student</h2>
				</header>
				<form action="" method="post" name="frmaddstud" id="frmaddstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtaddschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtaddschno" id="txtaddschno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnaddstud" id="btnaddstud" value="Add" />
					</footer>
				</form>
				<div id="studaddmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update student</h2>
				</header>
				<form action="" method="post" name="frmupdstud" id="frmupdstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtupdschno" id="txtupdschno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="txtoldschno" id="txtoldschno" value="" />
					<footer>
						<input type="submit" name="btnupdstud" id="btnupdstud" value="Update" />
					</footer>
				</form>
				<div id="studupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete student</h2>
				</header>
				<form action="" method="post" name="frmdelstud" id="frmdelstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtdelschno" id="txtdelschno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelstud" id="btndelstud" value="Delete" />
					</footer>
				</form>
				<div id="studdelmess" class="message">
					Do you want to delete this studact ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>