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
				$fclt_id = $_POST['faculty_id'];
				
				$query = "select name from faculty where faculty_id='$fclt_id';";
				$res1 = $dbman->query($query);
				$data = [];
				
				if (mysqli_num_rows($res1) > 0)
				{
					$data['faculty_id'] = $fclt_id;
					$data['name'] = mysqli_fetch_row($res1)[0];
					
					$data['department'] = [];
					
					$query = "select dept_no,time_percent from faculty_dept where faculty_id='$fclt_id';";
					$res2 = $dbman->query($query);
					$i = 0;
					while ($row = mysqli_fetch_row($res2))
					{
						$data['department'][$i][0] = $row[0];
						$data['department'][$i][1] = $row[1];
						$i++;
					}
					
					$result = "success";
				}
				else
				{
					$result = "goback";
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
			
		case "adddept":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtaddfcltid'];
			$txtdeptno = $_POST['txtadddeptno'];
			$txttime = $_POST['txtaddtime'];
			
			try
			{
				$query = "insert into faculty_dept values ('$txtfcltid', '$txtdeptno','$txttime');";
				
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
			
			$txtfcltid = $_POST['txtupdfcltid'];
			$txtdeptno = $_POST['txtupddeptno'];
			$txttime = $_POST['txtupdtime'];
			$txtolddeptno = $_POST['txtolddeptno'];
			
			try
			{
				$query = "update faculty_dept set dept_no='$txtdeptno',time_percent='$txttime' ".
							"where faculty_id='$txtfcltid' and dept_no='$txtolddeptno';";
				
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
			
			$txtfcltid = $_POST['txtdelfcltid'];
			$txtdeptno = $_POST['txtdeldeptno'];
			//$txttime = $_POST['txtdeltime'];
			
			try
			{
				$query = "delete from faculty_dept where faculty_id='$txtfcltid' and dept_no='$txtdeptno';";
				
				$res = $dbman->query($query);
				$retJson["query"] = $query;
				
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

?>