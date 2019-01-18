<?php

class Coupon{

	/* DB connection & table name */
	private $conn;
	private $table_name = "coupons";

	/* object properties */
	public $idx;
	public $code;
	public $code_group;
	public $users_idx;
	public $created;

	public function __construct($db){
		$this->conn = $db;
	}
	
	/* Generate 100K coupons */
	public function create(){
		$cnt = 0;

		/* Next Group Check */
		$this->couponGroupCheck();

		$this->conn->beginTransaction();

		while($cnt < 100000){
			/* Genrate coupon */
			$coupon = $this->couponGenerator();
			/* Coupon Exists check */
			if($this->couponExists($coupon))
				continue;
			
			/* insert into coupons Table */
			srand((double)microtime() * 1000000);
			$num = rand() % 5;

			$query = "INSERT INTO
					" . $this->table_name . "(code, code_group, users_idx)
				VALUES 
					('" . $coupon . "','" . $this->code_group . "'," . $num . ")";
			
			$this->conn->exec($query);

			$cnt++;
		}

		$this->conn->commit();

		return true;
	}

	/* Get 100 coupons list  */
	function read($currentLimit, $onePage){
		$query = "SELECT
				coupons.code, coupons.code_group, coupons.users_idx, users.id, coupons.created
			FROM
				" . $this->table_name . "
				LEFT JOIN users
					ON users.idx=coupons.users_idx
			ORDER BY
				coupons.created DESC
			LIMIT ?, ?";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(1, $currentLimit, PDO::PARAM_INT);
		$stmt->bindParam(2, $onePage, PDO::PARAM_INT);

		$stmt->execute();
		
		return $stmt;

	}

	/* Check if coupons are available */
	function available(){
		
		$query = "SELECT
				users_idx
			FROM
				" . $this->table_name . "
			WHERE
				code='" . $this->code . "'
			LIMIT 1";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num > 0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->users_idx = $row['users_idx'];
			if($row['users_idx'] == 0 )
				return true;
			else
				return false;
		}
		return false;
	}
	
	/* Generate coupon code(only one code) */
	function couponGenerator(){

		$len = 13;
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		srand((double)microtime() * 1000000);

		$cnt = 0;
		$str = "KOR";

		while($cnt < $len){
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$str .=$tmp;
			$cnt++;
		}

		return $str;
	}
	/* Check if a coupon exists */
	function couponExists($coupon){
		
		$query = "SELECT *
			FROM " . $this->table_name . "
			WHERE code=?
			LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $coupon);
		$stmt->execute();
		
		$num = $stmt->rowCount();
		if($num > 0){
			return true;
		}
		return false;
	}
	/* Next coupon group check */
	function couponGroupCheck(){
		$this->code_group = 'A';
		
		$query = "SELECT code_group 
			FROM " . $this->table_name . "
			ORDER BY
				created DESC
			LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();

		if($num > 0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			switch($row['code_group']){
				case 'A': $this->code_group = 'B'; break;
				case 'B': $this->code_group = 'C'; break;
				case 'C': $this->code_group = 'D'; break;
				case 'D': $this->code_group = 'E'; break;
				case 'E': $this->code_group = 'F'; break;
				case 'F': $this->code_group = 'G'; break;
				case 'G': $this->code_group = 'H'; break;
				case 'H': $this->code_group = 'I'; break;
				case 'I': $this->code_group = 'J'; break;
				case 'J': $this->code_group = 'K'; break;
				case 'K': $this->code_group = 'L'; break;
				case 'L': $this->code_group = 'M'; break;
				case 'M': $this->code_group = 'N'; break;
				case 'N': $this->code_group = 'O'; break;
				case 'O': $this->code_group = 'P'; break;
				case 'P': $this->code_group = 'Q'; break;
				case 'Q': $this->code_group = 'R'; break;
				case 'R': $this->code_group = 'S'; break;
				case 'S': $this->code_group = 'T'; break;
				case 'T': $this->code_group = 'U'; break;
				case 'U': $this->code_group = 'V'; break;
				case 'V': $this->code_group = 'W'; break;
				case 'W': $this->code_group = 'X'; break;
				case 'X': $this->code_group = 'Y'; break;
				case 'Y': $this->code_group = 'Z'; break;
			}
		}
		
	}

}

?>
