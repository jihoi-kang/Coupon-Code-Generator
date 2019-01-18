<?php
session_start();

include_once '../config/database.php';
include_once '../objects/coupon.php';

/* Block Illegal Access */
if($_SESSION['id'] != "admin"){
?>
	<meta http-equiv="refresh" content="0;url=/main.php" />
<?php
	exit;
}

/* Get Database Connection */
$database = new Database();
$db = $database->getConnection();

$coupon = new Coupon($db);

$page = $_GET['page'];
$onePage = 100;
$currentLimit = ($onePage * $page) - $onePage;

/* Get coupon data list */
$stmt = $coupon->read($currentLimit, $onePage);
$num = $stmt->rowCount();

if($num > 0){
	$coupons_arr = array();
	$coupons_arr["records"] = array();
		
	/* push data into coupons_arr & print */
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);

		$coupon_item = array(
			"code" => $code,
			"code_group" => $code_group,
			"users_idx" => $users_idx,
			"id" => $id,
			"created" => $created
		);

		array_push($coupons_arr["records"], $coupon_item);
	}

	echo json_encode($coupons_arr);
}

?>
