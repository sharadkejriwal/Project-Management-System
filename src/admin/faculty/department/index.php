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
		<title>Faculty Department</title>
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
			<h2>Associated Departments</h2>
			<label id="lblfcltid"><?php echo $fclt_id; ?></label>
			<label id="lblfcltname"><?php echo $fclt_name; ?></label>
			<table id="dept">
			</table>
			<span id="adddept">
				<span>+</span>
				Add Department
			</span>
		</div>
		<div id="addpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Add Department</h2>
				</header>
				<form action="" method="post" name="frmadddept" id="frmadddept">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtadddeptno">Department : </label></td>
								<td class="inp">
									<select name="txtadddeptno" id="txtadddeptno">
										<option value=""></option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddtime">Time Percent : </label></td>
								<td class="inp"><input type="text" name="txtaddtime" id="txtaddtime" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnadddept" id="btnadddept" value="Add" />
					</footer>
				</form>
				<div id="deptaddmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update department</h2>
				</header>
				<form action="" method="post" name="frmupddept" id="frmupddept">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupddeptno">Department : </label></td>
								<td class="inp">
									<select name="txtupddeptno" id="txtupddeptno">
										<option value=""></option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdtime">Time Percent : </label></td>
								<td class="inp"><input type="text" name="txtupdtime" id="txtupdtime" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="txtolddeptno" id="txtolddeptno" value="" />
					<footer>
						<input type="submit" name="btnupddept" id="btnupddept" value="Update" />
					</footer>
				</form>
				<div id="deptupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete deptact</h2>
				</header>
				<form action="" method="post" name="frmdeldept" id="frmdeldept">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdeldeptno">Department Number : </label></td>
								<td class="inp"><input type="text" name="txtdeldeptno" id="txtdeldeptno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdeltime">Time Percent : </label></td>
								<td class="inp"><input type="text" name="txtdeltime" id="txtdeltime" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndeldept" id="btndeldept" value="Delete" />
					</footer>
				</form>
				<div id="deptdelmess" class="message">
					Do you want to delete this department ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>