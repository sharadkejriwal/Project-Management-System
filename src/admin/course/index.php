<?php

require_once '../lib/includes.php';
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
		<title>Manage course projects</title>
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
			<h2>Course Projects</h2>
			<table id="cors">
			</table>
		</div>
        <div id="viewpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>View Course Project</h2>
				</header>
                <form action="" method="post" name="frmviewcors" id="frmviewcors">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtviewprojno">Project Number : </label></td>
								<td class="inp"><input type="text" name="txtviewprojno" id="txtviewprojno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojtitle">Title : </label></td>
								<td class="inp"><input type="text" name="txtviewprojtitle" id="txtviewprojtitle" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojdesc">Description : </label></td>
								<td class="inp"><textarea name="txtviewprojdesc" id="txtviewprojdesc"></textarea></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojstartdate">Start Date : </label></td>
								<td class="inp"><input type="text" name="txtviewprojstartdate" id="txtviewprojstartdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojfinishdate">Finish Date : </label></td>
								<td class="inp"><input type="text" name="txtviewprojfinishdate" id="txtviewprojfinishdate"/></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojcompdate">Completed On : </label></td>
								<td class="inp"><input type="text" name="txtviewprojcompdate" id="txtviewprojcompdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewcorsdept">Department : </label></td>
								<td class="inp"><input type="text" name="txtviewcorsdept" id="txtviewcorsdept" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewcorsinvst">Investigator : </label></td>
								<td class="inp"><input type="text" name="txtviewcorsinvst" id="txtviewcorsinvst" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label>Semester : </label></td>
								<td class="inp">
									<label for="chksem1">1</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem1" value="1" />
									<label for="chksem2">2</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem2" value="2" />
									<label for="chksem3">3</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem3" value="3" />
									<label for="chksem4">4</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem4" value="4" />
									<label for="chksem5">5</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem5" value="5" />
									<br />
									<label for="chksem6">6</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem6" value="6" />
									<label for="chksem7">7</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem7" value="7" />
									<label for="chksem8">8</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem8" value="8" />
									<label for="chksem9">9</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chksem9" value="9" />
									<label for="chksem10">10</label>
									<input type="checkbox" readonly="readonly" name="chkprojsem[]" id="chksem10" value="10" />
									<br />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnviewcors" id="btnviewcors" value="Close" />
					</footer>
				</form>
                <div id="corsviewmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
                <div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update Course Project</h2>
				</header>
				<form action="" method="post" name="frmupdcors" id="frmupdcors">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdprojno">Project Number : </label></td>
								<td class="inp"><input type="text" name="txtupdprojno" id="txtupdprojno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojtitle">Title : </label></td>
								<td class="inp"><input type="text" name="txtupdprojtitle" id="txtupdprojtitle" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojdesc">Description : </label></td>
								<td class="inp"><textarea name="txtupdprojdesc" id="txtupdprojdesc"></textarea></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojstartdate">Start Date : </label></td>
								<td class="inp"><input type="text" name="txtupdprojstartdate" id="txtupdprojstartdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojfinishdate">Finish Date : </label></td>
								<td class="inp"><input type="text" name="txtupdprojfinishdate" id="txtupdprojfinishdate"/></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojcompdate">Completed On : </label></td>
								<td class="inp"><input type="text" name="txtupdprojcompdate" id="txtupdprojcompdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdcorsdept">Department : </label></td>
								<td class="inp"><input type="text" name="txtupdcorsdept" id="txtupdcorsdept" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdcorsinvst">Investigator : </label></td>
								<td class="inp"><input type="text" name="txtupdcorsinvst" id="txtupdcorsinvst" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label>Semester : </label></td>
								<td class="inp">
									<label for="chkupdsem1">1</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem1" value="1" />
									<label for="chkupdsem2">2</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem2" value="2" />
									<label for="chkpdusem3">3</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem3" value="3" />
									<label for="chkupdsem4">4</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem4" value="4" />
									<label for="chkupsem5">5</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem5" value="5" />
									<br />
									<label for="chkupdsem6">6</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem6" value="6" />
									<label for="chkupdsem7">7</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem7" value="7" />
									<label for="chkupdsem8">8</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem8" value="8" />
									<label for="chkupdsem9">9</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem9" value="9" />
									<label for="chkupdsem10">10</label>
									<input type="checkbox" name="chkupdprojsem[]" id="chkupdsem10" value="10" />
									<br />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
                    <input type="hidden" name="txtoldcorsprojno" id="txtoldcorsprojno" value="" />
					<footer>
						<input type="submit" name="btnupdcors" id="btnupdcors" value="Update" />
					</footer>
				</form>
				<div id="corsupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
        <div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete Course Project</h2>
				</header>
				<form action="" method="post" name="frmdelcors" id="frmdelcors">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelprojno">Project Number : </label></td>
								<td class="inp"><input type="text" name="txtdelprojno" id="txtdelprojno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojtitle">Title : </label></td>
								<td class="inp"><input type="text" name="txtdelprojtitle" id="txtdelprojtitle" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojdesc">Description : </label></td>
								<td class="inp"><textarea name="txtdelprojdesc" id="txtdelprojdesc"></textarea></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojstartdate">Start Date : </label></td>
								<td class="inp"><input type="text" name="txtdelprojstartdate" id="txtdelprojstartdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojfinishdate">Finish Date : </label></td>
								<td class="inp"><input type="text" name="txtdelprojfinishdate" id="txtdelprojfinishdate"/></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojcompdate">Completed On : </label></td>
								<td class="inp"><input type="text" name="txtdelprojcompdate" id="txtdelprojcompdate" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelcorsdept">Department : </label></td>
								<td class="inp"><input type="text" name="txtdelcorsdept" id="txtdelcorsdept" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelcorsinvst">Investigator : </label></td>
								<td class="inp"><input type="text" name="txtdelcorsinvst" id="txtdelcorsinvst" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label>Semester : </label></td>
								<td class="inp">
									<label for="chkdelsem1">1</label>
									<input type="checkbox" readonly="readonly" name="chkprojsem[]" id="chkdelsem1" value="1" />
									<label for="chkdelsem2">2</label>
									<input type="checkbox" readonly="readonly" name="chkprojsem[]" id="chkdelsem2" value="2" />
									<label for="chkdelsem3">3</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem3" value="3" />
									<label for="chkdelsem4">4</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem4" value="4" />
									<label for="chkdelsem5">5</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem5" value="5" />
									<br />
									<label for="chkdelsem6">6</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem6" value="6" />
									<label for="chkdelsem7">7</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem7" value="7" />
									<label for="chkdelsem8">8</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem8" value="8" />
									<label for="chkdelsem9">9</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem9" value="9" />
									<label for="chkdelsem10">10</label>
									<input type="checkbox" readonly="readonly"  name="chkprojsem[]" id="chkdelsem10" value="10" />
									<br />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelcors" id="btndelcors" value="Delete" />
					</footer>
				</form>
				<div id="corsdelmess" class="message">
					Do you want to delete this Project ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>