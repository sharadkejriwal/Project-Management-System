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
		case "addproj":
			$retJson = [];
			$result = "error";
			$data = "Something went wrong";
			
			/* $retJson["result"] = $result;
			$retJson["data"] = $_POST;
			echo json_encode($retJson); */
			
			$txtprojno = empty($_POST['txtprojno']) ? "NULL" : "'" . $_POST['txtprojno'] . "'"; 
			$txttitle = empty($_POST['txtprojtitle']) ? "NULL" : "'" . $_POST['txtprojtitle'] . "'"; ;
			$txtdesc = empty($_POST['txtprojdesc']) ? "NULL" : "'" . $_POST['txtprojdesc'] . "'"; ;
			$txtstdate = empty($_POST['txtprojstartdate']) ? "NULL" : "'" . $_POST['txtprojstartdate'] . "'"; ;
			$txtfndate =empty( $_POST['txtprojfinishdate'] ) ? "NULL" : "'" . $_POST['txtprojfinishdate'] . "'"; ;
			$txtcompdate = empty($_POST['txtprojcompdate']) ? "NULL" : "'" . $_POST['txtprojcompdate'] . "'"; ;
			$txtdept = "";
			$txtinvst = "";
			$sem_arr = [];
			$txtmjadv = "";
			$txtamt = "";
			$type = "";
			
			if (isset($_POST['radprojtype']))
			{
				$type = $_POST['radprojtype'];
				if ($type === "course")
				{
					$txtdept = empty($_POST['txtprojdept']) ? "NULL" : "'" . $_POST['txtprojdept'] . "'";
					$txtinvst = empty($_POST['txtprojinvst']) ? "NULL" : "'" . $_POST['txtprojinvst'] . "'";
					if (isset($_POST['chkprojsem']))
						$sem_arr = $_POST['chkprojsem'];
				}
				elseif ($type === "common")
				{
					$txtmjadv = empty($_POST['txtprojmjadv']) ? "NULL" : "'" . $_POST['txtprojmjadv'] . "'";
					$txtamt = empty($_POST['txtprojamt']) ? "NULL" : "'" . $_POST['txtprojamt'] . "'";
				}
				else 
				{
					$result = "error";
					$data = "Type of project not specified";
				}
			}
			else
			{
				$result = "error";
				$data = "Type of project not specified";
			}
			
			try
			{
				if ($type === "course" || $type === "common")
				{
					$query = "insert into project values (" .
						"$txtprojno," .
						"$txttitle," .
						"$txtdesc," .
						"$txtstdate," .
						"$txtfndate," .
						"$txtcompdate" .
						");";
					
					$res1 = $dbman->query($query);

					if ($res1)
					{
						$data = "Project added to super table successfully<br />";
						
						if ($type === "course")
						{
							
							$query = "insert into course_proj values (" .
								"$txtprojno," .
								"$txtdept," .
								"$txtinvst" .
								");";
							
							$res2 = $dbman->query($query);
							
							if ($res2)
							{
								$data = "Course Project added successfully<br />";
								
								if (count($sem_arr) === 0)
								{
									$result = "success";
									$data = "Project added successfully";
								}
								else
								{
									$res3 = true;
									foreach ($sem_arr as $sem)
									{
										$query = "insert into course_proj_sem values (" .
											"$txtprojno, $sem" .
											");";

										$res3 = $res3 and $dbman->query($query);
									}
									if ($res3)
									{
										$result = "success";
										$data = "Project added successfully";
									}
									else
									{
										$data = $data . "Failed to add semester";
									}
								}
							}
							else
							{
								$data = $data . "Failed to add course project";
							}
						}
						else
						{
							$query = "insert into common_proj values (" . 
								"$txtprojno," .
								"$txtamt," .
								"$txtmjadv" .
								");";
							
							$res2 = $dbman->query($query);
							
							if ($res2)
							{
								$result = "success";
								$data = "Project added successfully";
							}
							else
							{
								$data = $data . "Failed to add Common Project";
							}
						}
					}
					else
					{
						$result = "error";
						$data = "Failed to add super Project";
					}
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