<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		
		<title>Sign in</title>
	</head>

	<body>
		<!-- login form start -->
		<form method="post" action="api/user/login.php">
			<table>
				<tr>
					<td>ID</td>
					<td><input type='text' name='id' tabindex='1' /></td>
					<td rowspan='2'><input type='submit' tabindex='3' value='Login' style='height:50px'/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type='password' name='password' tabindex='2'/></td>
				</tr>
			</table>
		</form>
		<!-- login form end -->
	</body>

</html>
