<?php
/**
 * 쿠폰 코드가 사용 가능한지 확인해준다.
 */
include_once '../config/database.php';
include_once '../objects/coupon.php';

/* Get database connection */
$database = new Database();
$db = $database->getConnection();

$coupon = new Coupon($db);

/* Set coupon code */
$coupon->code = $_GET['code'];

/* Check available coupon code */
if($coupon->available()){
	http_response_code(200);
	echo json_encode(array("message" => "available"));
} else {
	echo json_encode(array("message" => "unavailable"));
}

?>
