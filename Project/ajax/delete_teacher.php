<?php
	
		include_once("../classes/User.class.php");
		// hier niet meer komen wanneer we werken met ajax
		//als de pagina niet gepost/gesubmit wordt, gaat de code hieronder niet meer gebeuren
		if(isset($_POST['user_id']))
		{
			$userId = $_POST['user_id'];
			$user = new User();
			$user->Id = $userId;
			try
			{
				$result = $user->deleteTeachers(/*$userId*/);
				if($result)
				{
					$feedback['text'] = "Docent verwijderd.";
					$feedback['status'] = "success";
				}
				else
				{
					$feedback['text'] = "Fout bij verwijdering docent!";
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
