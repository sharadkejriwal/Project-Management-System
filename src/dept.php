<?php

$conn = mysqli_connect('localhost', 'root', 'spk1996', 'proj_db');

$dept_name = "Departments";
if (isset($_GET['dept_no']))
{
	$query = "select name from department where dept_no=" . $_GET['dept_no'] . ";";
	$res = mysqli_query($conn, $query);
	if (mysqli_num_rows($res) > 0)
	{
		$dept_no = $_GET['dept_no'];
		$dept_name = mysqli_fetch_row($res)[0];
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $dept_name; ?></title>
		<script src="js/jquery.min.js"></script>
		<link href="prj.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<h1><?php echo $dept_name; ?></h1>
		</header>
		<div id="content">
<?php 

if (!isset($dept_no))
{
	$query = "select dept_no, name from department;";
	$res = mysqli_query($conn, $query);

	$dept_cnt = mysqli_num_rows($res);

	if ($dept_cnt === 0)
	{
	
?>
			<span class="nothing">There are no departments</span>
<?php
		
	}
	else
	{
	
?>
			<nav id="depts">
<?php
		
		while ($row = mysqli_fetch_row($res))
		{
			$href = "href=\"?dept_no=" . $row[0] . "\"";
			$dept_name = $row[1];
			
?>
				<a <?php echo $href; ?>><?php echo $dept_name; ?></a>
<?php
	
		}
	
?>
			</nav>
<?php
		
	}
}
else
{
	/* faculty */
	$query = "select faculty_id, name from faculty join faculty_dept using (faculty_id) where dept_no=" . $dept_no . ";";
	$res = mysqli_query($conn, $query);
	
	$fclt_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Faculty</h2>
<?php
	
	if ($fclt_cnt === 0)
	{
?>
				<span class="nothing">There are no faculties</span>
<?php
	}
	else
	{
?>
				<ul class="list">
<?php
		while ($row = mysqli_fetch_row($res))
		{
			$href = "href=\"faculty.php?faculty_id=" . $row[0] . "\"";
			$fclt_name = $row[1];
?>
					<li><a <?php echo $href; ?>><?php echo $fclt_name; ?></a></li>
<?php 
		}
?>
				</ul>
<?php
	}
?>
			</div>
<?php
	/* student */
	$query = "select sch_no, s.name from student s join department d using (dept_no) where dept_no=" . $dept_no . ";";
	$res = mysqli_query($conn, $query);
	
	$stud_cnt = mysqli_num_rows($res);
	
?>
			<div class="block">
				<h2>Students</h2>
<?php 
	if ($stud_cnt === 0)
	{
?>
				<span class="nothing">There are no students</span>
<?php
	}
	else
	{
?>
				<ul class="list">
<?php
		while ($row = mysqli_fetch_row($res))
		{
			$href = "href=\"student.php?sch_no=" . $row[0] . "\"";
			$stud_name = $row[1];
?>
					<li><a <?php echo $href; ?>><?php echo $stud_name; ?></a></li>
<?php
		}
?>
				</ul>
<?php
	}
?>
			</div>
<?php
	
	/* project */
	$query = "select proj_no, title from course_proj join project using (proj_no) join department using (dept_no)" .
		" where dept_no=" . $dept_no . ";";
	$res = mysqli_query($conn, $query);
	
	$proj_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Projects</h2>
<?php
	if ($proj_cnt === 0)
	{
?>
				<span class="nothing">There are no projects</span>
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
<?php
	
}

?>
		</div>
		<footer>
		</footer>
	</body>
</html>