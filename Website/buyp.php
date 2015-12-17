<?PHP
	include 'include.php';
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME']))
    {
		echo '<script>window.location = "login.php";</script>';
	}
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
                <a href="sellerchangepass.php">Change Password</a> |
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
				
				<div class="container" style="position: absolute; top: 50px; left: 20px;" align="center">
					
					<div align="center">
<form action='confirmp.php' method='post'>
<table width ="30%"> 
<tbody>  
  <tr>
  	  <td width ="10%" >
        <?php
			$import_train = trim($_POST['SELECTTRAIN']);
			    $import_type = trim($_POST['SELECTTYPE']);
			    $import_between = trim($_POST['SELECTBETWEEN']);
          //echo "Weight <input type=\"input\" name=\"SELECTWEIGHT\">";
          $select_train = trim($_POST['SELECTTRAIN']);
          $select_type = trim($_POST['SELECTTYPE']);
          $select_between = trim($_POST['SELECTBETWEEN']);
          $select_sum = trim($_POST['SELECTSUMWEIGHT']);
          $select_day = trim($_POST['SELECTDAY']);
          $select_month = trim($_POST['SELECTMONTH']);
          $select_year = trim($_POST['SELECTYEAR']);
			    echo "<br>No_Train : ".$import_train." : ".$import_type."<br><br>";
		?>
      </td>  
      <td width ="50%" align="center">
        <?php 
          echo "Product <input type=\"input\" name=\"SELECTPRODUCT\">";
          echo " Weight <input type=\"input\" name=\"SELECTWEIGHT\"> (".$select_sum.")";
        ?>
      </td>   
  </tr>
</tbody> 
</table>  
</div>

<div align="center">
  <table width ="30%">
    <tbody>
      <?php
          //echo "<br>No_Train : ".$import_train." : ".$import_type."<br><br>";
          //$w = oci_parse($conn, "SELECT PRODUCT_WEIGHT FROM TRAIN WHERE NO_TRAIN = '$select_train'");
          //oci_execute($w);
          //while ($row = oci_fetch_array($w, OCI_ASSOC+OCI_RETURN_NULLS)) 
          //{ 
          //  foreach ($row as $key => $item) 
            ///{
           //   echo "<input type=\"hidden\" name=\"SELECTSUMWEIGHT\" value=\"$select_sum\">";
            //}
          //}
      ?>
    </tbody>
  </table>
  <br><br>
  <table>
  	<tr>
  		<?php 
        echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
        echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
        echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
        echo "<input type=\"hidden\" name=\"SELECTSUMWEIGHT\" value=\"$select_sum\">";
        echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$select_train\">";
        echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$select_type\">";
        echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$select_between\">";
      ?>
		Name1 
		<input name='name1' type='input'>
    Name2 
    <input name='name2' type='input'>
		Tel
		<input name='tel' type='input'><br><br>
		<input name='buy' type='submit' value='Buy'>
	</tr>
  </table>
</form>
</div>

					
				</div>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>  
</html>

