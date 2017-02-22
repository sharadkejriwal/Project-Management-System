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
		case "getcors":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			try
			{
				$query = "select proj_no, title, description, start_date, finish_date, completed_on, dept_no, investigator from project join course_proj using (proj_no);";
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
					$data[$i]['dept'] = $row[6];
					$data[$i]['investigator'] = $row[7];
                    $data[$i]['sem'] = [];
					$query2 = "select sem from course_proj_sem where proj_no=$row[0];";
					$res2 = $dbman->query($query2);
					$j = 0;
					while ($row2 = mysqli_fetch_row($res2))
					{
						$data[$i]['sem'][$j] = $row2[0];
						$j++;
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
		case "updcors":
			
			
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			/* $retJson["result"] = $result;
			$retJson["data"] = $_POST;
			echo json_encode($retJson); */
			
			$txtprojno = $_POST['txtupdprojno'];
			$txttitle = $_POST['txtupdprojtitle'];
			$txtdesc = $_POST['txtupdprojdesc'];
			$txtstdate = $_POST['txtupdprojstartdate'];
			$txtfndate = $_POST['txtupdprojfinishdate'];
			$txtcompdate = $_POST['txtupdprojcompdate'];
			$txtdept = $_POST['txtupdcorsdept'];
			$txtinvst = $_POST['txtupdcorsinvst'];
			$sem_arr = [];
			if (isset($_POST['chkupdprojsem']))
					$sem_arr = $_POST['chkupdprojsem'];
			
			$txtoldcorsprojno=$_POST['txtoldcorsprojno'];
			
			
			
			try
			{
				$query = "update project set proj_no='$txtprojno', ".
				"title=".(empty($txttitle) ? "NULL" : "'$txttitle'"). "," .
				"description=".(empty($txtdesc) ? "NULL" : "'$txtdesc'") . "," .
				"start_date=".(empty($txtstdate) ? "NULL" : "'$txtstdate'") . "," .
				"finish_date=".(empty($txtfndate) ? "NULL" : "'$txtfndate'") . "," .
				"completed_on=".(empty($txtcompdate) ? "NULL" : "'$txtcompdate'").					
				" where proj_no='$txtoldcorsprojno';";
				$res1 = $dbman->query($query);

				$query = "update course_proj set proj_no='$txtprojno', ".
				"dept_no=".(empty($txtdept) ? "NULL" : "'$txtdept'").", ".
				"investigator=".(empty($txtinvst) ? "NULL" : "'$txtinvst'") .
				" where proj_no='$txtprojno';";
				
				$data = "$query";
				
				$res2=$dbman->query($query);

				$query = "delete from course_proj_sem where proj_no='$txtprojno';";
				$res3=$dbman->query($query);

				$res4=true;

				foreach ($sem_arr as $sem)
				{
					$query = "insert into course_proj_sem values ('$txtprojno', '$sem');";

					$res4 = $res4 and $dbman->query($query);
				}
				if($res1 && $res2 && $res3 && $res4)
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
			
			
		case "delcors":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			$txtcorsprojno = $_POST['txtdelprojno'];
			/* $txtstudname = $_POST['txtdelstudname'];
			$txtstuddeg = $_POST['txtdelstuddeg'];
			$txtstuddob = $_POST['txtdelstuddob'];
			$txtstuddept = $_POST['txtdelstuddept'];
			$txtstudsen = $_POST['txtdelstudsen']; 
			*/
			
			try
			{
				$query = "delete from project where proj_no='$txtcorsprojno';";
				
				$res = $dbman->query($query);
                $retJson["query"] = $query;
				
				
				if ($res)
				{
					$result = "success";
					$data = "Course Project deleted successfully";
				}
				else
				{
					$result = "failed";
					$data = "Failed to delete Course Project";
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
					