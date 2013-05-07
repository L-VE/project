<?php
	 include_once("classes/User.class.php");
	 session_start();
	 $user = new User();
	 
	 if(isset($_SESSION['userType']) && isset($_GET['id']))
	 {
		 $user->Type = $_SESSION['userType'];
		 $user->Id = $_GET['id'];
		 try
		 {
				
				//var_dump($classes);
				//var_dump($groups);
				include_once("include_coursesInfo.php");
				$user->Username = $_SESSION['name'];
				$user->Id = $_GET['id'];//$student->getUserId();
				$absentTeachers = $user->getAbsentTeachers();
				$countAbsentTeachers = count($absentTeachers);
				
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
    <section id="mainContainer">
    	<?php 
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                	<?php include_once("include_nav_options_student.php");?>
          <section id="aroundResults">
                    <?php 
							if(isset($_GET['id']))
							{
								echo "<input style='display:none' id='hiddenCourse' value='" .$_GET['id'] ."' />";
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
                           

                           <h3>Afwezige docenten:</h3>
                           <p></p>
                           <?php if(isset($absentTeachers) && $countAbsentTeachers > 0)
									{?>
                           <div id="results"  >
                        	<div id="aroundTable" >
							<table id="teacherTable"  >
                            	<thead>
                                	<tr>
                                    	<th>Docent</th>
                                      <!--  <th>Vak</th>
                                        <th>Klas</th>-->
                                        <th>Afwezig</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
										$index = 0;
										foreach($absentTeachers as $a)
										{ 
											$absences = $a->Absences;
											//echo count($absences);
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  if(count($absences) > 0)
										  {
											  echo '<td>' . $a->Firstname . ' ' . $a->Lastname . '</td>';  
											  echo '<td>';
											  echo '<ul style="list-style-type:circle;">';
												foreach($absences as $ab)
												{
													if($ab->From == $ab->To)
													{
														echo '<li>' . $ab->From . '</li>';
													}
													else
													{
														echo '<li>Van ' . $ab->From . ' t.e.m ' . $ab->To . '</li>';
													}
												}
											 echo '</ul>';
										  }
										  echo '</td>';
										  echo "</tr>";
										  $index++;
										}
									?>
                                </tbody>
                            </table>
                            
                            </div>
                            
                        </div> <!-- end results-->
                        <?php }
								else
									{
										echo "<strong>Geen afwezige docenten gevonden!</strong>";
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
				$("#checkTeachersLink").addClass("active");

			});	
		</script>
    </body>
</html>