<?php 
	include_once("classes/User.class.php");
	
	if(isset($_POST['btnLogin']) /*&& !empty($_POST['username'])*/)
	{
		try
		{
			$user = new User();
			$user->Username = $_POST['username'];
			$user->Password = $_POST['password'];
			$result = $user->canLogin();
				if($result)
				{
					session_start();
					$userType = $user->getUserType();
					$user->Type = $userType[0];
					$_SESSION['name'] =$user->Username;
					$_SESSION['loggedin'] = true;
					$_SESSION['userType'] = $userType[0];
					 switch($user->Type)
                    {
                        case "admin" : header("Location: homescreen_admin.php");
                            break;
                        case "student" : header("Location: homescreen_student.php") ;
                            break;
                        case "teacher" : header("Location: homescreen_teacher.php");
                            break;
                    }	
				}
				
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$sansJSError = $error;
		}		
	}
	
?>

<!doctype html>
<html lang="en">

<head>
	
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap-responsive.min.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap-fileupload.min.css">
    <link rel="stylesheet" type="text/css" href="styles/customStyle.css">
    <link rel="stylesheet" type="text/css" href="styles/jackedup.css">
    <link rel="stylesheet"  type="text/css" href="styles/jquery-ui-1.10.2.custom.css" />

    
   
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
		<title>Untitled Document</title>
	</head>

	<body id="loginBody">
		<section id="mainContainer">
		<section class="Decorative" id="decorativeTop"></section>
		
		<section id="loginContainer">
			<h1>App-Sence</h1>   
  
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
                               
	 
			
			<div id="login"> 
				   <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
							<fieldset>
								<label for="username"></label>
								<input id="usernameInput" type="text" name="username" placeholder="Gebruikersnaam"/><!--  required-->
								<label for="password"></label>
								<input type="password" name="password" placeholder="Wachtwoord" /><!--  required-->
								<input type="submit" name="btnLogin" value="Log in" class="loginButton" id="btnLogin" />
							 </fieldset>    
				   </form>
			</div>
				<img id="TMLogo" src="img/ThomasMoreLogo.png"/>
		</section> <!--End loginContainer-->
	</section> <!--End mainContainer-->
    
	<section class="Decorative" id="decorativeBottom"></section>
    
	 <?php include_once("include_scripts.php"); ?> 
         <script type="text/javascript">
			$(document).ready(function(e) {
				$("#usernameInput").focus();
			});
    
    </script>
	
	</body>
</html>