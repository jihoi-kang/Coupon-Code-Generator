<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />

		<title>Coupon code generator</title>

		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="custom.css" />
	</head>
	
	<body>
		<!-- session start -->
		<div>
		<?php if(!isset($_SESSION['id']) || !isset($_SESSION['idx'])){ ?>
			<p>Login Please. <a href="signin.php">[LOGIN]</a></p>
		</div>
			<?php exit;
			} else{
				$id = $_SESSION['id'];
				$idx = $_SESSION['idx']; ?>
			<p>Hello, <?php echo $id ?>! <a href="api/user/logout.php">Logout</a></p>
		<?php } ?>

		</div>
		<!-- session end -->
		<!-- nav start -->
		<div>
			<div class="topnav">
			<?php if($id == "admin"){ ?>
				<a href="#" class="active" id='publishCoupon'>Publish Coupon</a>
				<a href="#" id='couponList'>Coupon Code List</a>
			<?php } else { ?>
				<a href="#" class="active" id='useCoupon'>Use Coupon</a>
			<?php } ?>
				<a href="#" id='counponStats'>Coupon Code Statistics</a>
			</div>
		</div>
		<!-- nav end -->

		<!-- container start -->
		<div>
			<div class="row">
				<div class="col">
					<div id="content"></div>
				</div>
			</div>
		</div>
		<!-- container end -->

<!-- jQuery libraries -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!-- jQuery codes -->
<script>
	$(document).ready(function(){
		/* Init */
		if(<?= ($id == "admin") ? 1 : 0 ?>){
			if(<?= (isset($_GET['page'])) ? 1 : 0 ?>)
				showCouponList();
			else
				showPublishCouponBtn();
		}else
			showUseCouponBtn();

		/* publish coupon page */
		$(document).on('click', '#publishCoupon', function(){
			showPublishCouponBtn();
		});
		/* coupon list page */
		$(document).on('click', '#couponList', function(){
			showCouponList();
		});
		/* use coupon page */
		$(document).on('click', '#useCoupon', function(){
			showUseCouponBtn();
		});
		/* coupon statistics page */
		$(document).on('click', '#counponStats', function(){
			alert("Coming Soon-!");
		});
	});

	/* Show View */
	function showPublishCouponBtn(){
		var html = `
				<h3>--  Press the Button below to generate 100K coupons!  --</h3>
				<button id="publishCouponBtnId" onclick="publishCoupon();">Publish Coupon</button>
			`;
		$('#content').html(html);
	}
	function showCouponList(){
		/* Get Data to list coupon */
		<?php include_once 'api/config/core.php' ?>

		$.get("api/coupon/read.php",{page: <?= $page ?>}, function(data){
			var jsonObj = JSON.parse(data);
			var cnt = 0;

			var td = "";
			var used = "";
			var id = "";
			/* Get coupon list data & show */
			while(cnt < 100){
				
				(jsonObj.records[cnt].users_idx == 0) ? used = "available" : used = "nope";
				(jsonObj.records[cnt].id == null) ? id = "-" : id = jsonObj.records[cnt].id;

				td += `<tr>
							<td class="no">` + (cnt + 1 + <?= (($page - 1) * 100) ?>) + `</td>
							<td class="code">` + jsonObj.records[cnt].code + `</td>
							<td class="code_group">` + jsonObj.records[cnt].code_group + `</td>
							<td class="coupon_available">` + used  + `</td>
							<td class="userd_id">` + id + `</td>
							<td class="created">` + jsonObj.records[cnt].created + `</td>
						
						</tr>`;
				cnt++;
			}

			var html = `
			<article class="couponList">
				<h3>Coupon List</h3>
				<table>
					<thead>
						<tr>
							<th scope="col" class="no">no.</th>
							<th scope="col" class="code">code</th>
							<th scope="col" class="code_group">code group</th>
							<th scope="col" class="coupon_available">available coupon</th>
							<th scope="col" class="userd_id">used id</th>
							<th scope="col" class="created">created</th>
						</tr>
					</thead>
					<tbody>
						` + td + `
					</tbody>
				</table>
				<div class="paging">
					<?php echo $paging ?>
				</div>
			</article>
			`;
			$('#content').html(html);
		});
	}

	/* function */
	function showUseCouponBtn(){
		var html = `
				<h3>--  Enter your coupon code!  --</h3>
				<input type="text" id="codes" >
				<button onclick="checkCoupon()" >Use</button>
				<p id="available_result"></p>
			`;
		$('#content').html(html);
	}

	function checkCoupon(){
		var editElem = document.getElementById("codes").value;

		$.get("api/coupon/available.php",{code: "" + editElem }, function(data){
				document.getElementById("available_result").innerHTML = JSON.parse(data).message;
		});
	}
	
	function publishCoupon(){
		document.getElementById("publishCouponBtnId").disabled = true;
		document.getElementById("publishCouponBtnId").innerHTML = "wait!!";
		$.post("api/coupon/create.php", function(data){
			alert(JSON.parse(data).message);
		});
	}
</script>
<!-- HTML page end -->
</body>
</html>

