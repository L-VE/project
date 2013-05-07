<?php
	 include_once("classes/User.class.php");
	  session_start();
	  
	 if(isset($_SESSION['userType']) && isset($_SESSION['name']))
	 {
		 $student = new User();
		 $student->Type = $_SESSION['userType'];
	 
		 try
		 {
			 $student->Username = $_SESSION['name'];
				$student_id = $student->getUserId();
				$student->Id = $student_id;
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
            <?php include_once("include_styles.php"); ?>
        
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
		<title>Untitled Document</title>
    </head>
 	    <body> <!-- class="hero-unit" -->
		<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <?php include_once("include_nav_options_student.php"); ?>
                        
                                          
                        <div id="actions">
                            <ul  id="studentList">
                                <li>
                                    <a id="addStudentAbsences" href="createAbsence.php" class="actionItem">
                                     <img src="img/add_Absence.png" >
                                    <span class="buttonText">Afwezigheid toevoegen</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="getStudentAbsences" href="<?php echo 'studentAbsences.php?id=' . $student->Id ;?>" 
                                    	class="actionItem">
                                        <img src="img/list_Absence.png" >
                                    <span class="buttonText">Mijn afwezigheden</span>
                                    </a>
                                </li>
                                
                                <li style="margin-bottom:5px" >
                                	<a id="checkTeachers" href="<?php echo 'checkTeachers.php?id=' . $student->Id ;?>" 
                                    	 class="actionItem">
                                        <img src="img/absence_teachers.png" >
                                    <span class="buttonText">Afwezige docenten</span>
                                    </a>
                                </li>
                             
                                <li  class="courseStyle courseAddStyle">
                                	<a id="addCourse" href="<?php echo 'addCourse.php?id=' . $student->Id . '&type=student' ;?>" 
                                    	class="actionItem">
                                         <img src="img/add_course.png" >
                                    <span class="buttonText">Cursus toevoegen</span>
                                    </a>                                  
                                </li> 
                                <li class="courseStyle courseAddStyle">
                                	<a id="viewCourse" href="<?php echo 'viewCourses.php?id=' . $student->Id . '&type=student' ;?>"  
                                    	class="actionItem">
                                         <img src="img/courses.png" >
                                    <span class="buttonText">Mijn cursussen</span>
                                    </a>
                                </li>
                            </ul>
                         </div><!-- end actions -->
                 
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