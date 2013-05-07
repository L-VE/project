<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_POST['user_id']) && isset($_POST['ab_id']) )
		{
			$abId = $_POST['ab_id'];
			$userId = $_POST['user_id'];
			$ab = new Absence();
			$user = new User();
			$user->Id = $userId;
			$ab->Id = $abId;
			$user->CurrentAbsence = $ab;
			try
			{
				$result = $user->deleteAbsence();
				if($result)
				{
					$feedback['text'] = "Afwezigheid verwijderd.";
					$feedback['status'] = "success";
				}
				else
				{
					$feedback['text'] = "Fout bij verwijdering!";
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
