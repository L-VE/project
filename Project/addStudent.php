            <?php
                 include_once("classes/User.class.php");
                 $userProps = array();
                        if(isset($_POST['submit']) && !empty($_FILES['file']['name']))
                            {
                                $allowedExts = array("txt","csv");
                                
                                $fileName = $_FILES["file"]["name"];
                                $fileType = $_FILES["file"]["size"] ;
                                $fileSize = $_FILES["file"]["size"];
                                $fileTmpName = $_FILES["file"]["tmp_name"];
                                $fileError = $_FILES["file"]["error"];
                                
                                $extensionArray = explode(".", $fileName);
                                $extension = end($extensionArray);
                                
                                if ((pathinfo($fileName, PATHINFO_EXTENSION) == "csv" 
                                || pathinfo($fileName, PATHINFO_EXTENSION) == "txt")
                               // && ($fileSize < 20000)
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
                                        /*echo "Upload: " . $fileName . "<br>";
                                        echo "Type: " . $fileType . "<br>";
                                        echo "Size: " . ($fileSize / 1024) . " kB<br>";
                                        echo "Temp file: " . $fileTmpName . "<br>";*/
                                    
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
                                    }
                                }
                                else
                                {
                                    //echo "Invalid file";
                                    $error = "Onjuist bestand! Alleen bestanden </br> met extentie .csv en .txt zijn toegelaten.";
									$sansJSError = $error;
                                }
                                
                                $userAttr = array("Username","Password","Firstname","Lastname","Type");// mms hier nog de optie txt doen
                                if(file_exists("upload/".$fileName) && pathinfo($fileName, PATHINFO_EXTENSION) == "csv")
                                {
                                    //echo "</br>";
                                    //echo "</br>";
                                    $student = new User();
                                    $countStudents = 0;
                                    $students = array();
                                                $f = fopen("upload/".$fileName,"r");
                                                $fCount = count($f);
                                            //	echo $fCount;
                                                while(!feof($f))
												{ // file end of file = feof
													$feedbackerror = "";
                                                    $line = fgets($f); // filegetstring = fgets
                                                    $pieces = explode(";", $line);
												
													$AllFilledIn = false;
													foreach($pieces as $piece)
													{
														if(empty($piece) || ctype_space($piece))
														{
															$AllFilledIn = false;
															//feedbackerror = "Sommigen bestonden al of 
																//bevatte onjuist aantal gegevens!";
														}
														else
														{
															$AllFilledIn = true;
															$feedbackerror = "";
														}
													}
													
														if(count($pieces) == 4 && $AllFilledIn)
														{
															   $index = 0;
																while($index < count($pieces) && count($pieces) > 1)
																{
																	$student = new User();
																	$student->Username = trim($pieces[$index]);
																	$index++;
																	$student->Password = trim($pieces[$index]);
																	$index++;
																	$student->Firstname = trim($pieces[$index]);
																	$index++;
																	$student->Lastname = trim($pieces[$index]);
																	$index++;
																	$student->Type = "student";
																   // $index++;
																	//echo $student->toString();
																	//$students[$index]=$student;
																	array_push($students,$student);
																	$countStudents++;
																//	echo $students[1]->toString();
																	//var_dump($students);
																	//echo "index = " . $index . " en count pieces " . count($pieces);
																	//echo "</br></br>";
																//	echo "student: " . $students[0];
																
																$feedbackerror = "";
																}
														}
														/*else
														{
															$feedbackerror = "Sommigen bestonden al of 
																bevatte onjuist aantal gegevens!";
														}*/
                                                   // echo "</br>";
                                                }
                                                fclose($f);
												unlink("upload/" . $fileName);
                                                try
                                                {
                                                    $student->addStudent($students);
													if($countStudents >= 1)
													{
														$stringcount = " studenten ";
													}
													else
													{
														$stringcount = " student ";
													}
                                                    $feedback = $countStudents . $stringcount . "toegevoegd. " . $feedbackerror;
													$sansJSError = $feedback;
													
                                                }
                                                catch(Exception $e)
                                                {
                                                    $error = $e->getMessage();
													$sansJSError = $error;
                                                }
                                                
                                }
                                else
                                {
                                    //echo "lukt niet";
                                    if(!file_exists("upload/".$fileName))
                                    {
                                        $error = "Bestand wordt niet gevonden!";
										$sansJSError = $error;
                                    }
                                    if(pathinfo($fileName, PATHINFO_EXTENSION) != "csv")
                                    {
                                        $error = "Bestand heeft niet de juiste extensie! Alleen bestanden </br> met 
											extentie .csv en .txt zijn toegelaten.";
											$sansJSError = $error;
                                    }
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
                    
                     <h3>Voeg studenten toe</h3>
                        <div id="results" class="addTeacherResult">  
                            <form id="addstudents" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                            		 enctype="multipart/form-data">
                            	<p>
                    				<fieldset>
                                            <input placeholder=".csv of .txt bestand" type="text" 
                                            		id="fileName" class="file_input_textbox" readonly>
                                                <div class="file_input_div">
                                                    <input type="button" value="Open bestand" 
                                                    	class="loginButton customButton file_input_button"
                                                        	style="font-size:13px;" /> 
                                                    <input type="file" name="file" id="file" size="1" 
                                                    	style="background-color:#01a1af" class="file_input_hidden" 
                                                      />
                                                </div>
                                            <div id="send">
                                                <input class="loginButton customButton" type="submit" name="submit" 
                                                	value="Voeg studenten toe"
                                                	 id="submitFile">
                                            </div>
                                        </fieldset>
                   				</p> 
                            </form>     
    <!-- onchange="javascript: document.getElementById('fileName').value = this.value"-->
                        </div>  <!-- /div results-->  
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
				$("#homelink i").removeClass("icon-white");
				//$(".addStudentStyle").css("background-image","url(img/addstuden14x14_white.png)");
				
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
				$("#addStudentlink").addClass("active");
				
			/*	$("#file").on('change', function(){
					//alert($("#file").val());
					$("#fileName").val($("#file").val());
				});*/

			});	
		</script>
    </body>
</html>