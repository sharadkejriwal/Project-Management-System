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
				$proj_no = empty($_POST['proj_no'])  ? "NULL" : $_POST['proj_no'];
				
				$query = "select title from project where proj_no=$proj_no;";
				$res1 = $dbman->query($query);
				$data = [];
				
				if (mysqli_num_rows($res1) > 0)
				{
					$data['proj_no'] = rtrim($proj_no);
					$data['title'] = mysqli_fetch_row($res1)[0];
					
					$data['student'] = [];
					
					$query = "select sch_no from member where proj_no=$proj_no;";
					$res2 = $dbman->query($query);
					$i = 0;
					while ($row = mysqli_fetch_row($res2))
					{
						//$data['student'][$i]=[];
						$data['student'][$i] = $row[0];
						//$data['student'][$i][1] = $row[1];
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
			
			$txtprojno = empty($_POST['txtaddprojno']) ? "NULL" : "'" .$_POST['txtaddprojno'] . "'";
			$txtschno = empty($_POST['txtaddschno'])  ? "NULL" : "'" . $_POST['txtaddschno']. "'";

			try
			{
				$query = "insert into member values ($txtprojno, $txtschno);";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Student added successfully";
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
			
			$txtprojno = empty($_POST['txtupdprojno'])  ? "NULL" : "'" .$_POST['txtupdprojno']. "'";
			$txtschno = empty($_POST['txtupdschno'])  ? "NULL" : "'" .$_POST['txtupdschno']. "'";
			$txtoldschno = empty($_POST['txtoldschno'])  ? "NULL" : "'" . $_POST['txtoldschno'] . "'";
			
			try
			{
				$query = "update member set sch_no=$txtschno where ". 
				          " proj_no=$txtprojno and sch_no=$txtoldschno;";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Student updated successfully";
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
			
			$txtprojno = empty($_POST['txtdelprojno'])  ? "NULL" : "'" .$_POST['txtdelprojno'] . "'";
			$txtschno = empty($_POST['txtdelschno'])  ? "NULL" : "'" . $_POST['txtdelschno'] . "'";
			
			try
			{
				$query = "delete from member where proj_no=$txtprojno and sch_no=$txtschno;";
				
				$res = $dbman->query($query);
				$retJson["query"] = $query;
				
				if ($res)
				{
					$result = "success";
					$data = "Student deleted successfully";
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