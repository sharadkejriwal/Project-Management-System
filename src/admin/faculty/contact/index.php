<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projects/admin/lib/includes.php';

$uman = new UserManager();

if (isset($_POST['btnsign'], $_POST['txtuser'], $_POST['txtpass']))
	$uman->login($_POST['txtuser'], $_POST['txtpass']);

if ($uman->isLoggedIn())
	$user = $uman->getUser();
else
	header("location: ../../../index.php");

if (!isset($_GET['faculty_id']))
	header("location: ../");

$fclt_id = $_GET['faculty_id'];

$dbman = new DBManager();

$query = "select name from faculty where faculty_id='$fclt_id';";
$res = $dbman->query($query);
if (mysqli_num_rows($res) == 0)
	header("location: ../");
$fclt_name = mysqli_fetch_row($res)[0];

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Faculty Contact</title>
		<link rel="stylesheet" href="style.css" />
		<script src="../../../js/jquery.min.js"></script>
		<script src="script.js"></script>
		<script>
			fcltId = <?php echo '"' . $fclt_id . '"'; ?>
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
			<a href=".." class="goback">Back to Faculty</a>
			<h2>Contact Info</h2>
			<label id="lblfcltid"><?php echo $fclt_id; ?></label>
			<label id="lblfcltname"><?php echo $fclt_name; ?></label>
			<table id="cont">
			</table>
			<span id="addcont">
				<span>+</span>
				Add Contact
			</span>
		</div>
		<div id="addpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Add Contact</h2>
				</header>
				<form action="" method="post" name="frmaddcont" id="frmaddcont">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtaddcontno">Contact Number : </label></td>
								<td class="inp"><input type="text" name="txtaddcontno" id="txtaddcontno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnaddcont" id="btnaddcont" value="Add" />
					</footer>
				</form>
				<div id="contaddmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update Contact</h2>
				</header>
				<form action="" method="post" name="frmupdcont" id="frmupdcont">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdcontno">Contact Number : </label></td>
								<td class="inp"><input type="text" name="txtupdcontno" id="txtupdcontno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="txtoldcontno" id="txtoldcontno" value="" />
					<footer>
						<input type="submit" name="btnupdcont" id="btnupdcont" value="Update" />
					</footer>
				</form>
				<div id="contupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete Contact</h2>
				</header>
				<form action="" method="post" name="frmdelcont" id="frmdelcont">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelcontno">Contact Number : </label></td>
								<td class="inp"><input type="text" name="txtdelcontno" id="txtdelcontno" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelcont" id="btndelcont" value="Delete" />
					</footer>
				</form>
				<div id="contdelmess" class="message">
					Do you want to delete this contact ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>