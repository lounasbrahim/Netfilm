<?php 
	class User{
		private $con;
		private $username;
		private $sqlData;
	
		public function __construct($con, $username){	
			$this->con = $con;
			$this->username = $username;

			$query = $con->prepare("SELECT * FROM users WHERE username=:username ");
			$query->bindValue(":username", $username);
			$query->execute();

			$sqlData = $query->fetch(PDO::FETCH_ASSOC);
		}

		public function getFirstName(){
			return $this->sqlData["firstName"];
		}

		public function getLastName(){
			return $this->sqlData["lastName"];
		}

		public function getEmail(){
			return $this->sqlData["email"];
		}





	}

















 ?>