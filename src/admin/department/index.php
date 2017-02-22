<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projects/admin/lib/includes.php';

$uman = new UserManager();

if ($uman->isLoggedIn())
	$user = $uman->getUser();
else
	header("location: ../../index.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Manage departments</title>
		<link rel="stylesheet" href="style.css" />
		<script src="../../js/jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<header>
			<nav>
				<a href=".."><?php echo $user; ?></a>
				<a href="../signout.php">Sign out</a>
			</nav>
			<h1>Administration</h1>
		</header>
		<div id="content">
			<h2>Departments</h2>
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
								<td class="lbl"><label for="txtadddeptno">Department Number : </label></td>
								<td class="inp"><input type="text" name="txtadddeptno" id="txtadddeptno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtadddeptname">Department Name : </label></td>
								<td class="inp"><input type="text" name="txtadddeptname" id="txtadddeptname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtadddepthod">HOD ID : </label></td>
								<td class="inp"><input type="text" name="txtadddepthod" id="txtadddepthod" /></td>
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
					<h2>Update Department</h2>
				</header>
				<form action="" method="post" name="frmupddept" id="frmupddept">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupddeptno">Department Number : </label></td>
								<td class="inp"><input type="text" name="txtupddeptno" id="txtupddeptno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupddeptname">Department Name : </label></td>
								<td class="inp"><input type="text" name="txtupddeptname" id="txtupddeptname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupddepthod">HOD ID : </label></td>
								<td class="inp"><input type="text" name="txtupddepthod" id="txtupddepthod" /></td>
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
					<h2>Delete Department</h2>
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
								<td class="lbl"><label for="txtdeldeptname">Department Name : </label></td>
								<td class="inp"><input type="text" name="txtdeldeptname" id="txtdeldeptname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdeldepthod">HOD ID : </label></td>
								<td class="inp"><input type="text" name="txtdeldepthod" id="txtdeldepthod" /></td>
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