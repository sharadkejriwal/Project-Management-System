<?php

$conn = mysqli_connect('localhost', 'root', 'spk1996', 'proj_db');

if (isset($_GET['proj_no']))
{
	$query = "select title, description, start_date, finish_date from project where proj_no="
		. $_GET['proj_no'] . ";";
	$res = mysqli_query($conn, $query);
	
	if (mysqli_num_rows($res) > 0)
	{
		$row = mysqli_fetch_row($res);
		$proj_no = $_GET['proj_no'];
		$proj_title = $row[0];
		$proj_desc = $row[1];
		$proj_start_date = $row[2];
		$proj_finish_date = $row[3];
	}
}

if (!isset($proj_no))
	header("Location:home.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $proj_title; ?></title>
		<script src="js/jquery.min.js"></script>
		<link href="prj.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<h1>Project</h1>
		</header>
		<div id="content">
<?php

/* details */
?>
			<div class="block">
				<ul class="plist">
					<li>Project Title : <?php echo $proj_title; ?></li>
					<li>Project Desc : <?php echo $proj_desc; ?></li>
					<li>Start date : <?php echo $proj_start_date; ?></li>
					<li>Finish date : <?php echo $proj_finish_date; ?></li>
<?php
/* course */

$query = "select dept_no, d.name, faculty_id, f.name from course_proj cp join faculty f on cp.investigator=f.faculty_id "
	. "join department d using (dept_no) where proj_no=" . $proj_no . ";";
$res = mysqli_query($conn, $query);
					
if (mysqli_num_rows($res) > 0)
{
	$row = mysqli_fetch_row($res);
	$dept_no = $row[0];
	$dept_name = $row[1];
	$fclt_id = $row[2];
	$fclt_name = $row[3];
?>
					<li>
						Department :
						<a href=<?php echo '"dept.php?dept_no=' . $dept_no . '"'; ?>>
							<?php echo $dept_name; ?>
						</a>

					</li>
				</ul>
			</div>

<?php
	
	$query = "select sch_no, s.name, supervisor, f.name from std_on_proj sp join student s using (sch_no) "
		. "join faculty f on sp.supervisor=f.faculty_id where proj_no=" . $proj_no . ";";
	$res = mysqli_query($conn, $query);
	
	$stud_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Students in project</h2>
<?php
	if ($stud_cnt === 0)
	{
?>
				<span class="nothing">There are no student</span>
<?php
	}
	else
	{
?>
				<ul class="list">
<?php
		while ($row = mysqli_fetch_row($res))
		{
			$href1 = "href=\"student.php?sch_no=" . $row[0] . "\"";
			$stud_name = $row[1];
			$href2 = "href=\"faculty.php?faculty_id=" . $row[3] . "\"";
			$fclt_name = $row[3];
?>
					<li>
						<a <?php echo $href1; ?>><?php echo $stud_name; ?></a>
						under supervision of
						<a <?php echo $href2; ?>><?php echo $fclt_name; ?></a>
					</li>
<?php
		}
?>
				</ul>
<?php
	}
?>
			</div>
<?php
	
	$query = "select sem from course_proj_sem where proj_no=" . $proj_no . ";";
	$res = mysqli_query($conn, $query);
?>
			<div class="block">
				<h2>Associated semesters</h2>
<?php
	$sem_cnt = mysqli_num_rows($res);
	if ($sem_cnt === 0)
	{
?>
				<span class="nothing">No associated semesters</span>
<?php
	}
	else
	{
?>
				<ul class="list">
<?php
		while ($row = mysqli_fetch_row($res))
		{
			$sem = $row[0];
?>
					<li><?php echo $sem; ?></li>
<?php
		}
?>
				</ul>
<?php		
	}
?>
			</div>
<?php
}

/* common */
$query = "select amount, major_advisor, f.name from common_proj cp join faculty f on cp.major_advisor=f.faculty_id"
	. " where proj_no=" . $proj_no . ";";
$res = mysqli_query($conn, $res);

if (mysqli_num_rows($res) > 0)
{
	if (false)
	{
?>
			<div>
				<ul>
<?php
	}
	$row = mysqli_fetch_row($res);
	$amt = $row[0];
	$href = "href=\"faculty.php?faculty_id=" . $row[1] . "\"";
	$fclt_name = $row[1];
?>
					<li>
						Major Advisor : <a <?php echo $href; ?>><?php echo $fclt_name; ?></a>
					</li>
					<li>Amount : <?php echo $amt; ?></li>
				</ul>
			</div>
<?php
	$query = "select faculty_id, name from advisor a join faculty using (faculty_id) where proj_no=" . $proj_no . ";";
	$res = mysqli_query($conn, $query);
	
	$fclt_cnt = mysqli_num_rows($res);
	if ($fclt_cnt === 0)
	{
		
	}
	else
	{
		while ($row = mysqli_fetch_row($res))
		{
			$href = "href=\"faculty.php?faculty_id=" . $row[0] . "\"";
			$fclt_name = $row[1];
		}
	}
}

?>
			
		</div>
		<footer>
		</footer>
	</body>
</html>