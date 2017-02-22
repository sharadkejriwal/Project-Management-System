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
		<title>Manage common projects</title>
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
			<h2>Common Projects</h2>
			<table id="cmmn">
			</table>
		</div>
        <div id="viewpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>View Common Project</h2>
				</header>
                <form action="" method="post" name="frmviewcmmn" id="frmviewcmmn">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtviewprojno">Project Number : </label></td>
								<td class="inp">
									<input type="text" name="txtviewprojno" id="txtviewprojno" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojtitle">Title : </label></td>
								<td class="inp">
									<input type="text" name="txtviewprojtitle" id="txtviewprojtitle" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojdesc">Description : </label></td>
								<td class="inp">
									<textarea name="txtviewprojdesc" id="txtviewprojdesc"></textarea>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojstartdate">Start Date : </label></td>
								<td class="inp">
									<input type="text" name="txtviewprojstartdate" id="txtviewprojstartdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojfinishdate">Finish Date : </label></td>
								<td class="inp">
									<input type="text" name="txtviewprojfinishdate" id="txtviewprojfinishdate"/>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewprojcompdate">Completed On : </label></td>
								<td class="inp">
									<input type="text" name="txtviewprojcompdate" id="txtviewprojcompdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewcmmnamt">Amount : </label></td>
								<td class="inp">
									<input type="text" name="txtviewcmmnamt" id="txtviewcmmnamt" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtviewcmmnmjadv">Major Advisor : </label></td>
								<td class="inp">
									<input type="text" name="txtviewcmmnmjadv" id="txtviewcmmnmjadv" />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btnviewcmmn" id="btnviewcmmn" value="Close" />
					</footer>
				</form>
                <div id="cmmnsviewmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
                <div id="updpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Update Course Project</h2>
				</header>
				<form action="" method="post" name="frmupdcmmn" id="frmupdcmmn">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtupdprojno">Project Number : </label></td>
								<td class="inp"><input type="text" name="txtupdprojno" id="txtupdprojno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojtitle">Title : </label></td>
								<td class="inp">
									<input type="text" name="txtupdprojtitle" id="txtupdprojtitle" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojdesc">Description : </label></td>
								<td class="inp">
									<textarea name="txtupdprojdesc" id="txtupdprojdesc"></textarea>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojstartdate">Start Date : </label></td>
								<td class="inp">
									<input type="text" name="txtupdprojstartdate" id="txtupdprojstartdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojfinishdate">Finish Date : </label></td>
								<td class="inp">
									<input type="text" name="txtupdprojfinishdate" id="txtupdprojfinishdate"/>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdprojcompdate">Completed On : </label></td>
								<td class="inp">
									<input type="text" name="txtupdprojcompdate" id="txtupdprojcompdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdcmmnamt">Amount : </label></td>
								<td class="inp">
									<input type="text" name="txtupdcmmnamt" id="txtupdcmmnamt" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtupdcmmnmjadv">Major Advisor : </label></td>
								<td class="inp">
									<input type="text" name="txtupdcmmnmjadv" id="txtupdcmmnmjadv" />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
                    <input type="hidden" name="txtoldcmmnprojno" id="txtoldcmmnprojno" value="" />
					<footer>
						<input type="submit" name="btnupdcmmn" id="btnupdcmmn" value="Update" />
					</footer>
				</form>
				<div id="cmmnupdmess" class="message" hidden="hidden">
				</div>
			</div>
		</div>
        <div id="delpanel" class="popupback" hidden="hidden">
			<div class="popup">
				<header>
					<span class="close">X</span>
					<h2>Delete Course Project</h2>
				</header>
				<form action="" method="post" name="frmdelcmmn" id="frmdelcmmn">
					<table>
						<tbody>
							<tr>
								<td class="lbl"><label for="txtdelprojno">Project Number : </label></td>
								<td class="inp"><input type="text" name="txtdelprojno" id="txtdelprojno" /></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojtitle">Title : </label></td>
								<td class="inp">
									<input type="text" name="txtdelprojtitle" id="txtdelprojtitle" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojdesc">Description : </label></td>
								<td class="inp">
									<textarea name="txtdelprojdesc" id="txtdelprojdesc"></textarea></td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojstartdate">Start Date : </label></td>
								<td class="inp">
									<input type="text" name="txtdelprojstartdate" id="txtdelprojstartdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojfinishdate">Finish Date : </label></td>
								<td class="inp">
									<input type="text" name="txtdelprojfinishdate" id="txtdelprojfinishdate"/>
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelprojcompdate">Completed On : </label></td>
								<td class="inp">
									<input type="text" name="txtdelprojcompdate" id="txtdelprojcompdate" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelcmmnamt">Amount : </label></td>
								<td class="inp">
									<input type="text" name="txtdelcmmnamt" id="txtdelcmmnamt" />
								</td>
								<td class="err"></td>
							</tr>
							<tr>
								<td class="lbl"><label for="txtdelcmmnmjadv">Major Advisor : </label></td>
								<td class="inp">
									<input type="text" name="txtdelcmmnmjadv" id="txtdelcmmnmjadv" />
								</td>
								<td class="err"></td>
							</tr>
						</tbody>
					</table>
					<footer>
						<input type="submit" name="btndelcmmn" id="btndelcmmn" value="Delete" />
					</footer>
				</form>
				<div id="cmmndelmess" class="message">
					Do you want to delete this Project ?
				</div>
			</div>
		</div>
		<footer>
			Computer Science Department, MANIT
		</footer>
	</body>
</html>