<!DOCTYPE html>
<?PHP
	include 'include.php';
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
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
				<div class="container" style="position: absolute; top: 20px;  " align="center">
					<form action='confirmt.php' method='post'>
		<table width ="20%" border='1'> 
			<tbody>  
  				
  					<?php
  						$name = trim($_POST['NAME']);
  						$tel = trim($_POST['TEL']);
  						$select_oldbogie = trim($_POST['SELECTOLDBOGIE']);
  						$select_oldseat = trim($_POST['SELECTOLDSEAT']);
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
  					?>
			</tbody> 
		</table>  
		<tr>
			<?php 
				echo "<input type=\"hidden\" name=\"SELECTOLDBOGIE\" value=\"$select_oldbogie\">";
              	echo "<input type=\"hidden\" name=\"SELECTOLDSEAT\" value=\"$select_oldseat\">";
				echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
              	echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
              	echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
				echo "<input type=\"hidden\" name=\"NAME\" value=\"$name\">";
				echo "<input type=\"hidden\" name=\"TEL\" value=\"$tel\">";
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
      		<td width ="30%" align="center">
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

  				$dt = oci_parse($conn, "SELECT NO_TRAIN,DAY,MONTH,YEAR,STATION_BT,TYPE FROM TICKET_TRAIN WHERE NAME='$name' and TEL='$tel' ");
			    oci_execute($dt);
			    while ($h = oci_fetch_array($dt, OCI_ASSOC+OCI_RETURN_NULLS)) 
			    {
			        foreach ($h as $j => $k) 
			        {
			        	if($j == 'NO_TRAIN')
			        	{
			        		$select_oldtrain = $k;
			        	}
			        	else if($j == 'DAY')
			        	{
			        		$select_oldday = $k;
			        	}
			        	else if($j == 'MONTH')
			        	{
			        		$select_oldmonth = $k;
			        	}
			        	else if($j == 'YEAR')
			        	{
			        		$select_oldyear = $k;
			        	}
			        	else if($j == 'STATION_BT')
			        	{
			        		$select_oldbt = $k;
			        	}
			        	else if($j == 'TYPE')
			        	{
			        		$select_oldtype = $k;
			        	}
			            
			        }
			    }
   				$at = oci_parse($conn, "UPDATE TICKET_TRAIN SET NO_TRAIN='$select_train',TYPE='$select_type',STATION_BT ='$select_between',NO_BOGIE='$select_bogie',NO_SEAT='$select_seat[$x]',DAY = '$select_day',MONTH = '$select_month',YEAR = '$select_year' 
   					WHERE NO_TRAIN = '$select_oldtrain' and DAY = '$select_oldday' and MONTH = '$select_oldmonth' and YEAR = '$select_oldyear' and STATION_BT = '$select_oldbt' and NAME = '$name' and TEL = '$tel'");
			    oci_execute($at);

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


			    $bt = oci_parse($conn, "SELECT STATION_START,STATION_END FROM STATION_BETWEEN WHERE STATION_BT='$select_oldbt' and TYPE = '$select_oldtype' ");
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
			              			$at = oci_parse($conn, "UPDATE SEAT SET STATUS = 'n' WHERE NO_TRAIN = '$select_oldtrain' and TYPE = '$select_oldtype' and STATION_BT = '$k' and NO_BOGIE = '$select_oldbogie' and NO_SEAT = '$select_oldseat' and DAY ='$select_oldday' and MONTH ='$select_oldmonth' and YEAR ='$select_oldyear' ");
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
			              			$at = oci_parse($conn, "UPDATE SEAT SET STATUS = 'n' WHERE NO_TRAIN = '$select_oldtrain' and TYPE = '$select_oldtype' and STATION_BT = '$k' and NO_BOGIE = '$select_oldbogie' and NO_SEAT = '$select_oldseat' and DAY ='$select_oldday' and MONTH ='$select_oldmonth' and YEAR ='$select_oldyear' ");
			        				oci_execute($at); 
			        			}
			        		}

			            }	
			        } 
				}
				echo '<script>window.location = "mainseller.php";</script>'; 
			}
        }
      ?>
    </tbody>
  </table>
  
<div style="position: absolute; top: 100%; left: -20%; " align="center">
    

				
</div>				
				</div>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>  
</html>









