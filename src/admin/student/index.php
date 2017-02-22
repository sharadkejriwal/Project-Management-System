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
		<title>Manage students</title>
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
			<h2>Students</h2>
			<span class="select">
				<label for="seldept">Department : </label>
				<select id="seldept">
					<option value="">All Departments</option>
				</select>
			</span>
			<table id="stud">
			</table>
			<span id="addstud">
				<span>+</span>
				Add Student
			</span>
		</div>
		<div id="addpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Add Student</h2>
				</header>
				<form action="" method="post" name="frmaddstud" id="frmaddstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtaddstudschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtaddstudschno" id="txtaddstudschno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddstudname">Student Name : </label></td>
								<td class="inp"><input type="text" name="txtaddstudname" id="txtaddstudname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddstuddeg">Degree : </label></td>
								<td class="inp">
									<select name="txtaddstuddeg" id="txtaddstuddeg">
										<option value="UG">UG</option>
										<option value="PG">PG</option>
										<option value="PHD">PHD</option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddstuddob">Date of Birth : </label></td>
								<td class="inp"><input type="text" name="txtaddstuddob" id="txtaddstuddob" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddstuddept">Department : </label></td>
								<td class="inp">
									<select name="txtaddstuddept" id="txtaddstuddept">
										<option value=""></option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddstudsen">Senior Supervisor : </label></td>
								<td class="inp"><input type="text" name="txtaddstudsen" id="txtaddstudsen" /></td>
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
		<div id="viewpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>View Student</h2>
				</header>
				<form action="" method="post" name="frmviewstud" id="frmviewstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtviewstudschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtviewstudschno" id="txtviewstudschno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewstudname">Student Name : </label></td>
								<td class="inp"><input type="text" name="txtviewstudname" id="txtviewstudname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewstuddeg">Degree : </label></td>
								<td class="inp"><input type="text" name="txtviewstuddeg" id="txtviewstuddeg" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewstuddob">Date of Birth : </label></td>
								<td class="inp"><input type="text" name="txtviewstuddob" id="txtviewstuddob" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewstuddept">Department : </label></td>
								<td class="inp"><input type="text" name="txtviewstuddept" id="txtviewstuddept" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewstudsen">Senior Supervisor : </label></td>
								<td class="inp"><input type="text" name="txtviewstudsen" id="txtviewstudsen" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnviewstud" id="btnviewstud" value="Close" />
					</footer>
				</form>
				<div id="studviewmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update Student</h2>
				</header>
				<form action="" method="post" name="frmupdstud" id="frmupdstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdstudschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtupdstudschno" id="txtupdstudschno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdstudname">Student Name : </label></td>
								<td class="inp"><input type="text" name="txtupdstudname" id="txtupdstudname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdstuddeg">Degree : </label></td>
								<td class="inp">
									<select name="txtupdstuddeg" id="txtupdstuddeg">
										<option value="UG">UG</option>
										<option value="PG">PG</option>
										<option value="PHD">PHD</option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdstuddob">Date of Birth : </label></td>
								<td class="inp"><input type="text" name="txtupdstuddob" id="txtupdstuddob" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdstuddept">Department : </label></td>
								<td class="inp">
									<select name="txtupdstuddept" id="txtupdstuddept">
										<option value=""></option>
									</select>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdstudsen">Senior Supervisor : </label></td>
								<td class="inp"><input type="text" name="txtupdstudsen" id="txtupdstudsen" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="txtoldstudschno" id="txtoldstudschno" value="" />
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
					<h2>Delete Student</h2>
				</header>
				<form action="" method="post" name="frmdelstud" id="frmdelstud">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelstudschno">Scholar Number : </label></td>
								<td class="inp"><input type="text" name="txtdelstudschno" id="txtdelstudschno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelstudname">Student Name : </label></td>
								<td class="inp"><input type="text" name="txtdelstudname" id="txtdelstudname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelstuddeg">Degree : </label></td>
								<td class="inp"><input type="text" name="txtdelstuddeg" id="txtdelstuddeg" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelstuddob">Date of Birth : </label></td>
								<td class="inp"><input type="text" name="txtdelstuddob" id="txtdelstuddob" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelstuddept">Department : </label></td>
								<td class="inp"><input type="text" name="txtdelstuddept" id="txtdelstuddept" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelstudsen">Senior Supervisor : </label></td>
								<td class="inp"><input type="text" name="txtdelstudsen" id="txtdelstudsen" /></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelstud" id="btndelstud" value="Delete" />
					</footer>
				</form>
				<div id="studdelmess" class="message">
					Do you want to delete this Student ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Student, MANIT
		</footer>
	</body>
</html>