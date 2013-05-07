<?php 
	class Course
	{
		private $m_sName; // naam van het vak
		private $m_iId;
		private $m_iUserId;
		private $m_iSemester;
		private $m_sGroup; // klas van het vak
		private $m_iClassId;// id van het vak
		
		
		public function __set($p_sProperty, $p_vValue)
		{
			switch($p_sProperty)
			{
				case 'Name'  :  $this->m_sName = $p_vValue;
					break;
				case 'Id'  :  $this->m_iId = $p_vValue;
					break;
				case 'Userid'  :  $this->m_iUserId = $p_vValue;
					break;
				case 'Semester'  :  $this->m_iSemester= $p_vValue;
					break;
				case 'Group'  :  $this->m_sGroup = $p_vValue;
					break;
				case 'ClassId'  :  $this->m_iClassId = $p_vValue;
					break;
				default: throw new Exception("Unknown setter");
					break;
			}
		}
		
		public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Name'  :  return $this->m_sName;
					break;
				case 'Id'  :  return $this->m_iId;
					break;
				case 'Userid'  :  return $this->m_iUserId;
					break;
				case 'Semester'  :  return $this->m_iSemester;
					break;
				case 'Group'  :  return $this->m_sGroup;
					break;
				case 'ClassId'  :  return $this->m_iClassId;
					break;
				default: throw new Exception("Unknown getter");
					break;
			}
		}
		
	}
?>