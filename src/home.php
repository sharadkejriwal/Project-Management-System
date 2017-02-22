<?php

$conn = mysqli_connect('localhost', 'root', 'spk1996', 'proj_db');

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Projects Home</title>
		<script src="js/jquery.min.js"></script>
		<link href="prj.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<h1>Home</h1>
		</header>
		<div id="content">
			<div id="course" class="block">
				<h2>Course Projects</h2>
				You can browse the course projects through departments. <br />
				Faculty and student links are also available in corresponding department.
<?php

$query = "select dept_no, name from department;";
$res = mysqli_query($conn, $query);

$dept_cnt = mysqli_num_rows($res);

if ($dept_cnt === 0)
{
	
?>
				<span class="nothing">There are no departments</span><br />
<?php
	
}
else
{

?>
				<ul id="depts" class="list">
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
			<div id="common" class="block">
				<h2>Common Projects</h2>
<?php

$query = "select proj_no, title from common_proj join project using (proj_no);";
$res = mysqli_query($conn, $query);
$prj_cnt = mysqli_num_rows($res);

if ($prj_cnt === 0)
{
	
?>
				<span class="nothing">There are no common projects</span>
<?php
	
}
else
{
	
?>
				<ul id="cmmnprjs" class="list">
<?php
	
	while ($row = mysqli_fetch_row($res))
	{
		$href = "href=\"project.php?proj_no=" . $row[0] . "\"";
		$title = $row[1];
?>
					<li><a <?php echo $href; ?>><?php echo $title; ?></a></li>
<?php
	
	}
?>
				</li>
<?php
}

?>
			</div>
		</div>
		<footer>
		</footer>
	</body>
</html>