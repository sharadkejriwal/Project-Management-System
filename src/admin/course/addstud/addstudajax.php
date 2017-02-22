<?php

require_once '../../lib/includes.php';

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
				$proj_no = $_POST['proj_no'];
				
				$query = "select title from project where proj_no='$proj_no';";
				$res1 = $dbman->query($query);
				$data = [];
				
				if (mysqli_num_rows($res1) > 0)
				{
					$data['proj_no'] = $proj_no;
					$data['title'] = mysqli_fetch_row($res1)[0];
					
					$data['student'] = [];
					
					$query = "select sch_no,supervisor from std_on_proj where proj_no='$proj_no';";
					$res2 = $dbman->query($query);
					$i = 0;
					while ($row = mysqli_fetch_row($res2))
					{
						$data['student'][$i]=[];
						$data['student'][$i][0] = $row[0];
						$data['student'][$i][1] = $row[1];
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
			
		case "addstud":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtprojno = empty($_POST['txtaddprojno']) ? "NULL" : "'" . $_POST['txtaddprojno'] . "'";
			$txtschno = empty($_POST['txtaddschno']) ? "NULL" : "'" . $_POST['txtaddschno'] . "'";
			$txtinvst = empty($_POST['txtaddinvst']) ? "NULL" : "'" . $_POST['txtaddinvst'] . "'";

			try
			{
				$query = "insert into std_on_proj values ($txtprojno, $txtschno, $txtinvst);";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Student and investigator added successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to add";
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
			
			$txtprojno = $_POST['txtupdprojno'];
			$txtschno = $_POST['txtupdschno'];
			$txtinvst = $_POST['txtupdinvst'];
			$txtoldschno = $_POST['txtoldschno'];
			
			try
			{
				$query = "update std_on_proj set sch_no='$txtschno',investigator='$txtinvst' where ".           " proj_no='$txtprojno' and sch_no='$txtoldschno';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Student and investigator updated successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to update";
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
			
			$txtprojno = $_POST['txtdelprojno'];
			$txtschno = $_POST['txtdelschno'];
			
			try
			{
				$query = "delete from std_on_proj where proj_no='$txtprojno' and sch_no='$txtschno';";
				
				$res = $dbman->query($query);
				$retJson["query"] = $query;
				
				if ($res)
				{
					$result = "success";
					$data = "Student and investigator deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to delete";
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