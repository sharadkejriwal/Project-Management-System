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
		<title>Add Project</title>
		<link rel="stylesheet" href="style.css" />
		<script src="../../js/jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<header>
			<nav>
				<a href=".."><?php echo $user; ?></a>
				<a href="signout.php">Sign out</a>
			</nav>
			<h1>Administration</h1>
		</header>
		<div id="content">
			<h2>Add Project</h2>
			<form action="" method="post" name="frmaddproj" id="frmaddproj">
				<table>
					<tbody>
						<tr>
							<td class="lbl"><label for="txtprojno">Project Number : </label></td>
							<td class="inp"><input type="text" name="txtprojno" id="txtprojno" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojtitle">Title : </label></td>
							<td class="inp"><input type="text" name="txtprojtitle" id="txtprojtitle" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojdesc">Description : </label></td>
							<td class="inp"><textarea name="txtprojdesc" id="txtprojdesc"></textarea></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojstartdate">Start Date : </label></td>
							<td class="inp"><input type="text" name="txtprojstartdate" id="txtprojstartdate" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojfinishdate">Finish Date : </label></td>
							<td class="inp"><input type="text" name="txtprojfinishdate" id="txtprojfinishdate" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojcompdate">Completed On : </label></td>
							<td class="inp"><input type="text" name="txtprojcompdate" id="txtprojcompdate" /></td>
							<td class="err"></td>
						</tr>
					</tbody>
				</table>
				<div id="projtype">
					<table>
						<tbody>
							<td class="lbl">Type : </td>
							<td class="inp">
								<input type="radio" name="radprojtype" id="radprojcors" value="course" />
								<label for="radprojcors">Course</label>
								<input type="radio" name="radprojtype" id="radprojcmmn" value="common" />
								<label for="radprojcmmn">Common</label>
							</td>
							<td class="err"></td>
						</tbody>
					</table>
				</div>
				<table id="tblcors" hidden="hidden">
					<tbody>
						<tr>
							<td class="lbl"><label for="txtprojdept">Department : </label></td>
							<td class="inp"><input type="text" name="txtprojdept" id="txtprojdept" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojinvst">Investigator : </label></td>
							<td class="inp"><input type="text" name="txtprojinvst" id="txtprojinvst" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label>Semester : </label></td>
							<td class="inp">
								<label for="chksem1">1</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem1" value="1" />
								<label for="chksem2">2</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem2" value="2" />
								<label for="chksem3">3</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem3" value="3" />
								<label for="chksem4">4</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem4" value="4" />
								<label for="chksem5">5</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem5" value="5" />
								<br />
								<label for="chksem6">6</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem6" value="6" />
								<label for="chksem7">7</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem7" value="7" />
								<label for="chksem8">8</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem8" value="8" />
								<label for="chksem9">9</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem9" value="9" />
								<label for="chksem10">10</label>
								<input type="checkbox" name="chkprojsem[]" id="chksem10" value="10" />
								<br />
							</td>
							<td class="err"></td>
						</tr>
					</tbody>
				</table>
				<table id="tblcmmn" hidden="hidden">
					<tbody>
						<tr>
							<td class="lbl"><label for="txtprojmjadv">Major Advisor : </label></td>
							<td class="inp"><input type="text" name="txtprojmjadv" id="txtprojmjadv" /></td>
							<td class="err"></td>
						</tr>
						<tr>
							<td class="lbl"><label for="txtprojamt">Amount : </label></td>
							<td class="inp"><input type="text" name="txtprojamt" id="txtprojamt" /></td>
							<td class="err"></td>
						</tr>
					</tbody>
				</table>
				<footer>
					<input type="submit" name="btnaddproj" id="btnaddproj" value="Add Project" />
				</footer>
			</form>
			<div id="projaddmess" class="message" hidden="hidden">
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>