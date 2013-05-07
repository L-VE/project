<?php
	include_once("classes/User.class.php");
 	session_start();
	
	$user = new User();
	if(isset($_GET['user_id']))
	{
		$userId = $_GET['user_id'];
		$user = new User();
		try
		{
	
			$user->Id = $userId;
			$userInfo = $user->getUserInformation();
			$user->Firstname = $userInfo['firstname'];
			$user->Lastname = $userInfo['lastname'];
			$user->Type = 'student';
			$absences = $user->getAbsences();// hier nog onderscheid tss docent en student
			$user->Absences = $absences;
			
			$absencesCount = count($absences);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
		
			// Temporary file name stored on the server
			//$tmpName = $_FILES['image']['tmp_name'];
			
			// Read the file
		/*	$fp = fopen("palmmeme.jpg", 'r');
			$data = fread($fp, filesize("palmmeme.jpg"));
			$data = addslashes($data);
			fclose($fp);*/
			
			
			// Create the query and insert
			// into our database.
		//	$query = "insert into note ";
		//	$query .= "(image) VALUES ('$data')";
			//$results = mysql_query($query, $link);
			//$result = $student->insertNote($data);

			// Print results
			/*if($result)
				print "Thank you, your file has been uploaded.";
			*/	
				
				/*$username = "root";
				$password = "root";
				$host = "localhost:3307";
				$database = "project_php";
				
				mysql_connect($host, $username, $password) or die("Can not connect to database: ".mysql_error());
				
				mysql_select_db($database) or die("Can not select the database: ".mysql_error());*/
				
			/*	$id = $_GET['id'];//intval($_GET['id']);
				if(is_string($id))
				{ 
					$id = intval($id);
				}
				
				if(!isset($id) || empty($id) || !is_int($id)){
					 die("Please select your image!");
				}
				else
				{
				
					//$query = mysql_query("SELECT * FROM note WHERE id='".$id."'");
					//$row = mysql_fetch_array($query);
					//$imageId = $row['id'];
					//$content = $row['image'];
					$notes = $student->getNote($id);
					
					header('Content-type: image/jpg');
						// echo $content;
						echo $notes['image'];
				}*/

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
    <section id="mainContainer">
    	<?php  
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
        	  <section id="aroundResults">
        	<?php
				if(isset($_GET['user_id']) && !empty($_GET['user_id']) && $_GET['user_id'] != "NaN")
				{ ?>
                    	<?php if(isset($absencesCount) && isset($absences))
						{ 
							echo '<div id="accordion">';
							echo "<h3>Afwezigheden van " . $user->Firstname . " " . $user->Lastname . "</h3>";
							$index = 1;
						//	echo '<div id="aroundTable" >';
							echo '<table id="absenceTable">';
							echo '<thead>
                                	<tr>
                                    	<th>Vanaf</th>
                                        <th>Tot</th>
                                        <th>Reden</th>
										<th>Attest</th>';
                            echo    '</tr>
                                </thead>';
							echo '<tbody>';
							foreach($absences as $a)
							{ 
								echo '<tr>';
								$user->CurrentAbsence = $a;
							?>
                                    <td>
                                    	<?php 
											list($y,$m,$d) = explode("-",$a->From);
											$from = $d . '/' . $m . '/' . $y;
											echo $from;
											//echo $a->From;
										 ?>
                                    </td>
                                    <td>
                                    	<?php 
										
											list($y,$m,$d) = explode("-",$a->To);
											$to = $d . '/' . $m . '/' . $y;
											echo $to;
											//echo $a->To; 
										?>
                                    </td>
                                    <td>
                                    	<?php echo $a->Reason; ?>
                                    </td>
									<td>
                                    <?php
                                    	if($user->hasNote())
											{?>
                                          		<a href="<?php echo "overviewNote.php?absence_id=" . $a->Id; ?>">
                                               		<i class="addAbsencesLinkStyle customLinkStyle"></i> Bekijk attest
                                         		 </a>
                                    <?php	}
											else
											{
												echo "<strong>Geen attest gevonden!</strong>";
											}
										?>
                                    </td>
						<?php 
							$index++;
							}
							echo '<tr>';
							echo '</tbody>';
							echo '</table>';
							echo "</div>";
						}
						?>
							</br>
			<?php	}
				else
				{
					$error = "Kon geen afwezigheden laten zien! Kies een andere student uit de lijst.";
				}
				
				if(isset($error))
				{
				   echo "<strong>" . $error. "</strong>";
				}
			?>
            <!-- jier nog onderscheidt tss docent en student-->
            
            <a style="margin-bottom:10px;" class="loginButton customButton" href="overviewStudents.php">Terug naar studentenoverzicht</a>
            
        </section><!-- end aroundResults -->
      </section><!-- end maincontainer -->
        	<section class="Decorative" id="decorativeBottom"></section>
        <?php } 
		else
		{
			include_once("include_notLoggedIn_error.php");
		}
		?>
        
        
                 <?php include_once("include_scripts.php"); ?>
        
      
    </body>
</html>