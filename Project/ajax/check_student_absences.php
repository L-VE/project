<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_GET['user_id']))
		{
			$studentId = $_GET['user_id'];
			$student = new User();
			try
			{
				
				$student->Id = $studentId;
				$student->Type = 'student';
				$absences = $student->getAbsences();
				$absencesCount = count($absences);
				
				/*if($absencesCount  0)
				{
					$feedback['text'] = "Student heeft (nog) geen afwezigheden!";
					$feedback['status'] = "error";
				}
				else
				{*/
					$feedback['text'] = "Student heeft onderstaande afwezigheden.";
					$feedback['status'] = "success";
				//}
			}
			catch(Exception $e)
			{
				$feedback['text'] = $e->getMessage();
				$feedback['status'] = "error";
			}
			
			header('Content-Type: application/json'); 
			echo json_encode($feedback);
		}
		else
		{
			echo "niet set";
		}
		
		
?>
