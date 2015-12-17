<!DOCTYPE html>
<?PHP
	include 'include.php';
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$seller = "SELECT * FROM SELLER_LOGIN WHERE username='$username' and password='$password'";
		$mgr = "SELECT * FROM MGR_LOGIN WHERE username='$username' and password='$password'";
		$Requestseller = oci_parse($conn, $seller);
		$Requestmgr = oci_parse($conn, $mgr);
		oci_execute($Requestseller);
		oci_execute($Requestmgr);
		$row1 = oci_fetch_array($Requestseller, OCI_RETURN_NULLS+OCI_ASSOC);
		$row2 = oci_fetch_array($Requestmgr, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row1){
			$_SESSION['ID'] = $row1['ID'];
			$_SESSION['NAME'] = $row1['NAME'];
			$_SESSION['SURNAME'] = $row1['SURNAME'];
			echo '<script>window.location = "mainseller.php";</script>';
		}
		elseif ($row2) {
			$_SESSION['ID'] = $row2['ID'];
			$_SESSION['NAME'] = $row2['NAME'];
			$_SESSION['SURNAME'] = $row2['SURNAME'];
			echo '<script>window.location = "mainmgr.php";</script>';
		}
		else
		{
			echo "Login fail.";
		}
	};
	oci_close($conn);
?>
<html>
	<head>
		<meta charset="utf-8">
		<script src="asset/jquery-1.11.3.min.js"></script>
		<script>
			var currentimg = 1;
			var maximg = 3;
			
			$(function()
			{			
				$("#slideshow").hover(function()
				{
					$("#btns").fadeIn(250);
				}, function()
				{
					$("#btns").fadeOut(250);
				});
			});
			
			
			function show()
			{
				$("#login").toggle();
			}
			
	
		</script>
		<link rel="stylesheet" type="text/css" href="asset/styles.css">
		<title>LOGIN</title>
	</head>
	<body>
		<div id="content">
			<div id="header">
				CPE Railway Company
			</div>
			<div id="slideshow">
				<div id="btns">
					<a style="position: absolute; top: -200px; left: 190px;" href="javascript:void(0);" onclick="show();"><img src="images/login_icon.png"></a>
					
				</div>
                <a><img src="images/login.jpg"></a>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>
    <div class="container" style="position: absolute; top: 250px; left: 300px; display:none;"" id = "login" >
				<div class="login-box">
					<div class="box-header">
						<h2>Log In</h2>
					</div>
             <form action='login.php' method='post'>
				<label for="username">Username</label>
				<br/>
				<input type="input" name="username">
				<br/>
				<label for="password">Password</label>
				<br/>
				<input type="password" name="password">
				<br/>
				<button type="submit" name="submit">Log In</button>
				<br/>
             </form>
				
				</div>
	 </div>
</html>

