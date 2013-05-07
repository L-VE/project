<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_POST['course_id']))
		{
			$courseId = $_POST['course_id'];
			$user = new User();
			$course = new Course();
			$course->Id = $courseId;
			$user->CurrentCourse = $course;
			try
			{
				$result = $user->deleteCourse(/*$userId*/);
				if($result)
				{
					$feedback['text'] = "Cursus verwijderd.";
					$feedback['status'] = "success";
				}
				else
				{
					$feedback['text'] = "Fout bij verwijdering cursus!";
					$feedback['status'] = "error";
				}
			}
			catch(Exception $e)
			{
				$feedback['text'] = $e->getMessage();
				$feedback['status'] = "error";
			}
			
			header('Content-Type: application/json'); 
			echo json_encode($feedback);
		}
		
		
?>
