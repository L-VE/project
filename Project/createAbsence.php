<?php
 	session_start();
	include_once("classes/User.class.php");
	
	if(isset($_POST['btnCreateAbsence']) && isset($_SESSION['name']))
	{
		if(!empty($_FILES['file']['name']))
		{
			$allowedExts = array("png","pdf","jpg","bmp");
			
			$fileName = $_FILES["file"]["name"];
			$fileType = $_FILES["file"]["size"] ;
			$fileSize = $_FILES["file"]["size"];
			$fileTmpName = $_FILES["file"]["tmp_name"];
			$fileError = $_FILES["file"]["error"];
			
			$extensionArray = explode(".", $fileName);
            $extension = end($extensionArray);
			
			if ((pathinfo($fileName, PATHINFO_EXTENSION) == "png" || pathinfo($fileName, PATHINFO_EXTENSION) == "pdf"
			   || pathinfo($fileName, PATHINFO_EXTENSION) == "jpg"|| pathinfo($fileName, PATHINFO_EXTENSION) == "bmp")
               && in_array($extension, $allowedExts))
            {
				
				if ($fileError > 0)
                {
                   //	echo "Return Code: " . $fileError . "<br>";
                  // $error = "Return Code: " . $fileError . "<br>";
				   $error = "Kon bestand niet lezen!";
				   $sansJSError = $error;
                }
                else
                {
					
					 if (file_exists("upload/" . $fileName))
                     {
                         //echo $fileName . " already exists. ";
                         //  $feedback = $fileName . " already exists. ";
                         move_uploaded_file($fileTmpName,"upload/" . $fileName);
                     }
                     else
                     {
                         move_uploaded_file($fileTmpName,"upload/" . $fileName);
                         //echo "Stored in: " . "upload/" . $fileName;
                         // $feedback = "Stored in: " . "upload/" . $fileName;
                     }
					 
				    $student = new User();
					$absence = new Absence();
					// file die we selecteren staat op de server
					$tmpName = $_FILES["file"]["name"];
					try
					{
						// ge-uploade file openen en converteren om dan te inserten in de db
						$fp = fopen("upload/" . $tmpName, 'r');
						$data = fread($fp, filesize("upload/" . $tmpName));
						$data = addslashes($data);
						fclose($fp);
						unlink("upload/" . $fileName);
						$student->Username = $_SESSION['name'];
						$student->Type = $_SESSION['userType'];
						$student->Id = $student->getUserId();
						$student->CurrentAbsence = $absence;
						$absence->From = $_POST['dateFrom'];
						$absence->To = $_POST['dateTo'];
						$absence->Reason = $_POST['reason'];
						$absence->Note = $data;
						$absence->User_id = $student->Id;
						$inserted = $student->addAbsence();
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
			}
			else
            {
                //echo "Invalid file";
                $error = "Onjuist bestand! Alleen bestanden met extentie </br>.png, .jpg, .pdf en .bmp zijn toegelaten.";
				$sansJSError = $error;
            }
			
			
			/*if(file_exists("upload/".$fileName) && (pathinfo($fileName, PATHINFO_EXTENSION) == "png" 
				|| pathinfo($fileName, PATHINFO_EXTENSION) == "pdf" || pathinfo($fileName, PATHINFO_EXTENSION) == "bmp" 
				|| pathinfo($fileName, PATHINFO_EXTENSION) == "jpg" ))
            {
					$student = new User();
					$absence = new Absence();
					try
					{
						// ge-uploade file openen en converteren om dan te inserten in de db
						$fp = fopen("upload/".$fileName, 'r');
						echo $fileName;
						echo $fp;
						$data = fread($fp, filesize("upload/".$fileName));
						$data = addslashes($data);
						fclose($fp);
						unlink("upload/" . $fileName);
						$student->Username = $_SESSION['name'];
						$student->Type = $_SESSION['userType'];
						$student->Id = $student->getUserId();
						$student->CurrentAbsence = $absence;
						$absence->From = $_POST['dateFrom'];
						$absence->To = $_POST['dateTo'];
						$absence->Reason = $_POST['reason'];
						$absence->Note = $data;
						$absence->User_id = $student->Id;
						$inserted = $student->addAbsence();
						if($inserted)
						{
							$feedback = "Afwezigheid is toegevoegd!";
						}
					}
					catch(Exception $e)
					{
						$error = $e->getMessage();
					}
			}
			else
            {
                 //echo "lukt niet";
                if(!file_exists("upload/".$fileName))
                {
                   $error = "Bestand wordt niet gevonden!";
                }
                if(pathinfo($fileName, PATHINFO_EXTENSION) != "png" || pathinfo($fileName, PATHINFO_EXTENSION) != "pdf"
				   || pathinfo($fileName, PATHINFO_EXTENSION) != "bmp" || pathinfo($fileName, PATHINFO_EXTENSION) != "jpg")
                {
                   $error = "Bestand heeft niet de juiste extensie! Alleen bestanden met extentie </br>
				   			.png, .jpg, .pdf en .bmp zijn toegelaten.";
                }
            }*/
		}
		else
		{
			$error = "Kon bestand niet invoeren!";
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
        	   <section id="mainContainer">
    	<?php 
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                	<?php include_once("include_nav_options_student.php");?>
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
                           
                           <div id="results" class="addAbsenceResult">
                        	<form id="addAbsenceStudentForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                            	enctype="multipart/form-data">
                            	<p>
                                	<fieldset>
  										<legend>Details afwezigheid: </legend>
  										<!--<label for="dateFrom">Vanaf: </label>-->
                                        <input class="inputField" name="dateFrom" type="text"
                                        	placeholder="Vanaf (mm/dd/yyyy)" id="datepickerFrom" />
                                        </br>
                                        <!--<label for="dateTo">Tot (en met): </label>-->
                                        <input class="inputField" name="dateTo" type="text" 
                                        	placeholder="Tot (en met) (mm/dd/yyyy)" id="datepickerTo" />
                                        </br>
                                        <!--<label for="reason">Reden: </label>-->
                                        <input class="inputField" name="reason" type="text" 
                                        	placeholder="Reden"id="reason" />
                                        </br>
                                        <!--<label for="note">Attest: </label>-->
                                        <input placeholder="Attest" type="text" id="fileName" class="file_input_textbox" readonly>
                                                <div class="file_input_div">
                                                    <input style="margin-left:3px;" type="button" value="Zoek bestand" 
                                                    	class="loginButton customButton file_input_button" /> 
                                                    <input style="margin-left:3px;" type="file" name="file" id="file" 
                                                    		size="1" class="file_input_hidden" />
                                                </div>
  									</fieldset>
                                     <input class="loginButton customButton" type="submit" value="Voeg afwezigheid toe" 
                                        		id="btnCreateAbsence"
                                        	 name="btnCreateAbsence"/>
                                </p>
                            </form>
                        
                        </div> <!-- end results-->
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
				$("#addAbsenceslink").addClass("active");
				
				$( "#datepickerFrom" ).datepicker();
				$( "#datepickerTo" ).datepicker();

			});	
		</script>
    </body>
</html>