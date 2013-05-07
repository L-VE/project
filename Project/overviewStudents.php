<?php
	include_once("classes/User.class.php");
 	session_start();
	
	if(isset($_SESSION['name']) || isset($_POST['btnShowAll']))
	{
		//echo $_SESSION['userType'];
		try
		{
			//$teachers = array();
			$student = new User();
			//$teacher->Username = $_SESSION['name'];
			$results = $student->getAllUsers('student');
			$students = getArrayStudents($results);
			
			$studentCount = count($students);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	
/*	if(isset($_GET['student_id']))
	{
		$studentId = $_GET['student_id'];
		$student = new User();
		$student->Id = $studentId;
		try
		{
			$absences = $student->getAbsences('student',$studentId);
			$absencesCount = count($absences);
			
			if($absencesCount <= 0)
			{
				throw new Exception("Student heeft (nog) geen afwezigheden!");
			}
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	*/

	
	//if(isset($_POST['btnSearch']) /*&& !empty($_POST['searchStudents'])*/)
	/*{
		if(empty($_POST['searchStudents']))
		{
			$error = "Vul eerst een keyword in!";
		}
		else
		{
			try
			{
				//$resultQuery = array();
				//$foundTeachers = array();
				$student = new User();
				$resultQuery = $student->searchUsers(htmlspecialchars($_POST['searchStudents']),'student');
				
				$students = getArrayStudents($resultQuery);
				
				$studentCount = count($students);
				
				if($studentCount <= 0)
				{
					$error =  "Geen studenten gevonden!";
				}
				else
				{
					$feedback = "Zoekopdracht volbracht!";
				}
				
			}
			catch(Exception $e)
			{
				$error = $e->getMessage();//nog zo aanpassen dat er paginatie wordt toegepast
			}
		}*/
		
		
		
		
	if(isset($_GET['keyword']) /*&& !empty($_POST['searchStudents'])*/)
	{
	/*	if(empty($_POST['keyword']))
		{
			$error = "Vul eerst een keyword in!";
		}
		else
		{*/
			try
			{
				//$resultQuery = array();
				//$foundTeachers = array();
				$student = new User();
				$resultQuery = $student->searchUsers(htmlspecialchars($_GET['keyword']),'student');
				
				$students = getArrayStudents($resultQuery);
				
				$studentCount = count($students);
				
				if($studentCount <= 0)
				{
					//$teachers = array();
						$student = new User();
						//$teacher->Username = $_SESSION['name'];
						$results = $student->getAllUsers('student');
						$students = getArrayStudents($results);
						
						$studentCount = count($students);
						$error =  "Geen studenten gevonden op basis van sleutelwoord!";
				}
				else
				{
					$feedback = "Zoekopdracht volbracht!";
				}
				
			}
			catch(Exception $e)
			{
				$error = $e->getMessage();//nog zo aanpassen dat er paginatie wordt toegepast
			}
		//}
	}
	
	function getArrayStudents($p_aArray)
	{
		$students = array();
		for($i=0; $i < count($p_aArray); $i++)
		{
			$student = new User();
			$student->Id = $p_aArray[$i]["id"];
			$student->Username = $p_aArray[$i]["username"];
			$student->Firstname = $p_aArray[$i]["firstname"];
			$student->Lastname = $p_aArray[$i]["lastname"];
			array_push($students,$student);
		}
		
		return $students;
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
         <section id="mainContainer">
                        <?php include_once("include_nav_options_teacher.php"); ?>
                           
         <section id="aroundResults">
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
                          
                          <span id="spanOverview"> 
                           <h3>Studenten</h3>
                  <?php if($studentCount > 0) {?>         
                           <form id="searchStudentForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get"> 
                                <input id="keyword" name="keyword" type="text"  class="input-medium">
 								<input id="btnSearch"  type="submit" class="loginButton customButton" value="Zoek"/>
                                <input id="btnShowAll" name="btnShowAll"  type="submit" class="loginButton customButton" 
                                	value="Toon alle studenten"/>
							</form>
                            
                            
                    <!--Body content-->
                        <div id="results">
							<div id="aroundTable" >
                            	<table id="studentTable" >
                            	<thead>
                                	<tr>
                                    	<th>Id</th>
                                        <th>Gebruikersnaam</th>
                                        <th>Voornaam</th>
                                        <th>Achternaam</th>
                                        <th>Afwezigheden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php if(isset($studentCount) )
									{
										$index = 1;
										foreach($students as $s)
										{ 
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<td class="studentId">' . $s->Id . '</td>';
										  echo "<td>" . $s->Username . "</td>";
										  echo "<td>" . $s->Firstname . "</td>";
										  echo "<td>" . $s->Lastname . "</td>";
										  echo '
										  	<td class="viewAbs">
												<span>
														<i class="icon-th-list icon-white"></i> 
															<a>Bekijken</a>
														<img class="loadingImageEdit" src="img/loading.gif" />
												</span>
                                      	  </td>
										  ';
										  echo "</tr>";
										  $index++;
										}
									}
									
									?>
                                </tbody>
                            </table>	
                            
                        <!--  <div style=" margin-top:5%; width:445px;">  
                           <form id="showAll" action="<?php echo $_SERVER['PHP_SELF'] ?>" 
                           	method="post" style="float:left" >
                               <input id="btnShowAll" name="btnShowAll"  type="submit" class="btn" value="Toon alle studenten"/>
					       </form>
                            
                           <form id="getAbsenceForm" style="float:right;">
                             --> <input style="visibility:hidden; display:none" type="text" id="deleteRow" name="student_id" />
  							 <!-- <input type="submit" style="width:auto" id="viewAbs" class="btn btn-primary" value="Bekijk afwezigheden"/>
						   </form>
                         </div>-->
                         </br>
                            
                            </div> <!-- end aroundTable-->                            

                       </div><!-- end results -->
                      <?php }
					  else
					  {
						  echo "Geen studenten gevonden!";
					  }
					 ?>
                       </span> <!--end spanOverview--> 
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
				$("#viewStudentslink").addClass("active");
			
					
			});	
			
			
		</script>
    </body>
</html>