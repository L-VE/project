<?php

	include_once("classes/User.class.php");
	session_start();
	$student = new User();
	
	if(isset($_GET['absence_id']))
	{
		$absence_id = $_GET['absence_id'];
		$student = new User();
		$absence = new Absence();
		$absence->Id = $absence_id;
		
		try
		{
			   /* $username = "root";
				$password = "root";
				$host = "localhost:3307";
				$database = "project_php";
				
				mysql_connect($host, $username, $password) or die("Can not connect to database: ".mysql_error());
				
				mysql_select_db($database) or die("Can not select the database: ".mysql_error());*/
				
				$student->CurrentAbsence = $absence;
				
				$id = $_GET['absence_id'];//intval($_GET['id']);
				if(is_string($id))
				{ 
					$id = intval($id);
				}
				
				if(!isset($id) || empty($id) || !is_int($id)){
					 //die("Please select your image!");
					 $error = "Kon geen attesten ophalen!";
				}
				else
				{
				
					//$query = mysql_query("SELECT * FROM absence WHERE id='".$id."'");
					//$row = mysql_fetch_array($query);
					//$imageId = $row['id'];
					//$content = $row['note'];
					
				
					//$AbsenceRow = $student->getNote();//$student->getNote($id);
				//	$absence->Note = $AbsenceRow['note'];
					$absence->Note = $student->getNote();
					
					header('Content-type: image/jpg');
						// echo $content;
						echo $absence->Note;
				}
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
    <?php include_once("include_styles.php"); ?>
    <body>
       <?php  
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                 
                 <?php
				if(isset($error))
				{
				   echo "<div id='error' class='alert alert-error' style='margin-top:20%;'>";
				   echo "<strong>" . $error. "</strong>";
				   echo "</div>";     
				}
			?>
            <a class="btn btn-primary" href="viewAbsences.php">Terug naar het afwezighedenoverzicht</a>
			
        <?php } 
		else
		{
			include_once("include_notLoggedIn_error.php");
		}
		?>
        <?php include_once("include_scripts.php"); ?>
    </body>
</html>