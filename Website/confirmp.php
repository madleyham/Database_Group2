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
		<table width ="10%" border='1'> 
			<tbody>  
					<?php
  						$name1 = trim($_POST['name1']);
  						$name2 = trim($_POST['name2']);
  						$tel = trim($_POST['tel']);
  						$select_train = trim($_POST['SELECTTRAIN']);
  						$select_type = trim($_POST['SELECTTYPE']);
  						$select_between = trim($_POST['SELECTBETWEEN']);
  						$select_sumweight = trim($_POST['SELECTSUMWEIGHT']);
  						$select_weight = trim($_POST['SELECTWEIGHT']);
  						$select_product = trim($_POST['SELECTPRODUCT']);
  						$select_day = trim($_POST['SELECTDAY']);
              			$select_month = trim($_POST['SELECTMONTH']);
              			$select_year = trim($_POST['SELECTYEAR']);
  						echo "<tr><th width=\"5%\">Name1-Name2</th><td width=\"30%\">".$name1."-".$name2."</td></tr><tr><th>Tel</th><td>".$tel."</td></tr>";
  						echo "<tr><th>No_train</th><td>".$select_train."</td></tr><tr><th>Start-End</th><td>";
  						$bt = oci_parse($conn, "SELECT STATION_START,STATION_END FROM STATION_BETWEEN WHERE STATION_BT='$select_between' and TYPE = '$select_type'");
			            oci_execute($bt);
			            while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			            {
			              foreach ($row as $key => $item) 
			              {
			              	echo $item;
			              	if($key == "STATION_START")
			              	{
			              		echo " - ";
			              	}
			              	
			              }
			            }
  						echo "</td></tr>";
						echo "<tr><th>D/M/Y</th><td>".$select_day."/".$select_month."/".$select_year."</td></tr>";
  						echo "<tr><th>Product</th><td>".$select_product."</td></tr>";
  						echo "<tr><th>Weight</th><td>".$select_weight."</td></tr>";
  						$select_weight = $_POST['SELECTWEIGHT'];
						echo "</td></tr>";
						$select_price = $select_weight*10;
						echo "<tr><th>Price</th><td>".$select_price." B</td></tr>"
  					?>
			</tbody> 
		</table>  
		<tr>
			<?php 
				echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
              	echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
              	echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
				echo "<input type=\"hidden\" name=\"name1\" value=\"$name1\">";
				echo "<input type=\"hidden\" name=\"name2\" value=\"$name2\">";
				echo "<input type=\"hidden\" name=\"tel\" value=\"$tel\">";
            	echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$select_train\">";
            	echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$select_type\">";
            	echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$select_between\">";
            	echo "<input type=\"hidden\" name=\"SELECTPRODUCT\" value=\"$select_product\">";
            	echo "<input type=\"hidden\" name=\"SELECTWEIGHT\" value=\"$select_weight\">";
            	echo "<input type=\"hidden\" name=\"SELECTSUMWEIGHT\" value=\"$select_sumweight\">";  
        		//foreach($select_seat as $seat)
        		//{ 
  				//	echo '<input type="hidden" name="SELECTSEAT[]" value="'.$seat.'">';
				//}
        	?>
      		<td width ="10%" align="center">
        		<br><br><input name='ct' type='submit' value='Buy'>
      		</td>
      	</tr> 
	</form>
</div>

<div align="center">
  <table width ="30%">
    <tbody>
      <?php 
        if(isset($_POST['ct']))
        {
        	echo $select_weight;
        	$select_price = (int)$select_weight*10;
        	echo $select_price;
   			$at = oci_parse($conn, "INSERT INTO TICKET_PRODUCT(NO_TRAIN,TYPE,STATION_BT,PRODUCT,WEIGHT,NAME1,NAME2,TEL,PRICE,DAY,MONTH,YEAR) 
   				VALUES('$select_train','$select_type','$select_between','$select_product','$select_weight','$name1','$name2','$tel','$select_price','$select_day','$select_month','$select_year')");
			oci_execute($at);
			$bt = oci_parse($conn, "SELECT STATION_START,STATION_END FROM STATION_BETWEEN WHERE STATION_BT='$select_between' and TYPE = '$select_type' ");
			oci_execute($bt);
			while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			{
			    foreach ($row as $key => $item) 
			    {
			    	if($key == "STATION_START")
			    	{
			        	$dt = oci_parse($conn, "SELECT STATION_BT FROM STATION_BETWEEN WHERE STATION_START='$item' and TYPE='$select_type'");
			        	oci_execute($dt);
			        	while ($h = oci_fetch_array($dt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			        	{
			            	foreach ($h as $j => $k) 
			            	{
			            		if($k != $select_between)
			            		{
			            			//echo $key;
			            			$temp = $k;
			            			$bot = oci_parse($conn, "SELECT WEIGHT FROM SEAT_PRODUCT WHERE NO_TRAIN = '$select_train' and STATION_BT='$temp'");
			            			oci_execute($bot);
			            			while ($p = oci_fetch_array($bot, OCI_ASSOC+OCI_RETURN_NULLS)) 
			            			{
			              				foreach ($p as $k => $i) 
			              				{
			              					//echo $i;
			              					$fv = (int)$i - (int)$select_weight;
			              				}
			           				}
			           				//echo $select_train."-".$select_type."-".$temp."-".$fv;
			             			//echo $k;
			              			$at = oci_parse($conn, "UPDATE SEAT_PRODUCT SET WEIGHT = '$fv' WHERE NO_TRAIN = '$select_train' and TYPE = 
			              				'$select_type' and STATION_BT = '$temp'");
			        				oci_execute($at); 
			            		}
			            	
			        		}
			        	}			
			    	}
			    	else if($key == "STATION_END")
					{
						$dt = oci_parse($conn, "SELECT STATION_BT FROM STATION_BETWEEN WHERE STATION_END='$item' and TYPE='$select_type'");
			        	oci_execute($dt);
			        	while ($h = oci_fetch_array($dt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			        	{
			            	foreach ($h as $j => $k) 
			            	{
			            		//echo $key;
			            		$temp = $k;
			            		$bot = oci_parse($conn, "SELECT WEIGHT FROM SEAT_PRODUCT WHERE NO_TRAIN = '$select_train' and STATION_BT='$temp'");
			            		oci_execute($bot);
			            		while ($p = oci_fetch_array($bot, OCI_ASSOC+OCI_RETURN_NULLS)) 
			            		{
			              			foreach ($p as $k => $i) 
			              			{
			              				//echo $i;
			              				$rv = (int)$i - (int)$select_weight;
			              			}
			           			}
			           			//echo $select_train."-".$select_type."-".$temp."-".$rv;
			             		//echo $k;
			              		$at = oci_parse($conn, "UPDATE SEAT_PRODUCT SET WEIGHT = '$rv' WHERE NO_TRAIN = '$select_train' and TYPE = 
			              			'$select_type' and STATION_BT = '$temp'");
			        			oci_execute($at);
			        		}
			        	}
					}
			    }
			
			}
			$select_price = (int)$select_weight*10;			
			echo $select_price; 
			$bt = oci_parse($conn, "SELECT TIGKET_PRICE FROM AA_TIGKET WHERE DAY='$select_day' and MONTH='$select_month' and YEAR='$select_year' and TYPE='CG'");
			oci_execute($bt);
			while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			{
			    foreach ($row as $key => $item) 
			    {
			        $s = (int)$item + (int)$select_price;
			        $at = oci_parse($conn, "UPDATE AA_TIGKET SET TIGKET_PRICE = '$s' WHERE DAY='$select_day' and MONTH='$select_month' and YEAR='$select_year' and TYPE='CG'");
			        oci_execute($at);        	
			    }
			}      
			echo '<script>window.location = "mainseller.php";</script>'; 
        }
      ?>
    </tbody>
  </table>
</div>


					
				</div>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>  
</html>

