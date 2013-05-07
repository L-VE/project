<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_POST['id']) && isset($_POST['user_id']) && isset($_POST['class_1']) && isset($_POST['group']) 
			&& isset($_POST['semester']))
		{
			$cId = $_POST['id'];
			$semester = $_POST['semester'];
			$group = $_POST['group'];
			$class_1 = $_POST['class_1'];
			$userId = $_POST['user_id'];
			$course = new Course();
			$user = new User();
			$user->Id = $userId;
			$course->Id = $cId;
			$course->Group = $group;
			$course->Semester = $semester;
			$course->ClassId = $class_1;
			$user->CurrentCourse = $course;
			// nog verschil tss docent en student
			
			try// date nog in goede formaat zetten!!!
			{
				$result = $user->updateCourse();
				if($result)
				{
					$feedback['text'] = "Cursus bewerkt.";
					$feedback['status'] = "success";
				}
				else
				{
					$feedback['text'] = "Fout bij bewerking!";
					$feedback['status'] = "error";
				}
			}
			catch(Exception $e)
			{
				$feedback['text'] = "Kon actie niet uitvoeren";
				$feedback['status'] = "error";
			}
			
			header('Content-Type: application/json'); 
			echo json_encode($feedback);
		}
		
		
?>
