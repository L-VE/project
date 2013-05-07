<?php

	session_start();
	
	/*if(isset($_GET['type']))
	{
		$userType = $_GET['type'];
	}*/
	
	if(isset($_SESSION['userType']))//checken of session loggedid geset is!!!
	{
		$userType = $_SESSION['userType'];
	}
?>

<!doctype html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap-responsive.min.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap-fileupload.min.css">
    <link rel="stylesheet" type="text/css" href="styles/customStyle.css">
    <script type="text/javascript" src="scripts/jquery-1.9.1.min.js" ></script>
    <script type="text/javascript" src="scripts/jquery-ui-1.10.2.custom.min.js"></script>
    <script type="text/javascript" src="scripts/bootstrap.min.js" ></script>
    <script type="text/javascript" src="scripts/bootstrap-fileupload.min.js" ></script>
    <script type="text/javascript" src="scripts/customScript.js" ></script>
    <script type="text/javascript" src="scripts/jquery.backgroundpos.min.js" ></script>
        <meta charset="utf-8">
        <title>Untitled Document</title>
    </head>
    
    <body> <!-- class="hero-unit" -->
    	<div id="adminView" class="container-fluid">
    		<div class="row-fluid">
            	<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true )
                {
                    switch($userType)
                    {
                        case "admin" : include_once("include_nav_options_admin.php");
									   include_once("include_home_admin.php");
                            break;
                        case "student" : include_once("include_home_student.php") ;
                            break;
                        case "teacher" : include_once("include_home_teacher.php") ;
                            break;
                    }
                    
                    //echo $_SESSION['name'];
                }
                /*else
                {
                    echo "fout";
                }*/ // nog foutmelding geven
            ?>
            </div>
		</div>
			

    </body>
</html>