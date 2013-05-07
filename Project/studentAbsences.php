<?php 
	include_once("classes/User.class.php");
 	session_start();
	
	$user = new User();
	if(isset($_GET['id']))
	{
		$userId = $_GET['id'];
		$user = new User();
		try
		{
	
			$user->Id = $userId;
			$userInfo = $user->getUserInformation();
			$user->Firstname = $userInfo['firstname'];
			$user->Lastname = $userInfo['lastname'];
			$user->Type = 'student';
			$absences = $user->getAbsences(/*'student'*/);
			$user->Absences = $absences;
			
			$absencesCount = count($absences);
			
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	// was voor fysieke knop beneden
/*	if(isset($_POST['btndelete']))
	{
		$deleteId = $_POST['deleteId'];
		$user = new User();
		$ab = new Absence();
		try
		{
			$ab->Id = $deleteId;
			$user->Id = $_GET['id'];
			$user->CurrentAbsence = $ab;
			$userInfo = $user->getUserInformation();
			$user->Firstname = $userInfo['firstname'];
			$user->Lastname = $userInfo['lastname'];
			$result = $user->deleteAbsence();
			if($result)
			{
				$feedback = "Afwezigheid goed verwijderd!";
			}
			
			$absences = $user->getAbsences('student');
			$user->Absences = $absences;
			
			$absencesCount = count($absences);
			
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
		//echo $deleteId;
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
				 <?php include_once("include_nav_options_student.php");?>
                   	 <section id="aroundResults">
                         <?php  if(isset($_GET['id']))
								 {
									 echo '<input style="display:none" id="hiddenId" value="' . $_GET['id'] . '"/>';
								 }
						 ?>
                         <div id="feedback">
                                    <?php 
                                            if(isset($feedback))
                                            {
                                                echo "<input style='display:none' id='feedbackResult' value='" .$feedback ."' />";
                                            }
                                            
                                            if(isset($error))
                                            { 
                                                echo "<input style='display:none' id='feedbackResult' value='" .$error ."' />";  
                                            }
                                            
                                    ?>  
                               </div><!-- /div voor error en feedback-->
        	<?php
				if(isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != "NaN")
				{ ?>
                
                             <?php if(isset($absencesCount) && isset($absences) && $absencesCount > 0)
                                { 
                                    echo '<div id="accordion">';
                                    echo "<h3>Afwezigheden van " . $user->Firstname . " " . $user->Lastname . "</h3>";
                                    echo '<table id="studentabsenceTable">';
                                    echo '<thead>
                                            <tr>
												<th>Id</th>
                                                <th>Vanaf</th>
                                                <th>Tot</th>
												<th>Reden</th>
												<th>Attest</th>
												<th>Actie</th>';
                                    echo    '</tr>
                                        </thead>';
                                    echo '<tbody>';
									?>
									<?php if(isset($absencesCount) )
									{
										$index = 1;
										foreach($absences as $a)
										{ 
										$user->CurrentAbsence = $a;
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<td class="absenceId">' . $a->Id . '</td>';
										  	list($y,$m,$d) = explode("-",$a->From);
                                            $from = $d . '/' . $m . '/' . $y;
										  echo "<td class='from'>" . $from . "</td>";
										  	list($y,$m,$d) = explode("-",$a->To);
                                            $to = $d . '/' . $m . '/' . $y;
										  echo "<td class='to'>" .  $to . "</td>";
										  echo "<td class='reason'>" .  $a->Reason . "</td>";
										  ?>
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
                                                    echo "Geen attest gevonden!";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                        	<ul class="inline" style="margin-top:5%; margin-bottom:5%">
                                            	<li class="edit">
                                                	<i class="icon-pencil icon-white"></i>
                                           			<img class="loadingImageEdit" src="img/loading.gif" />
                                                </li>
                                                <li class="delete">
                                                	<i class="icon-trash icon-white"></i>
                                            		<img class="loadingImageDelete" src="img/loading.gif" />
                                                </li>
                                            </ul>
                                        </td>
									<?php echo "</tr>";
										  $index++;
										}
							
                                    }
                                    echo '<tr>';
                                    echo '</tbody>';
                                    echo '</table>';
                                    echo "</div>";
                                }
								else
								{
									echo "</strong>Geen afwezigheden gevonden!</strong>";
								}
                                ?>
                                
                	   </br>
                              
                              <!-- was form voor 2 fysieke knoppen om dingen te verwijderen en te bewerken, is nu met knop voor elke 			
                              	afwezigheid-->  
                  <!--     <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $user->Id; ?>"  method="post" 
                        	id="deleteStudentAbsenceForm">
                            <button id="btnSaveChanges" type="submit" style="width:auto" class="btn btn-warning" >
                               	Bewerkingen opslaan</button>-->
                        	<input style="display:none" type="text" id="deleteRow" name="deleteId" />
                            <input style="display:none" type="text" id="typeUser" name="typeUser" value="student" />
                         <!--   <button name="btndelete" type="submit" style="width:auto" class="btn btn-danger">
                               	Verwijderen</button>
						</form>-->
                               <!-- style="display:none"  -->
                               
                                <div style="display:none" id="editTr">
                                    <form id="editAbsence" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <p>
                                        <fieldset>
                                            <legend>Bewerk afwezigheid: </legend>
                                           		<label for="editfrom">Id: </label>
                                                <input readonly type="text" name="editid" id="editid" /> 
												<label for="editfrom">Vanaf: </label>
                                                <input type="text" name="editfrom" id="editfrom" /> 
                                                <label for="editto">Tot: </label>
                                                <input type="text" name="editto" id="editto" />
                                                <label for="editreason">Reden: </label>
                                                <input type="text" name="editreason" id="editreason" />
                                            <input style="float:left; margin-left:40%;" class="loginButton customButton" type="submit" 
                                            	value="Annuleren" id="btnCancelEdit" name="btnCancelEdit"/>
                                            <input style="margin-right:8%; float:right;" class="loginButton customButton" type="submit" 
                                            	value="Opslaan" id="btnSaveEdit" name="btnSaveEdit"/></br>
                                                <img class="loadingImageSave" src="img/loading.gif" />
                                        </fieldset>
                                    </p>
                                    </form>
                                </div>
          <?php	}
				else
				{
					$error = "Kon geen afwezigheden laten zien! Kies een andere student uit de lijst.";
				}
				
			?>
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
            <script type="text/javascript">
			$(document).ready(function(e) {
				
				$("#homelink").removeClass("active");
				$("#homelink i").removeClass("icon-white");
				
				
				var links = $('#linkList li').map(function(){
      					return this.id;
   				}).get();
				
				for(var i=0;i< links.length;i++)
				{
					if(links[i] != "")
					{
						$("#"+links[i]).removeClass("active");
					}
				}
				$("#overviewAbsenceslink").addClass("active");
				$( "#editfrom" ).datepicker();
				$( "#editto" ).datepicker();
			});	
		</script>
    </body>
</html>