<?php
	include_once('../classes/User.class.php');
	
	if(isset($_POST['username']))
	{
		$u = new User();
		$u->Username = $_POST['username'];
	
		if($u->UsernameAvailable())
		{
			// ok
			$feedback['text'] = "Gebruikersnaam is nog beschikbaar.";
			$feedback['status'] = "success"; 
		}
		else
		{
			//niet ok
			$feedback['text'] = "Gebruikersnaam is niet meer beschikbaar.";
			$feedback['status'] = "error";
		}
		
		header('Content-Type: application/json');
		echo json_encode($feedback);
	}

?>