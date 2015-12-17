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
				
				
				<div class="container" style="position: absolute; top: 20px; left: 20px;" align="center">
				
				<b>ส่งสินค้า</b><br><br>
					
					<div align="center">
<form action='selectp.php' method='post'>
<table width ="30%"> 
<tbody>  
  <tr>
      <td width="10%">
          Start
          <select name="station_start">
            <?php 
              $select = "SELECT * FROM STATION";
              $tran = oci_parse($conn, $select);
              oci_execute($tran);
              while ($row = oci_fetch_array($tran, OCI_BOTH))
              {
                echo "<option value=\"".$row['STATION_NAME']."\">". $row['STATION_NAME'] ."</option>";
              }
            ?>
          </select>
      </td>
      <td width="10%">
          End
          <select name="station_end">
            <?php 
              $select = "SELECT * FROM STATION";
              $tran = oci_parse($conn, $select);
              oci_execute($tran);
              while ($row = oci_fetch_array($tran, OCI_BOTH))
              {
                echo "<option value=\"".$row['STATION_NAME']."\">". $row['STATION_NAME'] ."</option>";
              }
            ?>
          </select>
      </td>
	  <td width="10%">
		Day &nbsp;&nbsp;&nbsp; <input name='SELECTDAY' type='input' size=5><br>
		Month <input name='SELECTMONTH' type='input' size=5><br>
		Year &nbsp;&nbsp; <input name='SELECTYEAR' type='input' size=5>
	  </td> 
	  
      <td width="10%">
        <button type="submit" name='ct' >Check</button>
      </td>          
  </tr>
</tbody> 
</table>  
</form>
</div>
<div align="center">
  <table width ="30%">
    <tbody>
      <?php 
        if(isset($_POST['ct']))
        {
          if(isset($_POST['station_start']) && isset($_POST['station_end']) && isset($_POST['SELECTDAY']) && isset($_POST['SELECTMONTH']) && isset($_POST['SELECTYEAR']))
          {
            $select_day = $_POST['SELECTDAY'];
            $select_month = $_POST['SELECTMONTH'];
            $select_year = $_POST['SELECTYEAR'];
            $start = $_POST['station_start'];
            $end = $_POST['station_end'];
            if($start == $end)
            {
              echo '<script>window.location = "selectp.php";</script>'; 
            }
            $bt = oci_parse($conn, "SELECT STATION_BT FROM STATION_BETWEEN WHERE STATION_START='$start' and STATION_END='$end'");
            oci_execute($bt);
            while ($row = oci_fetch_array($bt, OCI_ASSOC+OCI_RETURN_NULLS)) 
            {
              foreach ($row as $key => $item) 
              {
                $bts = $item;
              }
            }
            $stid = oci_parse($conn, "SELECT * FROM TIME_TRAIN WHERE STATION_BT ='$bts' and DAY = '$select_day' and MONTH = '$select_month' and YEAR = '$select_year'");
            oci_execute($stid);
			echo "<br>";
            echo "<b>START : </b>" .$start;
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo " <b>END : </b>" .$end; 
			echo "<br>";
          }
		  echo "<br>";
          echo "<table border='1'>\n";
          echo "<tr width=\"30%\">\n";
          echo "<th width=\"10%\">No</th>\n";
          echo "<th width=\"10%\">Start</th>\n";
          echo "<th width=\"10%\">End</th>\n";
		  echo "<th width=\"10%\">Weight</th>\n";
          echo "<th width=\"10%\">STATUS</th>\n";
          echo "</tr>\n";
          while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
          { 
            echo "<form action='buyp.php' method='post'>\n";
            echo "<tr>\n";
            //print_r($row);
            foreach ($row as $key => $item) 
            {
              if($key == "NO_TRAIN")
              {
                $SELECT_TRAIN = $item;
                echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
              }
              else if($key == "TYPE")
              {
                $SELECT_TYPE = $item;
              }
              else if($key == "STATION_BT")
              {
                $SELECT_BT = $item;
                $bw = oci_parse($conn, "SELECT WEIGHT FROM SEAT_PRODUCT WHERE NO_TRAIN ='$SELECT_TRAIN' and STATION_BT = '$SELECT_BT' and TYPE ='$SELECT_TYPE'");
                oci_execute($bw);
                while ($r = oci_fetch_array($bw, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                  foreach ($r as $k => $i) 
                  {
                    $SELECT_SUM = $i;
                    echo "<td width=\"10%\">" . ($i !== null ? htmlentities($i, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                  }
                }
              }
			  else if($key == "DAY" || $key == "MONTH" || $key == "YEAR")
              {

              }
              else
              {
                echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
              }  
            }
            echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
            echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
            echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
            echo "<input type=\"hidden\" name=\"SELECTSUMWEIGHT\" value=\"$SELECT_SUM\">";
            echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$SELECT_TRAIN\">";
            echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$SELECT_TYPE\">";
            echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$SELECT_BT\">";
            echo "<td width=\"10%\"><input name='gotobuy' type='submit' value='Go'></td>\n";
            echo "</tr>\n";
            echo "</form>\n";
          }
          echo "</table>\n";
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
