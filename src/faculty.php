<?php

$conn = mysqli_connect('localhost', 'root', 'spk1996', 'proj_db');

if (isset($_GET['faculty_id']))
{
	$query = "select name, rank, research_spec from faculty where faculty_id="
		. $_GET['faculty_id'] . ";";
	$res = mysqli_query($conn, $query);
	
	if(mysqli_num_rows($res) > 0)
	{
		$fclt_id = $_GET['faculty_id'];
		$row = mysqli_fetch_row($res);
		$fclt_name = $row[0];
		$fclt_rank = $row[1];
		$fclt_spec = $row[2];
	}
}

if (!isset($fclt_name))
	header("Location:home.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $fclt_name; ?></title>
		<script src="js/jquery.min.js"></script>
		<link href="prj.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<h1>Faculty</h1>
		</header>
		<div id="content">
<?php

/* profile */
?>
			<div class="block">
				<h2>Profile</h2>
				<ul class="plist">
					<li>Name : <?php echo $fclt_name; ?></li>
					<li>Rank : <?php echo $fclt_rank; ?></li>
					<li>Research speciality : <?php echo $fclt_spec; ?></li>
<?php
/* contact no */
$query = "select contact_no from faculty join contact_no using (faculty_id) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$cont_cnt = mysqli_num_rows($res);

if ($cont_cnt === 0)
{
	
}
else
{
	$i = 1;
	while ($row = mysqli_fetch_row($res))
	{
		$cont_no = $row[0];
?>
					<li>Contact Number <?php echo $i; ?> : <?php echo $cont_no; ?></li>
<?php
		$i++;
	}
}
?>
					
				</ul>
			</div>
<?php
/* department */
$query = "select dept_no, d.name from faculty join faculty_dept using (faculty_id)"
	. " join department d using (dept_no) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$dept_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Departments</h2>
<?php
if ($dept_cnt === 0)
{
?>
				<span class="nothing">This faculty is not working in any department</span>
<?php
}
else
{
?>
				<ul class="list">
<?php
	while ($row = mysqli_fetch_row($res))
	{
		$href = "href=\"dept.php?dept_no=" . $row[0] . "\"";
		$dept_name = $row[1];
?>
					<li><a <?php echo $href; ?>><?php echo $dept_name; ?></a></li>
<?php
	}
?>
				</ul>
<?php
}
?>
			</div>
<?php

/* supervisor */
$query = "select proj_no, title, sch_no, std.name from faculty f join std_on_proj sp on f.faculty_id=sp.supervisor " .
	" join project using (proj_no) join student std using (sch_no) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);

?>
			<div class="block">
				<h2>Supervisor for following projects</h2>
<?php
if ($proj_cnt === 0)
{
?>
				<span class="nothing">There are no projects being supervised</span>
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
		$href2 = "href=\"student.php?sch_no=" . $row[2] . "\"";
		$stud_name = $row[3];
?>
					<li>
						<a <?php echo $href2; ?>><?php echo $stud_name; ?></a>
						on project
						<a <?php echo $href1; ?>><?php echo $proj_title; ?></a>
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

/* investigator */
$query = "select proj_no, title from faculty f join course_proj cp on f.faculty_id=cp.investigator " .
	"join project using (proj_no) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Investigator for following project</h2>
<?php

if ($proj_cnt === 0)
{
?>
				<span class="nothing">There are no projects being investigated</span>
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

/* major advisor */
$query = "select proj_no, title from faculty f join common_proj cp on f.faculty_id=cp.major_advisor " .
	"join project using (proj_no) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Major advisor for following projects</h2>
<?php

if ($proj_cnt === 0)
{
?>
				<span class="nothing">Not major advisor for any project</span>
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

/* co-advisor */
$query = "select proj_no, title from faculty f join advisor using (faculty_id) " .
	"join project using (proj_no) where faculty_id=" . $fclt_id . ";";
$res = mysqli_query($conn, $query);

$proj_cnt = mysqli_num_rows($res);
?>
			<div class="block">
				<h2>Co-advisor for following project</h2>
<?php
if ($proj_cnt === 0)
{
?>
				<span class="nothing">Not co-advisor for any project</span>
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