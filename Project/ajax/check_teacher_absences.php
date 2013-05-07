<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_GET['user_id']))
		{
			$studentId = $_GET['user_id'];
			$student = new User();
			$student->Id = $studentId;
			try
			{
				$absences = $student->getAbsences('student');
				$absencesCount = count($absences);
			
					$feedback['text'] = "Docent heeft onderstaande afwezigheden.";
					$feedback['status'] = "success";
			
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
