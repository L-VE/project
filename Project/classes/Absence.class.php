<?php
	//include_once("classes/Note.class.php");

	class Absence
	{
		private $m_iId;
		private $m_dFrom;
		private $m_dTo;
		private $m_sReason;
		private $m_bNote;
		private $m_iUser_id;
		
		public function __set($p_sProperty, $p_vValue)
		{
			switch($p_sProperty)
			{
				case 'Id' : $this->m_iId = $p_vValue;
					break;
				case 'From' : 
						if(!empty($p_vValue))
						{
							$this->m_dFrom = $p_vValue;
						}
						else
						{
							throw new Exception("Datum moet ingevuld worden!");
						}
					break;
				case 'To' : 
						if(!empty($p_vValue))
						{
							$this->m_dTo = $p_vValue;
						}
						else
						{
							throw new Exception("Datum moet ingevuld worden!");
						}
					break;
				case 'Reason' : $this->m_sReason = $p_vValue;
					break;
				case 'Note' : $this->m_bNote = $p_vValue;
					break;
				case 'User_id' : $this->m_iUser_id = $p_vValue;
					break;
				default : throw new Exception("Unknown setter");
					break;
			}
		}
		
		public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Id' : return $this->m_iId;
					break;
				case 'From' : return $this->m_dFrom;
					break;
				case 'To' : return $this->m_dTo;
					break;
				case 'Reason' : return $this->m_sReason;
					break;
				case 'Note' :return  $this->m_bNote;
					break;
				case 'User_id' :return  $this->m_iUser_id;
					break;
				default : throw new Exception("Unknown getter");
					break;
			}
		}
		
		
	}
?>