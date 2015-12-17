<?PHP
	include 'include.php';
	$id = $_SESSION['ID'];
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
				<div class="container" style="position: absolute; top: 10px; left: 33%; " align="center">
					
					<form action='expend.php' method='post'>
					<b>รายจ่าย</b><br><br>
	
					เลือกดูรายการ
					<select  name="list" >
					<option value="all" >ดูทั้งหมด</option>
					<option value="careline" >careline</option>
					<option value="maintain" >maintain</option>
					<option value="traincost" >triancost</option>
					</select><br>
					เลือกดูแบบ
					<input name= "show1" type="radio" id="radio2" value="month" />รายเดือน
					<input name= "show1" type="radio" id="radio2" value="year"  />รายปี
					<input name= "show1" type="radio" id="radio2" value="all" checked = "on"/>รายจ่ายทั้งหมด
	
					<br><input name='submit2' type='submit' value='submit'><br><br>
					</form>
					<div style="position: absolute; top: 90%; " align="center">

<?PHP
if(isset($_POST['submit2'])){
		$showdate = trim($_POST['show1']);//ตัดเอาเวลาแบบไหน เดือน ปี หรือทั้งหมด	
		$list = trim($_POST['list']);//ตัดเอาว่าจะดู คอลัมล์ไหน มี ค่าบำรุงรถไฟ ค่าบำรุงราง ค่ารถไฟต่อเที่ยว
		//เช็คว่า ค่าไม่เป็น null
		if($showdate != "" && $list != ""){	
			if($list == "careline")//ถ้าเลือกเป็น ค่าบำรุงราง ก็จะมี เลือกดูแบบ (เดือน ปี ทั้งหมดตาราง)
			{
				//เลือกดูค่าบำรุงรักษาแบบรายเดือน
				if($showdate == "month"){
						 $query = "SELECT NMONTH,sum(CARLINE) 
									FROM AA_EXPEND 
									group by NMONTH 
									order by NMONTH";				  
				}else{
				//เลือกดูค่าบำรุงรักษาแบบรายปี	
				if($showdate == "year"){
						$query = "SELECT YEAR,sum(CARLINE) 
									FROM AA_EXPEND 
									group by YEAR 
									order by YEAR";
					}else{
						//เลือกดูค่าบำรุงรักษาแบบ ทั้งหมดตาราง
						if($showdate == "all"){
						$query = "SELECT sum(CARLINE) FROM AA_EXPEND ";
						}
					}
				}
				
			}
			else{
				if($list == "maintain")//ถ้าเลือกเป็น ค่าบำรุงรถไฟ ก็จะมี เลือกดูแบบ (เดือน ปี ทั้งหมดตาราง)
				{
					//เลือกดูค่าบำรุงรถๆฟาแบบรายเดือน
					if($showdate == "month"){
						  $query = "SELECT NMONTH,sum(MAINTAIN) 
									FROM AA_EXPEND 
									group by NMONTH 
									order by NMONTH";
						  
				}else{
					//เลือกดูค่าบำรุงรถๆฟาแบบรายปี
					if($showdate == "year"){
						$query = "SELECT YEAR,sum(MAINTAIN) 
									FROM AA_EXPEND 
									group by YEAR 
									order by YEAR";
					}else{
						//เลือกดูค่าบำรุงรถไฟแบบทั้งหมดตารางเฉพาะค่าบำรุงรถไฟ
						if($showdate == "all"){
						$query = "SELECT sum(MAINTAIN) FROM AA_EXPEND ";
						}
					}
				}
				
				}
				else{
					if($list == "traincost")//ถ้าเลือกเป็น ค่าเดินทางต่อเที่ยว  ก็จะมี เลือกดูแบบ (เดือน ปี ทั้งหมดตาราง)
					{
						//เลือกดูค่าเดินทางรถไฟต่อเที่ยวแบบรายเดือน
						if($showdate == "month"){
						  $query = "SELECT NMONTH,sum(TRAINCOST) 
									FROM AA_EXPEND 
									group by NMONTH 
									order by NMONTH";
						}else{
						//เลือกดูค่าเดินทางรถไฟต่อเที่ยวแบบรายปี	
						if($showdate == "year"){
						$query = "SELECT YEAR,sum(TRAINCOST) 
									FROM AA_EXPEND 
									group by YEAR 
									order by YEAR";
						}else{
							//เลือกดูค่ารถไฟต่อเที่ยว แบบทั้งหมดตารางเฉพาะค่าเดินทางต่อเที่ยว
							if($showdate == "all"){
								$query = "SELECT sum(TRAINCOST) FROM AA_EXPEND ";
								}
							}
						}
				
					}else{ 
						//list == all(ดูทั้งหมด)
						//เลือกดูยอดรวมทั้งหมดแบบเดือน
						if($showdate == "month"){
						  $query = "SELECT NMONTH,sum(CARLINE),sum(MAINTAIN),sum(TRAINCOST) 
							FROM AA_EXPEND 
							group by NMONTH 
							order by NMONTH";
							}else{
								//เลือกดูยอดรวมทั้งหมดแบบปี
								if($showdate == "year"){
									$query = "SELECT YEAR,sum(CARLINE),sum(MAINTAIN),sum(TRAINCOST) 
									FROM AA_EXPEND 
									group by YEAR 
									order by YEAR";
									}else{
										//เลือกดูยอดรวมทั้งหมด
										if($showdate == "all"){
											$query = "SELECT sum(CARLINE)+sum(MAINTAIN)+sum(TRAINCOST) 
											FROM AA_EXPEND ";
										}
									}
								}
					  }
				}
			}
		}
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
					//แสดงรายรับรายเดือน
					if($showdate == "month"){	
					
					if($list =="careline"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Careline</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "NMONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(CARLINE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
						
					if($list =="maintain"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Maintain</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "NMONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(MAINTAIN)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					
					if($list =="traincost"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Traincost</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "NMONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TRAINCOST)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					
					if($list =="all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Month</td>\n";
					echo "<th width=\"10%\">Careline</td>\n";
					echo "<th width=\"10%\">Maintain</td>\n";
					echo "<th width=\"10%\">Traincost</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "NMONTH")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(CARLINE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(MAINTAIN)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TRAINCOST)")
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
					
					if($list =="careline"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Careline</td>\n";
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
							else if($key == "SUM(CARLINE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
						
					if($list =="maintain"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Maintain</td>\n";
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
							else if($key == "SUM(MAINTAIN)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}	
					
					
					if($list =="traincost"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">Toatal-Cost Traincost</td>\n";
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
							else if($key == "SUM(TRAINCOST)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					

					if($list =="all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Year</td>\n";
					echo "<th width=\"10%\">Careline</td>\n";
					echo "<th width=\"10%\">Maintain</td>\n";
					echo "<th width=\"10%\">Traincost</td>\n";
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
							else if($key == "SUM(CARLINE)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(MAINTAIN)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							else if($key == "SUM(TRAINCOST)")
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
					
					if($list =="careline"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Toatal-Cost Careline</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(CARLINE)")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					
					if($list =="maintain"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Toatal-Cost Maintain</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(MAINTAIN)")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					
					if($list =="traincost"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Toatal-Cost Traincost</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(TRAINCOST)")
							{	
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
              
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";
					}
					
					
					if($list =="all"){
					echo "<table border='1' >\n";
					echo "<tr width=\"10%\">\n";
					echo "<th width=\"10%\">Toatal-Cost All</td>\n";
					echo "</tr>\n";
					while ($row = oci_fetch_array($parseRequest, OCI_ASSOC+OCI_RETURN_NULLS)) 
					{ 
						
						echo "<tr>\n";
           
						foreach ($row as $key => $item) 
						{
							if($key == "SUM(CARLINE)+SUM(MAINTAIN)+SUM(TRAINCOST)")
							{
							echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}         
						}
						echo "</tr>\n";	
					}
					echo "</table>\n";	
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
		</div>
	</body>  
</html>






