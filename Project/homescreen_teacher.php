<?php
	 include_once("classes/User.class.php");
	  session_start();
	  
	 if(isset($_SESSION['userType']) && isset($_SESSION['name']))
	 {
		 $teacher = new User();
		 $teacher->Type = $_SESSION['userType'];
	 
		 try
		 {
			 $teacher->Username = $_SESSION['name'];
				$teacher_Id = $teacher->getUserId();
				$teacher->Id = $teacher_Id;
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
 	    <body> <!-- class="hero-unit" -->
		<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
              
                        <?php include_once("include_nav_options_teacher.php"); ?>
                           
                  
                        <div id="actions">
                            <ul  id="teacherList">
                                <li>
                                    <a id="addTeacherAbsences" href="addTeacherAbsences.php" class="actionItem">
                                     <img src="img/add_Absence.png" >
                                    <span class="buttonText">Afwezigheid toevoegen</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="getTeacherAbsences" href="<?php echo 'overviewTeacherAbsences.php?id=' . $teacher->Id ;?>" 
                                    	class="actionItem">
                                        <img src="img/list_Absence.png" >
                                    <span class="buttonText">Mijn afwezigheden</span>
                                    </a>
                                </li>
                                </br>
                                <li>
                                	<a  id="viewStudents" href="overviewStudents.php"
                                    	 class="actionItem">
                                        <img src="img/student.png" >
                                    <span class="buttonText">Studenten opvragen</span>
                                    </a>
                                </li>
                                <li class="courseStyle">
                                	<a  id="getStudentAbsences" href="overviewStudentAbsences.php" class="actionItem">
                                    <img src="img/adsence_students.png" >
                                    <span class="buttonText">Afwezige studenten</span>
                                    </a>
                                </li>
                                <li class="courseStyle courseAddStyle">
                                	<a id="addCourse" href="<?php echo 'addCourse.php?id=' . $teacher->Id . '&type=teacher' ;?>" 
                                    	class="actionItem">
                                         <img src="img/add_course.png" >
                                    <span class="buttonText">Cursus toevoegen</span>
                                    </a>
                                </li>
                                <li class="courseStyle courseAddStyle">
                                	<a id="viewCourse" href="<?php echo 'viewCourses.php?id=' . $teacher->Id . '&type=teacher' ;?>" 
                                    	class="actionItem">
                                         <img src="img/courses.png" >
                                    <span class="buttonText">Mijn cursussen</span>
                                    </a>
                                </li>
                            </ul>
                         </div><!-- end actions -->
		
            <?php } 
		else
		{
			include_once("include_notLoggedIn_error.php");
		}
		?>
        <section class="Decorative" id="decorativeBottom"></section>
        <?php include_once("include_scripts.php"); ?>
    </body>
</html>