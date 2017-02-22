<?php

require_once '../lib/includes.php';

$uman = new UserManager();

if (is_ajax() && $uman->isLoggedIn())
{
	if (isset($_POST['action']) && !empty($_POST['action']))
	{
		$dbman = new DBManager();
		switch($_POST['action'])
        {
		case "getcmmn":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			try
			{
				$query = "select proj_no, title, description, start_date, finish_date, completed_on, amount, major_advisor from project join common_proj using (proj_no);";
				$res = $dbman->query($query);
				$data = [];
				$i = 0;
				while ($row = mysqli_fetch_row($res))
				{
					$data[$i] = [];
					$data[$i]['proj_no'] = $row[0];
					$data[$i]['title'] = $row[1];
					$data[$i]['description'] = $row[2];
					$data[$i]['start_date'] = $row[3];
					$data[$i]['finish_date'] = $row[4];
					$data[$i]['completed_on'] = $row[5];
					$data[$i]['amount'] = $row[6];
					$data[$i]['major_advisor'] = $row[7];
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
		case "updcmmn":
			
			
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			/* $retJson["result"] = $result;
			$retJson["data"] = $_POST;
			echo json_encode($retJson); */
			
			$txtprojno = empty($_POST['txtupdprojno']) ? "NULL" : $_POST['txtupdprojno'];
			$txttitle = empty($_POST['txtupdprojtitle']) ? "NULL" : "'" . $_POST['txtupdprojtitle'] . "'";
			$txtdesc = empty($_POST['txtupdprojdesc']) ? "NULL" : "'" . $_POST['txtupdprojdesc'] . "'";
			$txtstdate = empty($_POST['txtupdprojstartdate']) ? "NULL" : "'" . $_POST['txtupdprojstartdate'] . "'";
			$txtfndate = empty($_POST['txtupdprojfinishdate']) ? "NULL" : "'" . $_POST['txtupdprojfinishdate'] . "'";
			$txtcompdate = empty($_POST['txtupdprojcompdate']) ? "NULL" : "'" . $_POST['txtupdprojcompdate'] . "'";
			$txtamt = empty($_POST['txtupdcmmnamt']) ? "NULL" : "'" . $_POST['txtupdcmmnamt'] . "'";
			$txtmjadv = empty($_POST['txtupdcmmnmjadv']) ? "NULL" : "'" . $_POST['txtupdcmmnmjadv'] . "'";
			
			$txtoldcmmnprojno = empty($_POST['txtoldcmmnprojno']) ? "NULL" : $_POST['txtoldcmmnprojno'];
			
			
			
			try
			{
				$query = "update project set proj_no=$txtprojno, ".
				"title=$txttitle," .
				"description=$txtdesc," .
				"start_date=$txtstdate," .
				"finish_date=$txtfndate," .
				"completed_on=$txtcompdate".					
				" where proj_no=$txtoldcmmnprojno;";
				$res1 = $dbman->query($query);

				$query = "update common_proj set proj_no=$txtprojno, ".
				"amount=$txtamt, ".
				"major_advisor=$txtmjadv" .
				" where proj_no=$txtprojno;";
				
				$res2 = $dbman->query($query);
				
				$data = "$query";
				
				if($res1 && $res2)
				{
					$result="success";
					$data="Project updated successfully";
				}
				else 
				{
					$result="error";
					$data= $data . "Failed to update project";
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
			
			
		case "delcmmn":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			$txtcmmnprojno = empty($_POST['txtdelprojno']) ? "NULL" : "'" . $_POST['txtdelprojno'] . "'";
			/* $txtstudname = $_POST['txtdelstudname'];
			$txtstuddeg = $_POST['txtdelstuddeg'];
			$txtstuddob = $_POST['txtdelstuddob'];
			$txtstuddept = $_POST['txtdelstuddept'];
			$txtstudsen = $_POST['txtdelstudsen']; 
			*/
			
			try
			{
				$query = "delete from project where proj_no=$txtcmmnprojno;";
				
				$res = $dbman->query($query);
                $retJson["query"] = $query;
				
				
				if ($res)
				{
					$result = "success";
					$data = "Common Project deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to delete Common Project";
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
					