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
				include_once("pages/include_coursesInfo.php");
				//var_dump($classes);
				//var_dump($groups);
				$user->Username = $_SESSION['name'];
			//	$user->Id = $user->getUserId();
				
		}
		 catch(Exception $e)
		 {
			 $error = $e->getMessage();
		 }
	 }
	 
	 if(isset($_POST['btnAddTeacherCourse']))
	 {
		 $user = new User();
		 $user->Type = $_SESSION['userType'];
		 $user->Id = $_GET['id'];
		 $course = new Course();
		 try
		 {
			 $course->ClassId = $_POST['className'];
			 $course->Semester = $_POST['semester'];
			 $course->Group = $_POST['group'];
			
			 $user->CurrentCourse = $course;
			 $result = $user->addCourse();
			 if($result)
			 {
				 $feedback = "Cursus toegevoegd";
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
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
    <?php include_once("pages/include_styles.php"); ?>
    <body>
     <section id="mainContainer">
    	<?php 
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
        
               	<?php
							if(isset($_GET['type']))
							{
								switch($_GET['type'])
								{
									case 'teacher' : include_once("pages/include_nav_options_teacher.php");;
										break;
									case 'student': include_once("pages/include_nav_options_student.php"); ;
										break;
								}
							}
							else
							{
								$error = "ee";
							}
					?>
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
                           

                           <h3>Voeg hier cursussen toe</h3>
                           
                           <div id="results" class="addAbsenceResult" >
                        	<form id="addCourseTeacherForm" action="<?php echo $_SERVER['PHP_SELF'] . 
								"?id=" . $_GET['id'] . '&type=teacher'; ?>" 
                            		method="post" >
                                	<fieldset >
  										<legend>Details cursus: </legend>
  										<label for="className" >Vak: </label>
                                        <select id="className" name="className">
                                        <?php
											foreach($classes as $c)
											{
												echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
											}
										?>
                                        </select>
                                        </br>
                                        <label for="dateTo">Semester: </label>
                                        <input type="radio" name="semester" value="1" checked><strong>1ste semester</strong></br>
										<input type="radio" name="semester" value="2"> <strong>2de semester</strong>
                                        </br>
                                        </br>
                                        <label for="dateTo">Klasgroep: </label>
                                        <select id="group" name="group">
                                        <?php
											foreach($groups as $g)
											{
												echo '<option value="' . $g['name'] . '">' .$g['name'] . '</option>';
											}
										?>
                                        </select>
                                        </br>
  									</fieldset>
                                    <input class="loginButton customButton" type="submit" 
                                        	value="Voeg cursus toe" id="btnAddTeacherCourse"
                                        	 name="btnAddTeacherCourse"/>
                            </form>
                        
                        </div> <!-- end results-->
 	</section><!-- end aroundResults -->
 </section><!-- end maincontainer -->
     <section class="Decorative" id="decorativeBottom"></section>
        <?php } 
		else
		{
			include_once("pages/include_notLoggedIn_error.php");
		}
		?>
        
        <?php include_once("pages/include_scripts.php"); ?>
    
        
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
				$("#addCourselink").addClass("active");

			});	
		</script>
    </body>
</html>