<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projects/admin/lib/includes.php';

$uman = new UserManager();

if (is_ajax() && $uman->isLoggedIn())
{
	if (isset($_POST['action']) && !empty($_POST['action']))
	{
		$dbman = new DBManager();
		switch($_POST['action'])
		{
		case "getstud":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			try
			{
				$query = "select sch_no, name,degree,dob,dept_no,senior from student ";
				if (isset($_POST['dept_no']))
				{
					$query = $query . "where dept_no='" . $_POST['dept_no'] . "'";
				}
				$query = $query . ";";
				$res = $dbman->query($query);
				$data = [];
				$i = 0;
				while ($row = mysqli_fetch_row($res))
				{
					$data[$i] = [];
					$data[$i]['sch_no'] = $row[0];
					$data[$i]['name'] = $row[1];
					$data[$i]['degree'] = $row[2];
					$data[$i]['dob']=$row[3];
					$data[$i]['dept']=$row[4];
					$data[$i]['senior']=$row[5];
					$i++;
				}
				$result = "success";
			}
			catch (Exception $e)
			{
				$result = "error";
				$data = $e->getMessage();
			}
			finally
			{
				$retJson["result"] = $result;
				$retJson["data"] = $data;
				echo json_encode($retJson);
			}
			break;
		case "addstud":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtstudschno = $_POST['txtaddstudschno'];
			$txtstudname = $_POST['txtaddstudname'];
			$txtstuddeg = $_POST['txtaddstuddeg'];
			$txtstuddob = $_POST['txtaddstuddob'];
			$txtstuddept = $_POST['txtaddstuddept'];
			$txtstudsen = $_POST['txtaddstudsen'];
			
			try
			{
				$query = "insert into student(sch_no,name,degree,dob) ".
								" values('$txtstudschno','$txtstudname','$txtstuddeg','$txtstuddob');";
				$res1 = $dbman->query($query);
				$res2 = $res3 = true;
				if($res1)
				{
					if (!empty($txtstuddept))
					{
						$query = "update student set dept_no='$txtstuddept' where sch_no='$txtstudschno';";
						$res2 = $dbman->query($query);
					}
					if(!empty($txtstudsen))
					{
						$query = "update student set senior='$txtstudsen' where sch_no='$txtstudschno';";
						$res3 = $dbman->query($query);
					}
				}
							
				if ($res1 && $res2 && res3)
				{
					$result = "success";
					$data = "Student added successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to add student";
				}
			}
			catch (Exception $e)
			{
				$result = "error";
				$data = $e->getMessage();
			}
			finally
			{
				$retJson["result"] = $result;
				$retJson["data"] = $data;
				echo json_encode($retJson);
			}
			break;
		case "updstud":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";

			$txtstudschno = $_POST['txtupdstudschno'];
			$txtstudname = $_POST['txtupdstudname'];
			$txtstuddeg = $_POST['txtupdstuddeg'];
			$txtstuddob = $_POST['txtupdstuddob'];
			$txtstuddept = $_POST['txtupdstuddept'];
			$txtstudsen = $_POST['txtupdstudsen'];

			$txtoldstudschno = $_POST['txtoldstudschno'];
			
			try
			{
				$query = "update student set sch_no='$txtstudschno',name='$txtstudname',degree='$txtstuddeg'".
						", dob='$txtstuddob' where sch_no='$txtoldstudschno';";
				$res1 = $dbman->query($query);

				//if ($_POST['txtupdstuddept'] === '')
				//	$query = "update student set dept=NULL where sch_no='$txtoldstudschno';";

				$res2 = $res3 = true;
				if(!empty($txtstuddept))
				{
					$query = "update student set dept_no='$txtstuddept' where sch_no='$txtstudschno';";
					$res2 = $dbman->query($query);
				}

				if(!empty($txtstudsen))
				{
					$query = "update student set senior='$txtstudsen' where sch_no='$txtstudschno';";
					$res3 = $dbman->query($query);
				}

				if ($res1 && $res2 && $res3)
				{
					$result = "success";
					$data = "Student updated successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to update student";
				}
			}
			catch (Exception $e)
			{
				$result = "error";
				$data = $e->getMessage();
			}
			finally
			{
				$retJson["result"] = $result;
				$retJson["data"] = $data;
				echo json_encode($retJson);
			}
			break;
		case "delstud":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			$txtstudschno = $_POST['txtdelstudschno'];
			/* $txtstudname = $_POST['txtdelstudname'];
			$txtstuddeg = $_POST['txtdelstuddeg'];
			$txtstuddob = $_POST['txtdelstuddob'];
			$txtstuddept = $_POST['txtdelstuddept'];
			$txtstudsen = $_POST['txtdelstudsen']; */
			
			try
			{
				$query = "delete from student where sch_no='$txtstudschno';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Student deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to delete student";
				}
			}
			catch (Exception $e)
			{
				$result = "error";
				$data = $e->getMessage();
			}
			finally
			{
				$retJson["result"] = $result;
				$retJson["data"] = $data;
				echo json_encode($retJson);
			}
			break;
		}
	}
}

?>