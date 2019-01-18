<?php

/* MySQL Connect */
class Database{
	/* DB info */
	private $host = "localhost";
	private $db_name = "db";
	private $username = "root";
	private $password = "-a23309136";

	public $conn;

	/* Get MySQL Connection */
	public function getConnection(){
		$this->conn = null;
		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";", $this->username , $this->password);
		} catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}
		return $this->conn;
	}

}

?>

