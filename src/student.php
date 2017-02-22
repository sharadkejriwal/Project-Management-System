<?php

$conn = mysqli_connect('localhost', 'root', 'spk1996', 'proj_db');

if (isset($_GET['sch_no']))
{
	$query = "select s.name, degree, dept_no, d.name from student s "
		. "join department d using (dept_no) where sch_no=" . $_GET['sch_no'] . ";";
	$res = mysqli_query($conn, $query);
	
	if (mysqli_num_rows($res) > 0)
	{
		$row = mysqli_fetch_row($res);
		$sch_no = $_GET['sch_no'];
		$stud_name = $row[0];
		$stud_deg = $row[1];
		$dept_no = $row[2];
		$dept_name = $row[3];
	}
}

if (!isset($stud_name))
	header("Location:home.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Faculty</title>
		<script src="js/jquery.min.js"></script>
		<link href="prj.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<h1>Student</h1>
		</header>
		<div id="content">
<?php

/* profile */
?>
			<div class="block">
				<ul class="plist">
					<li>Name : <?php echo $stud_name; ?></li>
					<li>Degree : <?php echo $stud_deg;?></li>
					<li>
						Department : 
						<a href=<?php echo '"dept.php?dept_no=' . $dept_no . '"'; ?>><?php echo $dept_name; ?></a>
					</li>
				</ul>
			</div>
<?php

/* course project */
$query = "select proj_no, title, faculty_id, f.name from student join std_on_proj sp using (sch_no)"
	. "join project using (proj_no) join faculty f on sp.supervisor=f.faculty_id where sch_no="
	. $sch_no . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);

?>
			<div class="block">
				<h2>Course Project</h2>
<?php
if ($proj_cnt === 0)
{
?>
				<span class="nothing">There are no course project</span>
<?php
}
else
{
?>
				<ul class="list">
<?php
	while ($row = mysqli_fetch_row($res))
	{
		$href1 = "href=\"project.php?proj_no=" . $row[0] . "\"";
		$proj_title = $row[1];
		$href2 = "href=\"faculty.php?faculty_id=" . $row[2] . "\"";
		$faculty_name = $row[3];
?>
					<li>
						<a <?php echo $href1; ?>><?php echo $proj_title; ?></a>
						under supervision of
						<a <?php echo $href2; ?>><?php echo $faculty_name; ?></a>
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

/* common project */
$query = "select proj_no, title from student join member using (sch_no) "
	. "join project using (proj_no) where sch_no=" . $sch_no . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Common Project</h2>
<?php

if ($proj_cnt === 0)
{
?>
				<span class="nothing">There are no common project</span>
<?php
}
else
{
?>
				<ul class="list">
<?php
	while ($row = mysqli_fetch_row($res))
	{
		$href = "href=\"project.php?proj_no=" . $row[0] . "\"";
		$proj_title = $row[1];
?>
					<li><a <?php echo $href; ?>><?php echo $proj_title; ?></a></li>
<?php
	}
?>
				</ul>
<?php
}

?>
			</div>
		</div>
		<footer>
		</footer>
	</body>
</html>