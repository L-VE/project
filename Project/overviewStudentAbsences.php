<?php 
	session_start();
	include_once("classes/User.class.php");
	
	if(isset($_SESSION['name']) || isset($_GET['btnShowAll']))
	{
		try
		{
			$teacher = new User();
			$absences = $teacher->getAllAbsencesStudents();
			$absenceCount = count($absences);
		}
		catch(Exceeption $e)
		{
			$error = $e->getMessage();
		}
	}
	
	if(isset($_GET['keyword']) /*&& !empty($_POST['searchStudents'])*/)
	{
		try
		{
			if(empty($_GET['keyword']))
			{
				$sansJSError = "Vul eerst een sleutelwoord in!";
			}
			else
			{
				$teacher = new User();
				$absences = $teacher->searchInStudentAbsences(htmlspecialchars($_GET['keyword']));
				$absenceCount = count($absences);
				
				if($absenceCount <= 0)
				{
					$absences = $teacher->getAllAbsencesStudents();
					$absenceCount = count($absences);
					$error =  "Niets gevonden op basis van sleutelwoord!";
					$sansJSError = $error;
				}
				else
				{
					$feedback = "Zoekopdracht volbracht!";
					$sansJSError = $feedback;
				}
			}
			
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$sansJSError = $error;
		}
		//}
	}
	
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App-sence</title>
    </head>
    <?php include_once("include_styles.php"); ?>
    <body>
     <section id="mainContainer">
    	<?php 
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
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
                           
                          <span id="spanOverview"> 
                           <h3>Afwezige studenten</h3>
                           
                   <?php if($absenceCount > 0){ ?>        
                           <form id="searchStudentForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get"> 
                                <input id="keyword" name="keyword" type="text"  class="input-medium">
 								<input id="btnSearch"  type="submit"  class="loginButton customButton" value="Zoek"/>
                                <input id="btnShowAll" name="btnShowAll"  type="submit" class="loginButton customButton" 
                                	value="Toon alle studenten"/>
							</form>
                            
                            
                    <!--Body content-->
                        <div id="results" >
							<div id="aroundTable" >
                            	<table id="studentTable" >
                            	<thead>
                                	<tr>
                                    	<th>Voornaam</th>
                                        <th>Achternaam</th>
                                        <th>Vanaf</th>
                                        <th>Tot</th>
                                        <th>Reden</th>
                                        <th>Attest</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php if(isset($absenceCount) )
									{
										for($i = 0; $i < $absenceCount; $i++)
										{ 
										  if($i % 2 != 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<td class="studentId">' . $absences[$i]['firstname'] . '</td>';
										  echo "<td>" . $absences[$i]['lastname'] . "</td>";
										  list($y,$m,$d) = explode("-",$absences[$i]['from']);
                                          $from = $d . '/' . $m . '/' . $y;
										  echo "<td>" . $from . "</td>";
										  list($y,$m,$d) = explode("-",$absences[$i]['from']);
                                          $to = $d . '/' . $m . '/' . $y;
										  echo "<td>" . $to . "</td>";
										  echo "<td>" . $absences[$i]['reason'] . "</td>";
										  echo "<td>";
										  if(empty($absences[$i]['note']))
										  {
											  echo "Bevat geen attest";
										  }
										  else
										  {?>
											  <a href="<?php echo "overviewNote.php?absence_id=" . $absences[$i]['id']; ?>">
                                               		<i class="addAbsencesLinkStyle customLinkStyle"></i> Bekijk attest
                                         	  </a>
									<?php  }
										  echo "</td>";
										  echo "</tr>";
										}
									}
									
									?>
                                </tbody>
                            </table>	
                            
                       <!--   <div style=" margin-top:5%; width:445px;">  
                           <form id="showAll" action="<?php echo $_SERVER['PHP_SELF'] ?>" 
                           	method="post" style="float:left" >
                               <input id="btnShowAll" name="btnShowAll"  type="submit" class="btn" value="Toon alle studenten"/>
					       </form>
                         </div>-->
                            
                          </div> <!-- end aroundTable-->                            
                         
                        
                       </div><!-- end results -->
                       
                      <?php }
					 	 else
						 {
							 echo "Geen afwezige studenten gevonden!";
					  }
					  ?>
                       </span> <!--end spanOverview-->
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
				$("#overviewStudentsAbsenceslink").addClass("active");
			});	
		</script>
    </body>
</html>