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
	<form action='confirm.php' method='post'>
		<table width ="10%" border='1'> 
			<tbody>  
  				
  					<?php
  						$name = trim($_POST['name']);
  						$tel = trim($_POST['tel']);
  						$select_train = trim($_POST['SELECTTRAIN']);
  						$select_type = trim($_POST['SELECTTYPE']);
  						$select_between = trim($_POST['SELECTBETWEEN']);
  						$select_bogie = trim($_POST['SELECTBOGIE']);
  						$select_day = trim($_POST['SELECTDAY']);
              			$select_month = trim($_POST['SELECTMONTH']);
              			$select_year = trim($_POST['SELECTYEAR']);
  						echo "<tr><th width=\"5%\">Name</th><td width=\"30%\">".$name."</td></tr><tr><th>Tel</th><td>".$tel."</td></tr>";
  						echo "<tr><th>No_train</th><td>".$select_train."</td></tr><tr><th>Start-End</th><td>";
  						$bt = oci_parse($conn, "SELECT STATION_START,STATION_END FROM STATION_BETWEEN WHERE STATION_BT='$select_between'and TYPE = '$select_type'");
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
  						echo "<tr><th>No_Bogie</th><td>".$select_bogie."</td></tr>";
  						echo "<tr><th>No_Seat</th><td>";
  						$select_seat = $_POST['SELECTSEAT'];
  						for ($x = 0; $x < sizeof($select_seat); $x++) 
  						{
   							echo $select_seat[$x];
   							if($x != sizeof($select_seat)-1)
   							{
   								echo ",";
   							}else
   							{

   							}  							
						}
						echo "</td></tr>";
						$select_price = sizeof($select_seat)*100;
						echo "<tr><th>Price</th><td>".$select_price." B</td></tr>"
  					?>
			</tbody> 
		</table>  
		<tr>
			<?php 
				echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
              	echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
              	echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
				echo "<input type=\"hidden\" name=\"name\" value=\"$name\">";
				echo "<input type=\"hidden\" name=\"tel\" value=\"$tel\">";
            	echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$select_train\">";
            	echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$select_type\">";
            	echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$select_between\">";
            	echo "<input type=\"hidden\" name=\"SELECTBOGIE\" value=\"$select_bogie\">";
            	//echo "<input type=\"hidden\" name=\"SELECTSEAT[]\" value=\"$select_seat\">";
            	//echo '<input type="hidden" name="SELECTSEAT[]" value="">';  
        		foreach($select_seat as $seat)
        		{ 
  					echo '<input type="hidden" name="SELECTSEAT[]" value="'.$seat.'">';
				}
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
        	$select_day = trim($_POST['SELECTDAY']);
            $select_month = trim($_POST['SELECTMONTH']);
            $select_year = trim($_POST['SELECTYEAR']);
        	$select_seat = $_POST['SELECTSEAT'];
        	for ($x = 0; $x < sizeof($select_seat); $x++) 
  			{
  				//if($select_seat[$x] == "y")
   				//{
   					$bt = oci_parse($conn, "INSERT INTO TICKET_TRAIN(NO_TRAIN,TYPE,STATION_BT,NO_BOGIE,NO_SEAT,NAME,TEL,PRICE,DAY,MONTH,YEAR) 
   						VALUES('$select_train','$select_type','$select_between','$select_bogie','$select_seat[$x]','$name','$tel','100','$select_day','$select_month','$select_year')");
			        oci_execute($bt);
			        $bt = oci_parse($conn, "SELECT STATION_START,STATION_END FROM STATION_BETWEEN WHERE STATION_BT='$select_between' and TYPE = '$select_type' ");
			        oci_execute($bt);
			        while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			        {
			            foreach ($row as $key => $item) 
			            {
			            	if($key == "STATION_START")
			            	{
			            		$dt = oci_parse($conn, "SELECT STATION_BT FROM STATION_BETWEEN WHERE STATION_START='$item'");
			        			oci_execute($dt);
			        			while ($h = oci_fetch_array($dt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			        			{
			            			foreach ($h as $j => $k) 
			            			{
			             				//echo $k;
			              				$at = oci_parse($conn, "UPDATE SEAT SET STATUS = 'y' WHERE NO_TRAIN = '$select_train' and TYPE = '$select_type' and STATION_BT = '$k' and NO_BOGIE = '$select_bogie' and NO_SEAT = '$select_seat[$x]' and DAY ='$select_day' and MONTH ='$select_month' and YEAR ='$select_year' ");
			        					oci_execute($at); 
			        				}
			        			}
			            	}
			            	else if($key == "STATION_END")
			            	{
			            		$dt = oci_parse($conn, "SELECT STATION_BT FROM STATION_BETWEEN WHERE STATION_END='$item'");
			        			oci_execute($dt);
			        			while ($h = oci_fetch_array($dt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			        			{
			            			foreach ($h as $j => $k) 
			            			{
			             				//echo $k;
			              				$at = oci_parse($conn, "UPDATE SEAT SET STATUS = 'y' WHERE NO_TRAIN = '$select_train' and TYPE = '$select_type' and STATION_BT = '$k' and NO_BOGIE = '$select_bogie' and NO_SEAT = '$select_seat[$x]' and DAY ='$select_day' and MONTH ='$select_month' and YEAR ='$select_year' ");
			        					oci_execute($at); 
			        				}
			        			}

			            	}	
			            }
			        }
			        
   				//}
			} 
			$select_price = sizeof($select_seat)*100; 
			echo $select_price;
			$bt = oci_parse($conn, "SELECT TIGKET_PRICE FROM AA_TIGKET WHERE DAY='$select_day' and MONTH='$select_month' and YEAR='$select_year' and TYPE='PSG'");
			oci_execute($bt);
			while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			{
			    foreach ($row as $key => $item) 
			    {
			    	echo "-".$item;
			        $s = (int)$item + (int)$select_price;
			        $at = oci_parse($conn, "UPDATE AA_TIGKET SET TIGKET_PRICE = '$s' WHERE DAY='$select_day' and MONTH='$select_month' and YEAR='$select_year' and TYPE='PSG'");
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

