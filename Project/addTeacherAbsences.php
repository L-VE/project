
<?php
 	session_start();
	include_once("classes/User.class.php");
	
	if(isset($_POST['btnCreateAbsence']) && isset($_SESSION['name']))
	{
		$teacher = new User();
		$absence = new Absence();
		try
		{
			$teacher->Username = $_SESSION['name'];
			$teacher->Type = $_SESSION['userType'];
			$teacher->Id = $teacher->getUserId();
			$teacher->CurrentAbsence = $absence;
			$absence->From = $_POST['dateFrom'];
			$absence->To = $_POST['dateTo'];
			$absence->User_id = $teacher->Id;
			$inserted = $teacher->addAbsence();
			if($inserted)
			{
				$feedback = "Afwezigheid is toegevoegd!";
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
		<title>Untitled Document</title>
    </head>
    <?php include_once("include_styles.php"); ?>
    <body>
    	<?php 
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
           <section id="mainContainer">
                	<?php include_once("include_nav_options_teacher.php");?>
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
                           
                           <h3>Voeg afwezigheid toe</h3>
                           
                           <div id="results" class="addAbsenceResult"  >
                        	<form id="addAbsenceTeacherForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                                	<fieldset >
  										<legend>Details afwezigheid </legend>
  										<!--<label for="dateFrom">Vanaf: </label>-->
                                        <input placeholder="Vanaf (mm/dd/yyyy)" class="inputField" name="dateFrom" 
                                        	type="text" id="datepickerFrom" />
                                       <!-- <label for="dateTo">Tot (en met): </label>-->
                                       </br>
                                        <input placeholder="Tot (en met) (mm/dd/yyyy)" class="inputField" name="dateTo" type="text" 
                                        	id="datepickerTo" />
  									</fieldset>
                                    <input class="loginButton customButton" type="submit" 
                                        	value="Voeg afwezigheid toe" id="btnCreateAbsence"
                                        	 name="btnCreateAbsence"/>
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
				$("#addAbsenceslink").addClass("active");
				
				$( "#datepickerFrom" ).datepicker();
				$( "#datepickerTo" ).datepicker();

			});	
		</script>
    </body>
</html>