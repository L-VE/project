<?php
	class Db
	{
		//lokaal pc laetitia
		private $m_sDatabase = "project_php";
		private $m_sHost = "localhost:3307";
		private $m_sUsername = "root";
		private $m_sPassword = "root";
		
		/*private $m_sDatabase = "codinobe_projectPHP"; // codinobe_projectPHP
		private $m_sHost = "localhost";//"server35.interhostsolutions.be:2222";//= localhost op de server
		private $m_sUsername = "codinobe_letis"; //codinobe_letis
		private $m_sPassword = "hub1734";
		public $conn;*/
		
		public function __construct()
		{
			$this->conn = new mysqli($this->m_sHost,$this->m_sUsername,$this->m_sPassword,$this->m_sDatabase);
			if($this->conn->connect_errno)
			{
				throw new Exception("Er kon geen connectie gemaakt worden met de databank!");
			}
		}
		
		
		public function closeDB()
		{
			mysqli_close($this->conn);
		}
		
		public function canLogin($p_sQuery)
		{
			$result = false;
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				$row_cnt = $resultSet->num_rows;
				
				if($row_cnt == 1)
				{
					$result = true; 
				}
				else
				{
					$result = false; 
					throw new Exception("Fout bij het inloggen! Gebruikersnaam en/of wachtwoord zijn niet correct!");
				}
			}
			else
			{
				  $result = false; 
				  throw new Exception("Gebruikersnaam en/of wachtwoord zijn niet correct!");
			}
 
			$this->closeDB();
			return $result;
		}
		
		public function getUserType($p_sQuery)
		{
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				$row_cnt = $resultSet->num_rows;
				if($row_cnt == 1)
				{
					$type =  $resultSet->fetch_array(MYSQLI_NUM);
					//echo $type[0];
				}
				else
				{
					throw new Exception("Error: meer dan 1 resultaat gevonden!");
				}
			}
			else
			{
				  throw new Exception("Actie kon niet uitgevoerd worden!");
			}
 
			$this->closeDB();
			return $type;
		}
		
		public function insertInDb($p_sQueryString)
		{
			$result = false;
			if($this->conn->query($p_sQueryString))
			{
				$result = true;
				
			}
			else
			{
				$result = false;
				throw new Exception("Kon niet invoegen");
			}
			
			return $result;
		}
		
		public function getUsernames($p_sQueryString)
		{
			return $this->conn->query($p_sQueryString);
		}
		
		public function deleteInDB($p_sQueryString)
		{
			
			$result = false;
			
			if($this->conn->query($p_sQueryString))
			{
				$result = true;
				
			}
			else
			{
				$result = false;
				throw new Exception("Kon niet verwijderen!");
			}
			
			return $result;
		}
		
		public function updateInDB($p_sQueryString)
		{
			
			$result = false;
			if($this->conn->query($p_sQueryString))
			{
				$result = true;
				
			}
			else
			{
				$result = false;
				throw new Exception("Kon niet bewerken!");
			}
			
			return $result;
		}
		
			
		public function checkUsernameInDb($p_sQuery)
		{ 
			$result = false; 
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				$row_cnt = $resultSet->num_rows;
				if($row_cnt >= 1)
				{
					$result = true; 
				}
				else
				{
					$result = false;
				}
			}
			else
			{
				  $result = false; 
			}
 
			//$this->closeDB();
			return $result;
		}
		
		public function selectAll($p_sQuery)
		{ 
			$result =  array(); 
			//$index = 0;
			//echo $p_sQuery;
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					$subResult["id"] = $row["id"];
					$subResult["username"] = $row["username"];
					$subResult["firstname"] = $row["firstname"];
					$subResult["lastname"] = $row["lastname"];
					//$result[$index] = $row;
					//$index++;
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Kon geen gebruikers ophalen!");
			}
		
 
			return $result;
		}
		
		//wordt niet gebruikt
	/*	public function getNotes($p_sQuery)
		{
			$result =  array(); 
			//$index = 0;
			//echo $p_sQuery;
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					$subResult["id"] = $row["id"];
					$subResult["image"] = $row["image"];
					//$result[$index] = $row;
					//$index++;
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Kon geen attesten ophalen!");
			}
		
 
			return $result;
		}*/
		
		public function getNote($p_sQuery)
		{
			//$note = array();
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				$row_cnt = $resultSet->num_rows;
				if($row_cnt == 1)
				{
					while($row =  $resultSet->fetch_array(MYSQLI_ASSOC))
					{
						$note = $row;
					}
					
					//echo $type[0];
				}
				else
				{
					throw new Exception("Error: meer dan 1 resultaat gevonden!");
				}
			}
			else
			{
				  throw new Exception("Actie kon niet uitgevoerd worden!");
			}
 
			//$this->closeDB();
			return $note;
		}
		
		
		public function getAbsences($p_sQuery, $p_sUsertype)
		{
			$result =  array(); 
			//$index = 0;
			//echo $p_sQuery;
			if ($resultSet = $this->conn->query($p_sQuery))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					//$result[$index] = $row;
					//$index++;
					
					switch($p_sUsertype)
					{
						case 'student' : 
							$subResult["id"] = $row["id"];
							$subResult["user_id"] = $row["user_id"];
							$subResult["from"] = $row["from"];
							$subResult["to"] = $row["to"];
							$subResult["reason"] = $row["reason"];
							$subResult["note"] = $row["note"];
							break;
						case 'teacher' : 
							$subResult["id"] = $row["id"];
							$subResult["user_id"] = $row["user_id"];
							$subResult["from"] = $row["from"];
							$subResult["to"] = $row["to"];
							break;
					}
					array_push($result,$subResult);
				}
				//var_dump($result);
			}
			else
			{
				if($p_sUsertype == 'student')
					throw new Exception("Student heeft (nog) geen afwezigheden!");
				else
					throw new Exception("Docent heeft (nog) geen afwezigheden!");
			}
		
 
			return $result;
		}
		
		
		public function getId($p_sQueryString)
		{
			
			if($resultSet = $this->conn->query($p_sQueryString))
			{
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					return $row['id'];
				}
				
			}
			else
			{
				throw new Exception("Kon de gegeven docent niet vinden!");
			}
		}
		
		public function getUserInfo($p_sQueryString)
		{
			$info = array();
			
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				$row_cnt = $resultSet->num_rows;
				if($row_cnt == 1)
				{
					while($row =  $resultSet->fetch_array(MYSQLI_ASSOC))
					{
						$info['username'] = $row['username'];
						$info['firstname'] = $row['firstname'];
						$info['lastname'] = $row['lastname'];
						$info['type'] = $row['type'];
					}

				}
				else
				{
					throw new Exception("Geen informatie gevonden!");
				}
			}
			else
			{
				  throw new Exception("Kon afwezigheden niet ophalen");
			}
			return $info;
		}
		
		public function hasNote($p_sQueryString)
		{
			$result = false;
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				$result = $resultSet;
			}
			else
			{
				  throw new Exception("Kon actie niet uitvoeren!");
			}
			return $result;
		}
		
		public function getAllStudentsAbsences($p_sQueryString)
		{
			$result =  array();
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					//$result[$index] = $row;
					//$index++;
					
					
							$subResult["firstname"] = $row["firstname"];
							$subResult["lastname"] = $row["lastname"];
							$subResult["id"] = $row["id"];
							$subResult["from"] = $row["from"];
							$subResult["to"] = $row["to"];
							$subResult["reason"] = $row["reason"];
							$subResult["note"] = $row["note"];
	
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Kan geen afwezigheden vinden!");
			}
			return $result;
		}
		
		public function getClasses($p_sQueryString)
		{
			$result =  array();
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					//$result[$index] = $row;
					//$index++;
					
					
							$subResult["id"] = $row["id"];
							$subResult["name"] = $row["name"];
	
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Kan geen vakken vinden!");
			}
			return $result;
		}
		
		public function getAllCourses($p_sQueryString)
		{
			$result =  array();
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					//$result[$index] = $row;
					//$index++;
							$subResult["course_id"] = $row["id"];
							$subResult["semester"] = $row["semester"];
							$subResult["name"] = $row["name"];
							$subResult["studentClass"] = $row["studentClass"];
							$subResult["user_id"] = $row["user_id"];
							$subResult["class_id"] = $row["class_id"];
	
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Geen cursussen gevonden!");
			}
			return $result;
		}
		
		public function getListTeachers($p_sQueryString)
		{
			$result =  array();
			if ($resultSet = $this->conn->query($p_sQueryString))
			{
				
				while($row = $resultSet->fetch_array(MYSQLI_ASSOC))//fetch_row())
				{
					//var_dump($row);
					//echo "password " . $row['password'];
					$subResult = array();
					//$result[$index] = $row;
					//$index++;
							$subResult["firstname"] = $row["firstname"];
							$subResult["lastname"] = $row["lastname"];
	
					array_push($result,$subResult);
				}

			}
			else
			{
				throw new Exception("Geen docenten gevonden!");
			}
			return $result;
		}
		
		
	}

?>