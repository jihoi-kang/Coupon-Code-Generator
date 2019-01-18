<?php

/**
 * '사용자' 객체의 속성 및 기능 구현
 */

class User {

	/* DB connection & table name */
	private $conn;
	private $table_name = "users";

	/* object properties */
	public $idx;
	public $id;
	public $password;

	public function __construct($db){
		$this->conn = $db;
	}

	/* login check & return true or false */
	public function login(){
		$query = "SELECT idx,password
			FROM " . $this->table_name . "
			WHERE id=?
			LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($this->password == $row['password']){
			$this->idx = $row['idx'];
			return true;
		}

		return false;

	}

}

?>
