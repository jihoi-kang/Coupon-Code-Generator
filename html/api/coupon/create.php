<?php

/**
 * 쿠폰 코드를 발행한다.
 * 10만건 동시 발행 & 랜덤으로 쿠폰 사용한 것으로 처리
 */

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

if($coupon->create()){
	http_response_code(201);

	echo json_encode(array("message" => "Successful publish Coupon code."));
} else{
	http_response_code(503);

	echo json_encode(array("message" => "Unable to create Coupon code"));
}

?>
