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
		case "getcont":
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
					
					$data['contact'] = [];
					
					$query = "select contact_no from contact_no where faculty_id='$fclt_id';";
					$res2 = $dbman->query($query);
					$i = 0;
					while ($row = mysqli_fetch_row($res2))
					{
						$data['contact'][$i] = $row[0];
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
			
		case "addcont":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtaddfcltid'];
			$txtcontno = $_POST['txtaddcontno'];
			
			try
			{
				$query = "insert into contact_no values ('$txtfcltid', '$txtcontno');";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Contact added successfully";
				}
				else
				{
					$result = "failed";
					$data = "Contact to add faculty";
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
			
		case "updcont":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtupdfcltid'];
			$txtcontno = $_POST['txtupdcontno'];
			$txtoldcontno = $_POST['txtoldcontno'];
			
			try
			{
				$query = "update contact_no set contact_no='$txtcontno' where faculty_id='$txtfcltid' " .
							" and contact_no='$txtoldcontno';";
				
				$res = $dbman->query($query);
				
				if ($res)
				{
					$result = "success";
					$data = "Contact updated successfully";
				}
				else
				{
					$result = "failed";
					$data = "Contact to update faculty";
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
			
		case "delcont":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			$txtfcltid = $_POST['txtdelfcltid'];
			$txtcontno = $_POST['txtdelcontno'];
			
			try
			{
				$query = "delete from contact_no where faculty_id='$txtfcltid' and contact_no='$txtcontno';";
				
				$res = $dbman->query($query);
				$retJson["query"] = $query;
				
				if ($res)
				{
					$result = "success";
					$data = "Contact deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "failed to delete contact";
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