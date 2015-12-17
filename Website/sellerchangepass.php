<!DOCTYPE html>
<?PHP
	include 'include.php';
	$id = $_SESSION['ID'];
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "login.php";</script>';
	}
?>
<?PHP
	if(isset($_POST['changepass']))
	{
		$old_pass = trim($_POST['oldpass']);
		$new_pass = trim($_POST['newpass']);
		$query = "SELECT PASSWORD FROM SELLER_LOGIN WHERE ID = '$id' and password ='$old_pass'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row)
		{
			$query = "UPDATE SELLER_LOGIN SET password ='$new_pass' WHERE ID = '$id' and password ='$old_pass'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo '<script>window.location = "mainseller.php";</script>';
		}
		else
		{
		 echo "Change Password fail.";
		}
	};
	oci_close($conn);
?>
<html>
	<head>
		<meta charset="utf-8">
		<script src="asset/jquery-1.11.3.min.js"></script>
		<script>
	
		</script>
		<link rel="stylesheet" type="text/css" href="asset/styles.css">
		<title>CPE Railway Company</title>
	</head>
	<body>
		<div id="content">
			<div id="header" style = "margin-left: 20px;">
			 Seller	
			</div>
          	<div class="select" ><br> 
            	<a href="logout.php">Logout</a>  <br><br>              	 
          	</div>
          	<div class="select2" ><br>
                <a href="mainseller.php">หน้าแรก</a> |
            	<a href="select.php">ซื้อตั๋ว</a> |
            	<a href="selectp.php">ส่งสินค้า</a> |
            	<a href="changeticket.php">เปลี่ยนตั๋ว</a> <br><br>              	 
          	</div>
			<div id="slideshow">
                <a><img src="images/index.jpg"></a>
				<div class="container" style="position: absolute; top: 50px; left: 400px; " align="center">
					
					<form action='sellerchangepass.php' method='post'>
					Set new password<br><br>
					Old Password <br>
					<input name='oldpass' type='password'><br><br>
					New Password <br>
					<input name='newpass' type='password'><br><br>
					<input name='changepass' type='submit' value='Change Password'>
					</form>
					
				</div>
			</div>
            <div class="footer">
				<br>	 
            </div>
        
    	</div>
        
	</body>  
</html>



