<?php
 include_once("classes/User.class.php");
 session_start();

	if(isset($_SESSION['name']) || isset($_POST['btnShowAll']))
	{
		try
		{
			//$teachers = array();
			$teacher = new User();
			//$teacher->Username = $_SESSION['name'];
			$results = $teacher->getAllUsers('teacher');
			$teachers = getArrayTeachers($results);
			
			$teacherCount = count($teachers);
			//echo $teacherCount;
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	if(isset($_POST['btnSearch']) && empty($_POST['searchTeachers']))
	{
		$sansJSError = "Vul eerst een sleutelwoord in!";
	}
	
	if(isset($_POST['btnSearch']) && !empty($_POST['searchTeachers']))
	{
		try
		{
			//$resultQuery = array();
			//$foundTeachers = array();
			$teacher = new User();
			$resultQuery = $teacher->searchUsers(htmlspecialchars($_POST['searchTeachers']),'teacher');
			
			$teachers = getArrayTeachers($resultQuery);
			
			$teacherCount = count($teachers);
			if($teacherCount <= 0)
			{
				$teacher = new User();
				//$teacher->Username = $_SESSION['name'];
				$results = $teacher->getAllUsers('teacher');
				$teachers = getArrayTeachers($results);
				
				$teacherCount = count($teachers);
				$error =  "Geen docenten gevonden op basis van sleutelwoord!";
				$sansJSError = $error;
			}
			else
			{
				$feedback = "Zoekopdracht volbracht!";
				$sansJSError = $feedback;
			}
			
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
	if(isset($_GET['deletebutton']))
	{
		$deleteId = $_GET['deleteId'];
		
		try
		{
			$teacher = new User();
			$results = $teacher->deleteTeachers($deleteId);
			$newTeachers = $teacher->getAllUsers('teacher');
			$feedback = "Docent goed verwijderd!";
			$teachers = getArrayTeachers($newTeachers);
			$teacherCount = count($teachers);
			//echo $teacherCount;
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
		//echo $deleteId;
	}
	

	function getArrayTeachers($p_aArray)
	{
		$teachers = array();
		for($i=0; $i < count($p_aArray); $i++)
		{
			$teacher = new User();
			$teacher->Id = $p_aArray[$i]["id"];
			$teacher->Username = $p_aArray[$i]["username"];
			$teacher->Firstname = $p_aArray[$i]["firstname"];
			$teacher->Lastname = $p_aArray[$i]["lastname"];
			array_push($teachers,$teacher);
		}
		
		return $teachers;
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
                    	<h3>Verwijder docent</h3>
            <?php if($teacherCount > 0)
			{?>    
                       		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                               	<input id="keyword" type="text" name="searchTeachers" class="input-medium ">
                                <span id="formButtons">
 								<button id="btnSearch" name="btnSearch" type="submit" class="loginButton customButton">Zoek</button>
                                <input id="btnShowAll" name="btnShowAll"  type="submit" class="loginButton customButton" 
                                	value="Toon alle docenten"/>
                                </span>
							</form>
      		
                        <div id="results">
                        <div id="aroundTable">
							<table id="teacherTable"  >
                            	<thead>
                                	<tr>
                                    	<th>Id</th>
                                        <th>Gebruikersnaam</th>
                                        <th>Voornaam</th>
                                        <th>Achternaam</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php if(isset($teacherCount) )
									{
										$index = 1;
										foreach($teachers as $t)
										{ 
										  if($index % 2 == 0)
										  { 
										  	echo '<tr class="alt cRow">';
										  }
										  else
										  {
											echo '<tr class="cRow">';
										  }
										  echo '<td class="teacherId">' . $t->Id . '</td>';
										  echo "<td>" . $t->Username . "</td>";
										  echo "<td>" . $t->Firstname . "</td>";
										  echo "<td>" . $t->Lastname . "</td>";
										  echo '
										  	 <td class="removeT">
													<span>
														<i class="icon-trash icon-white"></i>
														<img class="loadingImageDelete" src="img/loading.gif" />
													</span>
                                        	</td>
										  '; 
										 
										  echo "</tr>";
										  $index++;
										}
									}
									
									?>
                                </tbody>
                            </table>
                            </div>
                            
                                                        
                     <!--    <div style=" margin-top:5%; width:500px;">  
                           <form id="showAll" action="<?php echo $_SERVER['PHP_SELF'] ?>" 
                           	method="post" style="float:left" >
                               <input id="btnShowAll" name="btnShowAll"  type="submit" class="btn" value="Toon alle docenten"/>
					       </form>
                                    
							<!--<form action="<?php echo $_SERVER['PHP_SELF'] ?>" style="float:right;"
                            	method="post" id="deleteTeacherForm">-->
  							<!--	<button id="btnDeleteTeacher" name="btnDelete" 
                                	type="submit" class="btn btn-primary">Verwijder</button>-->
                                <input style="display:none" type="text" id="deleteRow" name="deleteId" />
							<!--</form>-->
                    <!--     </div>	-->

						</br>
                        </div> <!-- end results-->
                   <?php }
				   else
				   {
					   echo "<strong>Geen docenten gevonden!</strong>";
				   }
				   ?>
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
				
			//	$(".deleteTeacherStyle").css("background-image","url(img/removeteache_16x13_whiter.png)");
				
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
				$("#deleteTeacherlink").addClass("active");
				
				
			/*	var tableRows = $('#teacherTable .cRow').map(function(){
      					return this.id;
   				}).get();
				
				var rowCount = tableRows.length;
				if(rowCount >= 10)
				{
					$("#aroundTable").css("overflow-y","scroll");
				}*/

			});	
		</script>
        
    </body>
</html>