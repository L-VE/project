<?php
	session_start();
	include_once("classes/User.class.php");
	
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
			$user->Type = 'teacher';
			$absences = $user->getAbsences(/*'teacher'*/);
			$user->Absences = $absences;
			
			$absencesCount = count($absences);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	
	
/*	if(isset($_POST['btndelete']))
	{
		$deleteId = $_POST['deleteId'];
		$user = new User();
		$ab = new Absence();
		try
		{
			$user->CurrentAbsence = $ab;
			$ab->Id = $deleteId;
			$user->Id = $_GET['id'];
			$userInfo = $user->getUserInformation();
			$user->Firstname = $userInfo['firstname'];
			$user->Lastname = $userInfo['lastname'];
			$result = $user->deleteAbsence();
			if($result)
			{
				$feedback = "Afwezigheid goed verwijderd!";
			}
			
			$absences = $user->getAbsences('teacher');
			$user->Absences = $absences;
			
			$absencesCount = count($absences);
			
			
			
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
		//echo $deleteId;
	}*/
	
	
	
/*	function getArrayAbsences($p_aArray)
	{
		$collection = array();
		for($i=0; $i < count($p_aArray); $i++)
		{
			echo $p_aArray["id"] ;
			$ab = new Absence();
			$ab->Id = $p_aArray[$i]["id"];
			$ab->User_id =  $p_aArray[$i]["user_id"];
			$ab->From =  $p_aArray[$i]["from"];
			$ab->To =  $p_aArray[$i]["to"];
			
			array_push($collection,$ab);
		}
		
		*/
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
    <section id="mainContainer">
                	<?php include_once("include_nav_options_teacher.php");?>
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
                                <?php if(isset($absencesCount) && isset($absences))
                                { 
                                    echo "<h3>Afwezigheden van " . $user->Firstname . " " . $user->Lastname . "</h3>";
									echo ' <div id="results" >';
									echo '<div id="aroundTable" >';
                                    echo '<table id="absenceTable">';
                                    echo '<thead>
                                            <tr>
												<th>Id</th>
                                                <th>Vanaf</th>
                                                <th>Tot</th>
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
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<tr class="cRow">';
										  echo '<td class="absenceId">' . $a->Id . '</td>';
										  	list($y,$m,$d) = explode("-",$a->From);
                                            $from = $d . '/' . $m . '/' . $y;
										  echo "<td class='from'>" . $from . "</td>";
										  	list($y,$m,$d) = explode("-",$a->To);
                                            $to = $d . '/' . $m . '/' . $y;
										  echo "<td class='to'>" .  $to . "</td>";
										  echo '
										  	<td>
												<ul class="inline" style="margin-top:5%; margin-bottom:5%">
													<li class="editA">
														<i class="icon-pencil icon-white"></i>
														<img class="loadingImageEdit" src="img/loading.gif" />
													</li>
													<li class="deleteA">
														<i class="icon-trash icon-white"></i>
														<img class="loadingImageDelete" src="img/loading.gif" />
													</li>
												</ul>
                                       		</td>
										  ';
										  echo "</tr>";
										  $index++;
										}
							
                                    }
                                    echo '<tr>';
                                    echo '</tbody>';
                                    echo '</table>';
									echo ' </div>';//einde div aroundtable
                                }
                                ?>
                                    </br>
                                
                                
                            <!--     <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $user->Id; ?>"  method="post" 
                               		id="deleteTeacherAbsenceForm">
                                    <button id="btnSaveChanges" type="submit" style="width:auto" class="btn btn-primary" >
                                    	Bewerkingen opslaan</button>-->
                               		 <input style="display:none" type="text" id="deleteRow" name="deleteId" />
                                     <input style="display:none" type="text" id="typeUser" name="typeUser" value="teacher" />
                                	<!-- <button name="btndelete" type="submit" style="width:auto" class="btn btn-primary">
                                     	Verwijderen</button>
								</form> -->
                               <!-- style="display:none"  -->
                               
                                 <div style="display:none" id="editTr"  >
                                    <form id="editAbsence" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <p>
                                        <fieldset>
                                            <legend>Bewerk afwezigheid: </legend>
                                           		<label for="editfrom">Id: </label>
                                                <input readonly type="text" name="editid" id="editid" /> 
												<label for="editfrom">Vanaf: </label>
                                                <input type="text" name="editfrom" id="editfrom" /> 
                                                <label for="editto">Tot: </label>
                                                <input type="text" name="editto" id="editto" /> </br>
                                            <input  class="loginButton customButton"  type="submit" 
                                            	value="Annuleren" id="btnCancelEdit" name="btnCancelEdit"/>
                                            <input class="loginButton customButton" type="submit" 
                                            	value="Opslaan" id="btnSaveEdit" name="btnSaveEdit"/></br>
                                                <img class="loadingImageSave" src="img/loading.gif" />
                                        </fieldset>
                                    </p>
                                    </form>
                                </div>
                    <?php	    echo '</div>';// einde div results
						}
                        else
                        {
                            $error = "Kon geen afwezigheden laten zien!.";
                        }
                        
                        if(isset($error))
                        {
                           echo "<strong>" . $error. "</strong>";
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