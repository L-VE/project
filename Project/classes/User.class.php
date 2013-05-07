<?php
	require_once("Db.class.php");
	require_once("Absence.class.php");
	require_once("Course.class.php");
	//include_once("classes/Db.class.php");
	//include_once("classes/Absence.class.php");

	class User
	{
		private $m_sFirstname;
		private $m_sLastname;
		private $m_iId;
		private $m_sType;
		private $m_sUsername;
		private $m_sPassword;
		private $m_iAbsences = array();
		private $m_iCourses = array();
		private $sSalt = "hffoijzkdbazef"; // md5 van de salt hier is 12cc8362ddd2800d6c7ce35612410596
		
		private $m_aAbsence;
		private $m_aCourse;
		
		/*public function __construct($p_sType)
		{
			$this->m_sType = $p_sType;
		}*/
		
		public function __set($p_sProperty, $p_vValue)
		{
			switch($p_sProperty)
			{
				case 'Firstname' : $this->m_sFirstname = $p_vValue;
					break;
				case 'Lastname' : $this->m_sLastname = $p_vValue;
					break;
				case 'Type' : $this->m_sType = $p_vValue;
					break;
				case 'Absences' : $this->m_iAbsences = $p_vValue;
					break;
				case 'Username':
					if(!empty($p_vValue))
					{
						$this->m_sUsername = $p_vValue;
					}
					else
					{
						throw new Exception("Gebruikersnaam moet ingevuld worden!");
					}
					break;
	
				case 'Password' :
							if(!empty($p_vValue))
							{
								$this->m_sPassword = $p_vValue;
							}
							else
							{
								throw new Exception("Wachtwoord moet ingevuld worden!");
							}
					break;
				case 'Id' : $this->m_iId = $p_vValue;
					break;
				case 'CurrentAbsence' : $this->m_aAbsence = $p_vValue;
					break;
				case 'CurrentCourse' : $this->m_aCourse = $p_vValue;
					break;
				case 'Courses' : $this->m_iCourses = $p_vValue ;
					break;
				default : throw new Exception("Unknown setter");
					break;
			}
		}
		
		
		public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Firstname' : return $this->m_sFirstname;
					break;
				case 'Lastname' : return $this->m_sLastname;
					break;
				case 'Type' : return $this->m_sType;
					break;
				case 'Absences' : return $this->m_iAbsences;
					break;
				case 'Username' :return  $this->m_sUsername;
					break;
				case 'Password' : return $this->m_sPassword;
					break;
				case 'Id' : return $this->m_iId;
					break;
				case 'CurrentAbsence' : return $this->m_aAbsence;
					break;
				case 'CurrentCourse' : return $this->m_aCourse;
					break;
				case 'Courses' : return $this->m_iCourses;
					break;
				default : throw new Exception("Unknown getter");
					break;
			}
		}
		
		public function toString()
		{
			$user = $this->Username . " - " . $this->Password . " - " . $this->Firstname . " - " . $this->Lastname . " - " .$this->Type;
			return $user;
		}
		
		public function UsernameAvailable()
		{
			$db = new Db();
			$sql = "select * from user where username ='" . $db->conn->real_escape_string($this->Username) . "';";
			
			$result = $db->getUsernames($sql);// mysqli_query($link, $sql);
			$num_rows = mysqli_num_rows($result);
			$db->closeDb(); //close connection with Dbase
			
			if($num_rows == 0)
			{
				//$isAvailable = true;
				return true;
			}
			else
			{
				//$isAvailable = false;
				return false;
			}
			
		}
		
		public function canLogin()
		{
			$db = new Db();
			$user = $db->conn->real_escape_string($this->Username);
			$pass = $db->conn->real_escape_string(md5($this->Password . $this->sSalt));
			
			$query1 = "select username, password from user where username = '" . $user . "' and password =  '" . $pass . "';";
			
			$resultQuery1 = $db->canLogin($query1);
			
		/*	if($result)
			{
				header("Location: twitter_view.php");
			}*/
		/*	else
			{
				echo "mislukt";
			}*/
			return $resultQuery1;
			
		}
		
		//voor login
		public function getUserType()
		{
			$db = new Db();
			$user = $db->conn->real_escape_string($this->Username);
			$pass = $db->conn->real_escape_string(md5($this->Password . $this->sSalt));
			$query2 = "select type from user where username = '" . $user . "' and password =  '" . $pass . "';";
			$resultQuery2 = $db->getUserType($query2);
			
			return $resultQuery2;
		}
		
		// voor admin
		public function addStudent(/*$_psUserType*/$p_aStudents)
		{
			$result = true;
			$db = new Db();
			
			foreach($p_aStudents as $student)
			{
				// eerst checken of username  al niet in de db zit
				$check = "select * from user where username = '" . $student->Username . "';";
				//echo $check;
				$checkResult = $db->checkUsernameInDb($check);
				
				//if false = not found in db -> then insert new student
				if(!$checkResult)
				{
					if($result == true)
						{
							/*$sql = "insert into user(username,password,firstname,lastname,type) 
									values (" . "$student->Username" . "," . "$student->Password" . "," . "$student->Firstname" . 
									"," . "$student->Lastname" . "," . "$student->Type" . ");";*/
							$sql = 'insert into user(username,password,firstname,lastname,type) 
									values ("' . $db->conn->real_escape_string($student->Username) . '","' . 
									$db->conn->real_escape_string(md5($student->Password.$this->sSalt)) . '","' . 
									$db->conn->real_escape_string($student->Firstname) . '","' . 
									$db->conn->real_escape_string($student->Lastname) . '","' . 
									$db->conn->real_escape_string($student->Type) . '");';
									//echo $sql;
									
							$result = $db->insertInDb($sql);
						}
						else
						{
							throw new Exception("Error bij het invoeren in de databank!");
						}
				}
				else
				{
					throw new Exception("Een van de ingegeven studenten bestaat al!");
				}
				//al ingevoerde student updaten?
			}
			
			
			$db->closeDb();
			return $result;//geeft false of true terug of de insert gelukt is
		}

	// voor admin
		public function createTeacherAccount()
		{
			$result = false;
			$db = new Db();
			$pass = md5($this->Password . $this->sSalt);
			
			// eerst checken of username  al niet in de db zit
			$check = "select * from user where username = '" . $this->Username . "';";
			//echo $check;
			$checkResult = $db->checkUsernameInDb($check);
				
			//if false = not found in db -> then insert new student
			if(!$checkResult)
			{
				$sql = 'insert into user(username,password,firstname,lastname,type) values ("' . 
				$db->conn->real_escape_string($this->Username) . '","' . $db->conn->real_escape_string($pass) . '","' . 
				$db->conn->real_escape_string($this->Firstname) . '","' . $db->conn->real_escape_string($this->Lastname) . '","' . 				
				$db->conn->real_escape_string($this->Type) . '");';
				
				$result = $db->insertInDb($sql);
			}
			else
			{
				throw new Exception("Ingevulde gebruikersnaam bestaat al!");
			}
			
			$db->closeDb();
			return $result;//geeft false of true terug of de insert gelukt is
		}
		
		//voor admin
		/*public function getAllTeachers()
		{
			$result = array();
			$db = new Db();
			$sql = 'select * from user where type = "teacher";';
			$result = $db->selectAll($sql);
			
			$db->closeDb();
			return $result;
		}*/
		
		
		public function getAllUsers($p_sUserType)// krijgt het type mee van gebruiker die hij moet opvragen, dus niet hemzelf
		{
			$result = array();
			$db = new Db();
			$sql = 'select * from user where type = "' . $p_sUserType . '";';
			$result = $db->selectAll($sql);
			
			$db->closeDb();
			return $result;
		}
		
		//voor admin
		/*public function searchTeacher($p_sSearchQuery)
		{
			$result = array();
			$db = new Db();
			$sql = 'select * from user where type = "teacher" and (username like "%' . $db->conn->real_escape_string($p_sSearchQuery) . 
					'%" or lastname like "%' . $db->conn->real_escape_string($p_sSearchQuery) 
					. '%" or firstname like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%");';
			$result = $db->selectAll($sql);
			
			$db->closeDb();
			return $result;
		}*/
		
		public function searchUsers($p_sSearchQuery,$p_sUserType)
		{
			$result = array();
			$db = new Db();
			$sql = 'select * from user where type = "' . $p_sUserType . '" and (username like "%' 
					. $db->conn->real_escape_string($p_sSearchQuery) . 
					'%" or lastname like "%' . $db->conn->real_escape_string($p_sSearchQuery) 
					. '%" or firstname like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%");';
			$result = $db->selectAll($sql);
			
			$db->closeDb();
			return $result;
		}
		
		//voor admin
		public function deleteTeachers(/*$p_sDeleteId*/)
		{
			$db = new Db();
			$sql = 'delete from user where type = "teacher" and id = ' . $db->conn->real_escape_string($this->Id) . ';';
			$result = $db->deleteInDB($sql);
			
			$db->closeDb();
			return $result;
		}
		
		
		public function getAbsences(/*$p_sUserType*/)
		{
			$db = new Db();
			$id = $db->conn->real_escape_string($this->Id);
			$type = $db->conn->real_escape_string($this->Type);
			$sql="";
			
			switch($type)
			{
				case 'student' :
					$sql = 'select a.id, a.user_id, a.from, a.to, a.reason ,a.note 
							from absence a join user u on u.id = a.user_id 
							where u.type = "' . $type . 
							'" and u.id = ' . $id . ';';
					break;
				case 'teacher' : 
					$sql = 'select a.id, a.user_id, a.from, a.to 
							from absence a join user u on u.id = a.user_id where u.type ="' 
					. $type . '" and u.id = ' . $id . ';';
					break;
			}
			
			$result = $db->getAbsences($sql,$type);// $result = is een array met array van afwezigheden erin
			
			
			if(count($result) > 0)
			{
				//hier afhankelijk van het type de afwezigheden maken met al dan niet een attest
				$absences = array();
				$absence = new Absence();
	
				foreach($result as $r)
				{
					$absence = new Absence();
					$absence->Id = $r['id'];
					$absence->User_id = $r['user_id'];
					$absence->From = $r['from'];
					$absence->To = $r['to'];
					
					if($type == 'student')
					{
						$absence->Reason = $r['reason'];
						$absence->Note = $r['note'];
					}
					array_push($absences,$absence);
				}
				
				$this->Absences = $absences;
				
			//	var_dump($result);
			}
			else
			{
				if($type == 'student')
				{
					throw new Exception("Student heeft (nog) geen afwezigheden!");
				}
				else
				{
					throw new Exception("Docent heeft (nog) geen afwezigheden!");
				}
			}
			$db->closeDb();
			return $this->Absences;
		}
		
	/*	public function insertNote($p_vData)
		{
			$db = new Db();
			$sql = 'insert into note (image) VALUES (' . $p_vData . ');';
			$result = $db->insertInDb($sql);
			$db->closeDb();
			return $result;
		}*/
		
	/*	public function getNote($p_iNoteId)
		{
			$db = new Db();
			$sql = 'SELECT * FROM note WHERE id=' . $p_iNoteId . ';';//'SELECT * FROM note WHERE id="' . $p_iNoteId . '";';
			$result = $db->getNote($sql); 
			$db->closeDb();
			return $result;
		}*/
		
		public function getNote()
		{
			$result = array();
			$db = new Db();
			$sql = 'SELECT * FROM absence WHERE id=' . $db->conn->real_escape_string($this->CurrentAbsence->Id) . ';';
			//'SELECT * FROM note WHERE id="' . $p_iNoteId . '";';
			$result = $db->getNote($sql);
			//echo $result['note']; 
			$db->closeDb();
			return $result['note'];
		}
		
		public function getUserId()
		{
			$db = new Db;
			$sql = 'select id from user where username = "' . $db->conn->real_escape_string($this->Username) 
			. '" and type="' . $db->conn->real_escape_string($this->Type) . '";';
			$result = $db->getId($sql);
			$db->closeDB();
			return $result;
		}
		
		
		//aanpassen op basis van usertype!!!!
		public function addAbsence()
		{
			$result = false;
			if($this->CurrentAbsence->From > $this->CurrentAbsence->To)
			{
				throw new Exception("Datum waarop de afwezigheid beëindigd kan niet vóór de start ervan liggen!");
			}
			else
			{
				$db = new Db();
				$type = $db->conn->real_escape_string($this->Type);
				
				list($m,$d,$y) = explode("/",$this->CurrentAbsence->From);
				$from = $db->conn->real_escape_string("$y-$m-$d");
				
				list($m,$d,$y) = explode("/",$this->CurrentAbsence->To);
				$to = $db->conn->real_escape_string("$y-$m-$d");
				
				switch($type)
				{
					case 'teacher' : 
						$sql = 'INSERT INTO absence (absence.from,absence.to,absence.user_id) VALUES ("' . $from
						 . '","' . $to . '",'
						 . $db->conn->real_escape_string($this->CurrentAbsence->User_id) . ');';
						break;
					case 'student': 
						$sql = 'INSERT INTO absence (absence.from,absence.to,absence.user_id,absence.reason,absence.note) VALUES ("'
							 . $from . '","' . $to . '",' . $db->conn->real_escape_string($this->CurrentAbsence->User_id) . ',"' 
							 . $db->conn->real_escape_string($this->CurrentAbsence->Reason)
							  . '","' . $this->CurrentAbsence->Note  . '");';
						break;
				}
				
				$result = $db->insertInDb($sql);
			}

			$db->closeDB();
			return $result;
		}
		
		public function getUserInformation()
		{
			$db = new Db();
			$result = array();
			
			$sql = 'select * from user where id=' . $db->conn->real_escape_string($this->Id) . ';';
			$result = $db->getUserInfo($sql);
			
			$db->closeDB();
			
			return $result;
		}
		
		
		public function hasNote()
		{
			$db = new Db();
			$result = false;
			$sql = 'select note from absence where id=' .  $db->conn->real_escape_string($this->CurrentAbsence->Id) 
				. ' and note is not null;';
			$result = $db->hasNote($sql);
			$num_rows = mysqli_num_rows($result);
			
			if($num_rows == 1)
			{
				$result = true;
			}
			else
			{
				$result = false;
			}
			
			return $result;

		}
		
		
		public function deleteAbsence()
		{
			$db = new Db();
			$absenceId = $db->conn->real_escape_string($this->CurrentAbsence->Id);
			$userId = $db->conn->real_escape_string($this->Id);
			
			$sql = 'delete from absence where id =' .  $absenceId . ' and user_id = ' . $userId . ';';
			$result = $db->deleteInDB($sql);
			$db->closeDB();
			
			return $result;
		}
		
		
		public function getAllAbsencesStudents()
		{
			$db = new Db();
			$sql = "select u.firstname, u.lastname, a.id, a.`from`, a.`to`, a.reason, a.note from absence a 
					join user u on a.user_id = u.id 		
					where u.type = 'student'; ";
			
			$result = $db->getAllStudentsAbsences($sql);
			$db->closeDB();
			return $result;
		}
		
		public function searchInStudentAbsences($p_sSearchQuery)
		{
			$result = array();
			$db = new Db();
			$sql = 'select u.firstname, u.lastname, a.id, a.`from`, a.`to`, a.reason, a.note from absence a 
					join user u on a.user_id = u.id where u.type = "student" and 
					(u.firstname like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%" 
					or u.lastname like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%" 
					or a.from like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%" 
					or a.to like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%" 
					or a.reason like "%' . $db->conn->real_escape_string($p_sSearchQuery) . '%");';
			
			$result = $db->getAllStudentsAbsences($sql);
			
			$db->closeDb();
			return $result;
		}
		
		public function updateAbsence()
		{
			$db = new Db();
			$u_id = $db->conn->real_escape_string($this->Id);
			$a_id = $db->conn->real_escape_string($this->CurrentAbsence->Id);
			$a_from = $db->conn->real_escape_string($this->CurrentAbsence->From);
			$a_to = $db->conn->real_escape_string($this->CurrentAbsence->To);
			$a_reason = $db->conn->real_escape_string($this->CurrentAbsence->Reason);
			$u_type = $db->conn->real_escape_string($this->Type);
			
			list($m,$d,$y) = explode("/",$a_from);
			$a_from = $db->conn->real_escape_string("$y-$m-$d");
				
			list($m,$d,$y) = explode("/",$a_to);
			$a_to = $db->conn->real_escape_string("$y-$m-$d");
				
			
			switch($u_type)
			{
				case 'teacher' : $sql = 'UPDATE absence SET absence.`from` = "' . $a_from . '", absence.`to` = "' 
								 . $a_to . '"  WHERE absence.id=' . $a_id . ' and absence.user_id=' .  $u_id . ';' ;
					break;
				case 'student' :	$sql = 'UPDATE absence SET absence.`from` = "' . $a_from . '", absence.`to` = "' 
									. $a_to . '", absence.reason = "' . $a_reason . '" WHERE absence.id='
									. $a_id . ' and absence.user_id=' .  $u_id . ';' ;
					break;
			}

			$result = $db->updateInDB($sql);
			$db->closeDb();
			return $result;
		}
		
		public function getClasses()
		{
			$db = new Db();
			
			$sql = 'select * from class;';
			$result = $db->getClasses($sql);
		
			$db->closeDb();
			return $result;
		}
		
		public function addCourse()
		{
			$db = new Db();
			$class_id = $db->conn->real_escape_string($this->CurrentCourse->ClassId);
			$semester = $db->conn->real_escape_string($this->CurrentCourse->Semester);
			$group= $db->conn->real_escape_string($this->CurrentCourse->Group);
			$user_id = $db->conn->real_escape_string($this->Id);
			$sql = 'insert into course(semester,class_id, studentClass, user_id) values (' . $semester . ',' 
					. $class_id .',"' . $group . '",' . $user_id . ');';
		
			$result = $db->insertInDb($sql);	
			$db->closeDb();
			return $result;
		}
		
		public function getCourses()
		{
			$db = new Db();
			$user_id = $db->conn->real_escape_string($this->Id);
			$sql = 'select c.id, c.semester, c.studentClass, c.user_id, ca.`name`, c.class_id from course c ' 
				. ' join class ca on c.class_id = ca.id where c.user_id=' . $user_id .'; ';
			
			$result = $db->getAllCourses($sql);
			$courses = array();
			
			foreach($result as $r)
				{
					$course = new Course();
					$course->Id = $r['course_id'];
					$course->Userid = $r['user_id'];
					$course->Name = $r['name'];
					$course->Group = $r['studentClass'];
					$course->Semester = $r['semester'];
					$course->ClassId = $r['class_id'];
					
					array_push($courses,$course);
				}
				
			$this->Courses = $courses;
			
			$db->closeDb();
			return $courses;
		}
		
		
		public function deleteCourse()
		{
			//delete cursus op basis van id
			$db = new Db();
			$id = $db->conn->real_escape_string($this->CurrentCourse->Id);
			
			$sql = 'delete from course where id=' . $id . ';';
			$result = $db->deleteInDB($sql);
			
			$db->closeDB();
			return $result;
		}
		
		public function updateCourse()
		{
			$db = new Db();
			$u_id = $db->conn->real_escape_string($this->Id);
			$c_id = $db->conn->real_escape_string($this->CurrentCourse->Id);
			$c_group = $db->conn->real_escape_string($this->CurrentCourse->Group);
			$c_classId = $db->conn->real_escape_string($this->CurrentCourse->ClassId);
			$c_semester = $db->conn->real_escape_string($this->CurrentCourse->Semester);
			$c_name = $db->conn->real_escape_string($this->CurrentCourse->Name);				
			$sql = 'update course set studentClass = "' . $c_group . '", semester = ' . $c_semester 
					.  ', class_id = ' . $c_classId . ' where id = ' . $c_id . ';';

			$result = $db->updateInDB($sql);
			$db->closeDb();
			return $result;
		}
		
		public function getAbsentTeachers()
		{
			$db = new Db();
			$u_id = $db->conn->real_escape_string($this->Id);
			
			//eerst alle docenten ophalen waarvan de student de cursus krijgt.
			$sql1 = 'select u.firstname, u.lastname from `user` u join course c on u.id = c.user_id ' . 
					' join class ca on c.class_id = ca.id where u.type = "teacher" ' 
					. ' and ca.name in (select cl.name from course c join class cl on c.class_id = cl.id ' 
					. '	join user u2 on c.user_id= u2.id where u2.id =' . $u_id .') ' 
					. ' and c.studentClass in (select studentClass from course c ' 
					. ' join user u2 on c.user_id= u2.id where u2.id ='  . $u_id .') GROUP BY u.lastname, u.firstname;';
			
			$teachersResult = $db->getListTeachers($sql1);
			$teachers = array();
			
			foreach($teachersResult as $tr)
			{
				$u = new User();
				$u->Firstname = $db->conn->real_escape_string($tr['firstname']);
				$u->Lastname = $db->conn->real_escape_string($tr['lastname']);
	
				//dan voor iedere docent die de student heeft, zijn afwezigheden ophalen
				$sql2 = 'select a.id, a.user_id, a.from, a.to from absence a join user u on a.user_id = u.id where u.firstname = "' .
				$u->Firstname . '" and u.lastname = "' . $u->Lastname . '" and u.type = "teacher";' ;
				$absencesResult = $db->getAbsences($sql2,'teacher');
				$absences = array();
				if($absencesResult > 0)
				{
					foreach($absencesResult as $ar)
					{
						$absence = new Absence();
						$absence->Id = $ar['id'];
						$absence->User_id = $ar['user_id'];
						
						list($y,$m,$d) = explode("-",$ar['from']);
						$from = $db->conn->real_escape_string("$d-$m-$y");
						
						list($y,$m,$d) = explode("-",$ar['to']);
						$to = $db->conn->real_escape_string("$d-$m-$y");
						$absence->From = $from ;
						$absence->To = $to;
						
						array_push($absences,$absence);
					}
					$u->Absences = $absences;
					array_push($teachers,$u);
				}
			}
			
			$db->closeDb();
			return $teachers;
			
		}
		
		// sturctuur nog veranderen met ipv params zoals id mee te geven, ze setten en in de mehtode zelf ze opvragen
		// nog een query maken om alle afwezigheden op te vragen van iedereen dat afwezig is
		
	}
?>