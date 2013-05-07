

<!doctype html>
<html>
    <head>
            <?php include_once("include_styles.php"); ?>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
 	    <body> <!-- class="hero-unit" -->
        <?php  session_start();
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <?php include_once("include_nav_options_admin.php"); ?>
                           
                    <!--Body content-->
                        <div id="actions">
                                <ul id="adminList">
                                    <li>
                                        <a id="addTeacher" href="addTeacher.php" class="actionItem">
                                        <img src="img/icon_teacher_add_300px.png" >
                                          <span class="buttonText">Docent toevoegen</span>
                                        <!--    Docent toevoegen-->
                                        </a>
                                    </li>
                                    <li>
                                        <a id="deleteTeacher" href="deleteTeacher.php" class="actionItem">
                                        <img src="img/icon-teacher_delete_300px.png" >
                                       		<span class="buttonText">Docent verwijderen</span>
                                        <!--   Docent verwijderen-->
                                        </a>
                                    </li>
                                    <li>
                                        <a id="addStudent"  href="addStudent.php"  class="actionItem">
                                        <img src="img/icon-student_add_300px.png" >
                                          <span class="buttonText">Studenten toevoegen</span>
                                        <!-- Studenten toevoegen-->
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