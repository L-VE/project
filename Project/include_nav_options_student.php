<?php
	 include_once("classes/User.class.php");
	 $student = new User();
	 $student->Type = $_SESSION['userType'];
	 
	 try
	 {
		 	$student->Username = $_SESSION['name'];
			$student->Id = $student->getUserId();
	}
	 catch(Exception $e)
	 {
		 $error = $e->getMessage();
	 }
?>


<div id="adminNav" class="navbar navbar-fixed-top ">
    <div class="navbar-inner">
       <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
          </a>

             <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
				   <li id="homelink" class="active">
                   		<a  href="homescreen_student.php">
                        <i class="homeStyle customLinkStyle"></i> Startpagina</a>
                   </li>
                   <li id="addAbsenceslink">
                   		<a href="createAbsence.php"><i class="icon-plus icon-white">
            			</i> Afwezigheid toevoegen</a>
            	  </li>
 				  <li id="overviewAbsenceslink">
                  		<a href="<?php echo 'studentAbsences.php?id=' . $student->Id ;?>">
                        <i class="icon-th-list icon-white">
                        </i> Mijn afwezigheden</a>
           		  </li>
                  <li id="addCourselink"><a href="<?php echo 'addCourse.php?id=' . $student->Id . '&type=student' ;?>">
                    <i class="icon-th-list icon-white">
                    </i> Cursus toevoegen</a>
                  </li>
                  <li id="viewCourselink"><a  href="<?php echo 'viewCourses.php?id=' . $student->Id . '&type=student' ;?>">
                    <i class="icon-th-list icon-white">
                    </i> Mijn cursussen</a>
                   </li>
                   <li id="checkTeachersLink"><a href="<?php echo 'checkTeachers.php?id=' . $student->Id ;?>">
                   	<i class="icon-th-list icon-white">
            			</i> Afwezige docenten</a>
           			</li>
                   <li id="logoutlink" class="logoutlink" ><a href="logout.php"><i class="logoutStyle customLinkStyle">
                   </i> Uitloggen</a>
                   </li>
               </ul>
             </div><!-- /.nav-collapse -->
        </div>
     </div><!-- /navbar-inner -->
</div><!-- /navbar -->

