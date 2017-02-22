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
		case "getfclt":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			try
			{
				$query = "select faculty_id, name, birth_year, rank, research_spec from faculty;";
				$res = $dbman->query($query);
				$data = [];
				$i = 0;
				while ($row = mysqli_fetch_row($res))
				{
					$data[$i] = [];
					$data[$i]['faculty_id'] = $row[0];
					$data[$i]['name'] = $row[1];
					$data[$i]['birth_year'] = $row[2];
					$data[$i]['rank'] = $row[3];
					$data[$i]['research_spec'] = $row[4];
					
					$data[$i]['contact'] = [];
					$query2 = "select contact_no from contact_no where faculty=$row[0];";
					$res2 = $dbman->query($query2);
					$j = 0;
					while ($row2 = mysqli_fetch_row($res2))
					{
						$data[$i]['contact'][$j] = $row2[0];
						$j++;
					}
					
					$data[$i]['faculy_dept'] = [];
					$query2 = "select dept, time_percent from faculty_dept where faculty=$row[0];";
					$res2 = $dbman->query($query2);
					
					while ($row2 = mysqli_fetch_row($res2))
					{
						$data[$i]['faculty_dept']['dept'] = $row2[0];
						$data[$i]['faculty_dept']['dept'] = $row2[1];
					}
					
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
			
		case "addfclt":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtaddfcltid'];
			$txtfcltname = $_POST['txtaddfcltname'];
			$txtfcltyear = $_POST['txtaddfcltyear'];
			$txtfcltrank = $_POST['txtaddfcltrank'];
			$txtfcltspec = $_POST['txtaddfcltspec'];
			
			try
			{
				$query = "insert into faculty values ('$txtfcltid', '$txtfcltname',". 																								"'$txtfcltyear','$txtfcltrank','$txtfcltspec');";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Faculty added successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to add faculty";
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
			
		case "updfclt":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtupdfcltid'];
			$txtfcltname = $_POST['txtupdfcltname'];
			$txtfcltyear = $_POST['txtupdfcltyear'];
			$txtfcltrank = $_POST['txtupdfcltrank'];
			$txtfcltspec = $_POST['txtupdfcltspec'];
			$txtoldfcltid = $_POST['txtoldfcltid'];
			
			try
			{
				$query = "update faculty set faculty_id='$txtfcltid', name='$txtfcltname', birth_year='$txtfcltyear', " .
						"rank='$txtfcltrank', research_spec='$txtfcltspec' where faculty_id='$txtoldfcltid';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Faculty updated successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to update faculty";
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
			
		case "delfclt":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtdelfcltid'];
			
			try
			{
				$query = "delete from faculty where faculty_id='$txtfcltid';";
				
				$res = $dbman->query($query);
				$retJson["query"] = $query;
				
				if ($res)
				{
					$result = "success";
					$data = "Faculty deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "failed to delete faculty";
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