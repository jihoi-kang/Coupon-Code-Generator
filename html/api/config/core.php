<?php

include_once 'database.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


/* Init paging data */
$page = isset($_GET['page']) ? $_GET['page'] : 1;

/* Get All coupon's count */
$database = new Database();
$db = $database->getConnection();

$query = "SELECT 
		count(*) as cnt
	FROM
		coupons";

$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$allPost = $row['cnt'];

/* Num of pages to show per page */
$onePage = 100;

$currentLimit = ($onePage * $page) - $onePage;

$allPage = ceil($allPost / $onePage);

/* Section Data Init */
$oneSection = 10;
$currentSection = ceil($page / $oneSection);
$allSection = ceil($allPage / $oneSection);

$firstPage = ($currentSection * $oneSection) - ($oneSection - 1);

if($currentSection == $allSection)
	$lastPage = $allPage;
else
	$lastPage = $currentSection * $oneSection;

$prevPage = (($currentSection - 1) * $oneSection);

$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1);

/* Create Paging section UI & Function UI */
$paging = '<ul>';

if($page != 1){
	$paging .= '<li class="page page_start"><a href="./main.php?page=1">First</a></li>';
}

if($currentSection != 1){
	$paging .= '<li class="page page_prev"><a href="./main.php?page=' . $prevPage . '">Prev</a></li>';
}

for($i = $firstPage; $i < $lastPage; $i++){
	if($i == $page)
		$paging .= '<li class="page current">' . $i . '</li>';
	else
		$paging .= '<li class="page"><a href="./main.php?page=' . $i . '">' . $i . '</a></li>';
}

if($currentSection != $allSection)
	$paging .= '<li class="page page_next"><a href="./main.php?page=' . $nextPage . '">Next</a></li>';

if($page != $allPage)
	$paging .= '<li class="page page_end"><a href="./main.php?page=' . $allPage . '">End</a></li>';


$paging .= '</ul>';





?>
