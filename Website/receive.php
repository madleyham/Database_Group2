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
			 Manager	
			</div>
          	<div class="select" ><br>
                <a href="mgrchangepass.php">Change Password</a> |
            	<a href="logout.php">Logout</a>  <br><br>              	 
          	</div>
          	<div class="select2" ><br>
                <a href="mainmgr.php">หน้าแรก</a> |
            	<a href="expend.php">ดูรายจ่าย</a> |
            	<a href="receive.php">ดูรายรับ</a><br><br>              	 
          	</div>
			<div id="slideshow">
                <a><img src="images/index.jpg"></a>
				<div class="container" style="position: absolute; top: 10px; left: 30%; " align="center">
					
					<form action='receive.php' method='post'>
	<b>รายรับ</b><br>
	<br>เลือกดูแบบ<br>
	<input name= "show1" type="radio" id="radio1" value="day" />รายวัน
	<input name= "show1" type="radio" id="radio1" value="month" />รายเดือน
	<input name= "show1" type="radio" id="radio1" value="year"  />รายปี
	<input name= "show1" type="radio" id="radio1" value="all"  checked="on"/>รายรับทั้งหมด
	<br>เลือกดูจาก<br>
	<input name= "show2" type="radio" id="radio2" value="passenger" />เฉพาะค่าตั๋วโดยสาร
	<input name= "show2" type="radio" id="radio2" value="cargo" />เฉพาะค่าตั๋วสินค้า
	<input name= "show2" type="radio" id="radio2" value="all" checked="checked"  />ค่าตั๋วทั้งหมด
	<br><br><input name='submit2' type='submit' value='submit'><br><br>
</form>
<div style="position: absolute; top: 100%; " align="center">

<?PHP
	if(isset($_POST['submit2'])){
		$showdate = trim($_POST['show1']);	//เลือกดูรายรับแบบไหน (วัน  เดือน   ปี  หรือ ทั้งหมดที่มีมา)
		$showtype = trim($_POST['show2']);  //เลือกดูรายรับแบบไหน (เฉพาะค่าตั๋วโดยสาร ค่าตั๋วสินค้า หรือ ทั้งหมดที่มีมา)
		//เช็คว่า ค่าไม่เป็น null
		if($showdate != "" && $showtype != ""){	
			// ถ้าเลือกดูแบบ ( ปี) ก็มีจะให้เลือกว่าจะดูจากอะไร (จากตั๋วสินค้า ตั็วผู้โดยสาร หรือทั้งหมด)
			if($showdate == "day"){	
				//ดูรายรับจากผู้โดยสาร แบบ รายวัน
				if($showtype == "passenger"){	  
						  $query = "SELECT DAY,SUM(TIGKET_PRICE) 
						  FROM AA_TIGKET 
						  where TYPE = 'PSG'
						  group by DAY
						  order by DAY";
					}else{
						//ดูรายรับจากผตั๋วสินค้า แบบ รายวัน
						if($showtype == "cargo"){
							$query = "SELECT DAY,SUM(TIGKET_PRICE) 
							FROM AA_TIGKET 
							where TYPE = 'CG'
							group by DAY
							order by DAY";
						}
						//ดูรายรับทั้งหมด แบบ รายวัน
						else{
							$query = "SELECT DAY,SUM(TIGKET_PRICE) 
							FROM AA_TIGKET 
							group by DAY
							order by DAY";
						}
				}
			}
			// ถ้าเลือกดูแบบ ( เดือน) ก็มีจะให้เลือกว่าจะดูจากอะไร (จากตั๋วสินค้า ตั็วผู้โดยสาร หรือทั้งหมด
			if($showdate == "month"){
				//ดูรายรับจากผู้โดยสาร แบบ รายเดือน
			    if($showtype == "passenger"){	  
						  $query = "SELECT MONTH,SUM(TIGKET_PRICE) 
						  FROM AA_TIGKET
						  where TYPE = 'PSG'
						  group by MONTH 
						  order by to_date(MONTH,'MM')";}
					else{
						//ดูรายรับจากผตั๋วสินค้าแบบ รายเดือน
						if($showtype == "cargo"){
							 $query = "SELECT MONTH,SUM(TIGKET_PRICE) 
							FROM AA_TIGKET
							where TYPE = 'CG'
							group by MONTH 
							order by to_date(MONTH,'MM')";
						}
						//ดูรายรับทั้งหมด แบบ รายเดือน
						else{
								$query = "SELECT MONTH,SUM(TIGKET_PRICE) 
								FROM AA_TIGKET
								group by MONTH 
								order by to_date(MONTH,'MM')";}
						}
			}
			// ถ้าเลือกดูแบบ ( ปี) ก็มีจะให้เลือกว่าจะดูจากอะไร (จากตั๋วสินค้า ตั็วผู้โดยสาร หรือทั้งหมด
			if($showdate == "year"){
				//ดูรายรับจากผู้โดยสาร แบบ รายปี
			    if($showtype == "passenger"){	  
						  $query = "SELECT YEAR,SUM(TIGKET_PRICE) 
						  FROM AA_TIGKET
						  where TYPE = 'PSG'
						  group by YEAR 
						  order by YEAR";
				
					}
					//ดูรายรับจากตั๋วสินค้า แบบ รายปี
					else{
						if($showtype == "cargo"){
							$query = "SELECT YEAR,SUM(TIGKET_PRICE) 
							FROM AA_TIGKET
							Where TYPE = 'CG'
							group by YEAR
							order by YEAR";
							}
							//ดูรายรับทั้งหมด แบบ รายปี
							else{
								$query = "SELECT YEAR,SUM(TIGKET_PRICE) 
								FROM AA_TIGKET
								group by YEAR 
								order by YEAR";}
						}
			}
			//เลือกดูรายรับทั้งหมด
			if($showdate == "all"){
			    //เลือกดูรายรับทั้งหมดที่ผ่านมา เฉพาะค่าตั๋วโดยสาร
				if($showtype == "passenger"){	  
						  $query = "SELECT SUM(TIGKET_PRICE) 
						  FROM AA_TIGKET
						  where TYPE = 'PSG' ";
				
					}
					//เลือกดูรายรับทั้งหมดที่ผ่านมา เฉพาะค่าตั๋วสินค้า
					else{
						if($showtype == "cargo"){
							$query = "SELECT SUM(TIGKET_PRICE) 
							FROM AA_TIGKET
							Where TYPE = 'CG'";
							}
							//เลือกดูรายรับทั้งหมดที่ผ่านมา 
							else{
								$query = "SELECT SUM(TIGKET_PRICE)
								FROM AA_TIGKET ";}
						}
		
			}
			
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);			
					//แสดงรายรับเป็นรายวัน
					if($showdate == "day"){
					
					if($showtype == "passenger"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">DAY</td>\n";
					echo "<th width=\"10%\">PassengerTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "DAY")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";					
					}
					
					if($showtype == "cargo"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">DAY</td>\n";
					echo "<th width=\"10%\">CargoTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "DAY")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";					
					}
					
					if($showtype == "all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">DAY</td>\n";
					echo "<th width=\"10%\">Total-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "DAY")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";					
					}
					
					}
					// แสดงรายรับรายเดือน
					if($showdate == "month"){
					
					if($showtype == "passenger"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">PassengerTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "MONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "cargo"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">CargoTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "MONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">Total-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "MONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					}
					
					//แสดงรายรับรายปี
					if($showdate == "year"){
					
					if($showtype == "passenger"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">PassengerTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "YEAR")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "cargo"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">CargoTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "YEAR")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">Total-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "YEAR")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					}
					
					//แสดงรายรับทั้งหมด
					if($showdate == "all"){
					
					if($showtype == "passenger"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Total-PassengerTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "cargo"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Total-CargoTicket-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					if($showtype == "all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Total-Price</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 						
						echo "<tr>\n";          
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(TIGKET_PRICE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}             
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					}
	}
	};
	oci_close($conn);	
?>
					
				</div>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>  
</html>

