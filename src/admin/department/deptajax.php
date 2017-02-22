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
		case "getdept":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			try
			{
				$query = "select dept_no, name, hod from department;";
				$res = $dbman->query($query);
				$data = [];
				$i = 0;
				while ($row = mysqli_fetch_row($res))
				{
					$data[$i] = [];
					$data[$i]['dept_no'] = $row[0];
					$data[$i]['name'] = $row[1];
					$data[$i]['hod'] = $row[2];
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
		case "adddept":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtdeptno = empty($_POST['txtadddeptno']) ? "NULL" : "'" . $_POST['txtadddeptno'] . "'";
			$txtdeptname = empty($_POST['txtadddeptname']) ? "NULL" : "'" . $_POST['txtadddeptname'] . "'";
			$txtdepthod = empty($_POST['txtadddepthod']) ? "NULL" : "'" . $_POST['txtadddepthod'] . "'";
			
			try
			{
				$query = "insert into department values (" . $txtdeptno ."," . $txtdeptname
					. "," . $txtdepthod . ");";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Department added successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to add department";
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
		case "upddept":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			$txtdeptno = $_POST['txtupddeptno'];
			$txtdeptname = $_POST['txtupddeptname'];
			$txtdepthod = $_POST['txtupddepthod'];
			$txtolddeptno = $_POST['txtolddeptno'];
			
			try
			{
				if ($_POST['txtupddepthod'] === '')
					$query = "update department set dept_no='$txtdeptno', name='$txtdeptname', hod=NULL " .
						"where dept_no='$txtolddeptno';";
				else
					$query = "update department set dept_no='$txtdeptno', name='$txtdeptname', hod='$txtdepthod' " .
						"where dept_no='$txtolddeptno';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Department updated successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to update department";
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
		case "deldept":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			$txtdeptno = $_POST['txtdeldeptno'];
			$txtdeptname = $_POST['txtdeldeptname'];
			$txtdepthod = $_POST['txtdeldepthod'];
			
			try
			{
				$query = "delete from department where dept_no='$txtdeptno';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Department deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to delete department";
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
else
{
	if (!is_ajax())
	{
		$retJson = [];
		$retJson["result"] = "error";
		$retJson["data"] = "Only ajax request will be processed";
		echo json_encode($retJson);
	}
	else
	{
		$retJson = [];
		$retJson["result"] = "error";
		$retJson["data"] = "You must be logged in";
		echo json_encode($retJson);
	}
}

?>