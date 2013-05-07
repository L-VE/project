<?php
	include_once("classes/User.class.php");
	
	if(isset($_POST['btnCreateTeacher']))
	{
		try
		{
			$docent = new User();
			$docent->Type = "teacher";
			$docent->Firstname = $_POST['fName'];
			$docent->Lastname = $_POST['lName'];
			$docent->Username = $_POST['username'];
			$docent->Password = $_POST['password'];
			
			$result = $docent->createTeacherAccount();
			if($result)
			{
				$feedback = "Docent is aangemaakt.";
				$sansJSError = $feedback;
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
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
    
    <?php include_once("include_styles.php"); ?>
    <body>
    <section id="mainContainer">
    	<?php  session_start();
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                	<?php include_once("include_nav_options_admin.php");?>
         <section id="aroundResults">
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
                               
                            <h3>Voeg docent toe</h3>
                            <div id="results" class="addTeacherResult" >
                                <form id="addTeacherForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <fieldset>
                                            <legend>Docenten informatie </legend>
                                          <!--  <label for="username">Gebruikersnaam: </label> -->
                                            <div id="signupZone">
                                                <input id="username" name="username" class="inputField" 
                                                	type="text"  placeholder="Gebruikersnaam" />
                                                <div class="usernameFeedback">
                                                    <img id="loadingImage" src="img/loading.gif" />
                                                    <span style="line-height:32px"></span>
                                                </div>
                                            </div>
                                          <!--   <label for="password">Wachtwoord: </label> -->
                                            <input id="password" name="password" class="inputField"  
                                            	placeholder="Wachtwoord" type="password"  />
                                            <br />
                                          <!--   <label for="fName">Voornaam: </label> -->
                                            <input id="fName" name="fName" class="inputField" type="text" 
                                            	 placeholder="Voornaam" />
                                            </br>
                                           <!--  <label for="lName">Achternaam: </label> -->
                                            <input id="lName" name="lName" class="inputField" 
                                            	 placeholder="Achternaam" type="text"  />
                                            
                                        </fieldset>
                                        <input class="loginButton" type="submit" value="Maak account aan" id="btnCreateTeacher"
                                                 name="btnCreateTeacher"/>
                                </form>
                            
                            </div> <!-- end results-->
	</section><!-- end aroundResults -->

        <?php } 
		else
		{
			include_once("include_notLoggedIn_error.php");
		}
		?>
        </section><!-- end maincontainer -->
        	<section class="Decorative" id="decorativeBottom"></section>
    <?php include_once("include_scripts.php"); ?>
    
        
        <script type="text/javascript">
			$(document).ready(function(e) {
				
				$("#homelink").removeClass("active");
				//$("#homelink i").removeClass("icon-white");
				//$(".addTeacherStyle").css("background-image","url(img/addteacher_14x14_white.png)");
				
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
				$("#addTeacherlink").addClass("active");
			});	
		</script>
    </body>
</html>