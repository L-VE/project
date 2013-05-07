<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_POST['id']) && isset($_POST['to']) && isset($_POST['from']) && isset($_POST['reason']) 
			&& isset($_POST['user_id']) && isset($_POST['type']))
		{
			$abId = $_POST['id'];
			$from = $_POST['from'];
			$to = $_POST['to'];
			$reason = $_POST['reason'];
			$userId = $_POST['user_id'];
			$ab = new Absence();
			$user = new User();
			$user->Type = $_POST['type'];
			$user->Id = $userId;
			$ab->Id = $abId;
			$ab->From = $from;
			$ab->To = $to;
			$ab->Reason = $reason;
			$user->CurrentAbsence = $ab;
			// nog verschil tss docent en student
			
			try// date nog in goede formaat zetten!!!
			{
				$result = $user->updateAbsence();
				if($result)
				{
					$feedback['text'] = "Afwezigheid bewerkt.";
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
