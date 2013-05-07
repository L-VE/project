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
				$user->Id = $user->getUserId();
				$courses = $user->getCourses();
				$courseCount = count($courses);
				
		}
		 catch(Exception $e)
		 {
			 $error = $e->getMessage();
			 $sansJSError = $error;
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
                	<?php
							if(isset($_GET['type']))
							{
								switch($_GET['type'])
								{
									case 'teacher' : include_once("include_nav_options_teacher.php");;
										break;
									case 'student': include_once("include_nav_options_student.php"); ;
										break;
								}
							}
					?>
           <section id="aroundResults">
                    <?php 
							if(isset($_GET['id']))
							{
								echo "<input style='display:none' id='hiddenCourse' value='" .$_GET['id'] ."' />";
							}
					 ?>
                           <div id="feedback">
                                <?php 
										if(isset($sansJSError))
										{
											echo "<div style='color:#FFF;' id='error' class='alert-error'>";
											echo "<strong>" . $sansJSError. "</strong>";
											echo "</div>";     
										}
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
                           

                           <h3>Cursussen lijst:</h3>
                           <p></p>
                          <?php if(count($courses) > 0) {?>
                           <div id="results" >
                        	<div id="aroundTable" >
							<table id="courseTable"  >
                            	<thead>
                                	<tr>
                                    	<th>Id</th>
                                        <th>Vak</th>
                                        <th>Semester</th>
                                        <th>Klas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php if(isset($courses) )
									{
										$index = 1;
										foreach($courses as $c)
										{ 
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<td class="courseId">' . $c->Id . '</td>';
										  echo '<td class="class1" data-vak="' . $c->ClassId .  '">' . $c->Name . '</td>';
										  echo '<td class="semester">' . $c->Semester . '</td>';
										  echo '<td class="group">' . $c->Group . '</td>';
										  echo '
										  	<td>
												<ul class="inline" style="margin-top:5%; margin-bottom:5%">
													<li class="editB">
														<i class="icon-pencil icon-white"></i>
														<img class="loadingImageEdit" src="img/loading.gif" />
													</li>
													<li class="deleteB">
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
									
									?>
                                </tbody>
                            </table>
                            
                            </div>
                            <input style="display:none" type="text" id="deleteRow" name="deleteId" />
                            
                             <div style="display:none" id="editTr">
                                    <form id="editCourse" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <p>
                                        <fieldset>
                                            <legend>Bewerk cursus: </legend>
                                           		<label for="editid">Id: </label>
                                                <input readonly type="text" name="editid" id="editid" /> 
												<label for="editclass">Vak: </label>
                                        		<select id="editclass" name="editclass">
                                                <?php
													foreach($classes as $c)
													{
														echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
													}
												?>
                                                
                                       			</select>
                                               <!-- <input type="text" name="editclass" id="editclass" /> --->
                                                <label for="editsemester">Semester: </label>
                                                <input type="radio" name="editsemester" id="editsemester1" value="1" checked> 
                                                <strong>1ste semester</strong></br>
												<input type="radio" name="editsemester" id="editsemester2" value="2">
                                                <strong> 2de semester</strong></br>
                                                <label for="editgroup">Klasgroep: </label>
                                                <select name="editgroup" id="editgroup" >
												<?php
                                                    foreach($groups as $g)
                                                    {
                                                        echo '<option value="' . $g['name'] . '">' .$g['name'] . '</option>';
                                                    }
                                                ?>
                                       			</select> </br>
                                               <!-- <input type="text" name="editgroup" id="editgroup" />-->
                                            <input  class="loginButton customButton" 
                                            	type="submit" 
                                            	value="Annuleren" id="btnCancelEditCourse" name="btnCancelEditCourse"/>
                                            <input class="loginButton customButton"
                                            	 type="submit" 
                                            	value="Opslaan" id="btnSaveEditCourse" name="btnSaveEditCourse"/></br>
                                                <img class="loadingImageSave" src="img/loading.gif" />
                                        </fieldset>
                                    </p>
                                    </form>
                                </div>
                        </div> <!-- end results-->
                        <?php 
						}
						else
						{
							echo "<strong>Geen cursussen gevonden!</strong>";
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
				$("#viewCourselink").addClass("active");

			});	
		</script>
    </body>
</html>