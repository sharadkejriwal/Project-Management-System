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
		<title>Manage faculty</title>
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
			<h2>Faculty</h2>
			<table id="fclt">
			</table>
			<span id="addfclt">
				<span>+</span>
				Add Faculty
			</span>
		</div>
		<div id="addpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Add Faculty</h2>
				</header>
				<form action="" method="post" name="frmaddfclt" id="frmaddfclt">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtaddfcltid">Faculty ID : </label></td>
								<td class="inp"><input type="text" name="txtaddfcltid" id="txtaddfcltid" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddfcltname">Faculty Name : </label></td>
								<td class="inp"><input type="text" name="txtaddfcltname" id="txtaddfcltname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddfcltyear">Birth Year : </label></td>
								<td class="inp"><input type="text" name="txtaddfcltyear" id="txtaddfcltyear" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddfcltrank">Faculty Rank : </label></td>
								<td class="inp"><input type="text" name="txtaddfcltrank" id="txtaddfcltrank" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtaddfcltspec">Research Speciality : </label></td>
								<td class="inp"><textarea name="txtaddfcltspec" id="txtaddfcltspec"></textarea></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnaddfclt" id="btnaddfclt" value="Add" />
					</footer>
				</form>
				<div id="fcltaddmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="viewpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>View Faculty</h2>
				</header>
				<form action="" method="post" name="frmviewfclt" id="frmviewfclt">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtviewfcltid">Faculty ID : </label></td>
								<td class="inp"><input type="text" name="txtviewfcltid" id="txtviewfcltid" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewfcltname">Faculty Name : </label></td>
								<td class="inp"><input type="text" name="txtviewfcltname" id="txtviewfcltname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewfcltyear">Birth Year : </label></td>
								<td class="inp"><input type="text" name="txtviewfcltyear" id="txtviewfcltyear" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewfcltrank">Faculty Rank : </label></td>
								<td class="inp"><input type="text" name="txtviewfcltrank" id="txtviewfcltrank" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewfcltspec">Research Speciality : </label></td>
								<td class="inp"><textarea name="txtviewfcltspec" id="txtviewfcltspec"></textarea></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnviewfclt" id="btnviewfclt" value="Close" />
					</footer>
				</form>
				<div id="fcltviewmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update Faculty</h2>
				</header>
				<form action="" method="post" name="frmupdfclt" id="frmupdfclt">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdfcltid">Faculty ID : </label></td>
								<td class="inp"><input type="text" name="txtupdfcltid" id="txtupdfcltid" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdfcltname">Faculty Name : </label></td>
								<td class="inp"><input type="text" name="txtupdfcltname" id="txtupdfcltname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdfcltyear">Birth Year : </label></td>
								<td class="inp"><input type="text" name="txtupdfcltyear" id="txtupdfcltyear" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdfcltrank">Faculty Rank : </label></td>
								<td class="inp"><input type="text" name="txtupdfcltrank" id="txtupdfcltrank" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdfcltspec">Research Speciality : </label></td>
								<td class="inp"><textarea name="txtupdfcltspec" id="txtupdfcltspec"></textarea></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="txtoldfcltid" id="txtoldfcltid" value="" />
					<footer>
						<input type="submit" name="btnupdfclt" id="btnupdfclt" value="Update" />
					</footer>
				</form>
				<div id="fcltupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
		<div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete Faculty</h2>
				</header>
				<form action="" method="post" name="frmdelfclt" id="frmdelfclt">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelfcltid">Faculty ID : </label></td>
								<td class="inp"><input type="text" name="txtdelfcltid" id="txtdelfcltid" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelfcltname">Faculty Name : </label></td>
								<td class="inp"><input type="text" name="txtdelfcltname" id="txtdelfcltname" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelfcltyear">Birth Year : </label></td>
								<td class="inp"><input type="text" name="txtdelfcltyear" id="txtdelfcltyear" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelfcltrank">Faculty Rank : </label></td>
								<td class="inp"><input type="text" name="txtdelfcltrank" id="txtdelfcltrank" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelfcltspec">Research Speciality : </label></td>
								<td class="inp"><textarea name="txtdelfcltspec" id="txtdelfcltspec"></textarea></td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelfclt" id="btndelfclt" value="Delete" />
					</footer>
				</form>
				<div id="fcltdelmess" class="message">
					Do you want to delete this Faculty ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>