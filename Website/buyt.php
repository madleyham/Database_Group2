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
				<div class="container" style="position: absolute; top: 20px; " align="center">
					<form action='buyt.php' method='post'>
<table width ="30%"> 
<tbody>  
  <tr>
  	  <td width ="10%" align="center">
        <?php
			$import_train = trim($_POST['SELECTTRAIN']);
			$import_type = trim($_POST['SELECTTYPE']);
			$import_between = trim($_POST['SELECTBETWEEN']);
			echo "<br>No_Train : ".$import_train." : ".$import_type."<br><br>";
		?>
      </td> 
      <td width ="10%" align="center">
          Bogie
          <select name="bogie">
            <?php 
              $select_train = trim($_POST['SELECTTRAIN']);
              $select_type = trim($_POST['SELECTTYPE']);
              $select_between = trim($_POST['SELECTBETWEEN']);
              $select_day = trim($_POST['SELECTDAY']);
              $select_month = trim($_POST['SELECTMONTH']);
              $select_year = trim($_POST['SELECTYEAR']);
              $select_bogie = "SELECT * FROM BOGIE WHERE NO_TRAIN = '$select_train'";
              $tr = oci_parse($conn, $select_bogie);
              oci_execute($tr);
              while ($row = oci_fetch_array($tr, OCI_BOTH))
              {
                echo "<option value=\"".$row['NO_BOGIE']."\">". $row['NO_BOGIE'] ."</option>";
              }
              echo "<input type=\"hidden\" name=\"SELECTDAY\" value=\"$select_day\">";
              echo "<input type=\"hidden\" name=\"SELECTMONTH\" value=\"$select_month\">";
              echo "<input type=\"hidden\" name=\"SELECTYEAR\" value=\"$select_year\">";
              echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$select_train\">";
              echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$select_type\">";
              echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$select_between\">";
            ?>
          </select>
      </td>
      <td width ="10%" align="center">
        <input name='ct' type='submit' value='Check'>
      </td>          
  </tr>
</tbody> 
</table>  
</form>


<div align="center">
<form action='confirmt.php' method='post'>
  <table width ="30%">
    <tbody>
	<br>
      <?php 
        if(isset($_POST['ct']))
        {
          $select_day = trim($_POST['SELECTDAY']);
          $select_month = trim($_POST['SELECTMONTH']);
          $select_year = trim($_POST['SELECTYEAR']);
          echo $select_day.'/'.$select_month.'/'.$select_year;
          if(isset($_POST['bogie']))
          {
          	//echo "<br>No_Train : ".$import_train." : ".$import_type."<br><br>";

            $select_bogie = $_POST['bogie'];
            $s = oci_parse($conn, "SELECT NO_SEAT,STATUS FROM SEAT WHERE NO_BOGIE = '$select_bogie' and NO_TRAIN = '$select_train' and TYPE = '$select_type' and STATION_BT = '$select_between' and DAY = '$select_day' and MONTH = '$select_month' and YEAR = '$select_year'");
            oci_execute($s);
            //echo "Bogie :" .$b;
          }
          echo "<br><br><table border='1'>\n";
          echo "<tr width=\"30%\">\n";
          echo "<th width=\"50%\">No_SEAT</th>\n";
          echo "<th width=\"50%\">STATUS</th>\n";
          echo "</tr>\n";
          //echo '<input type="hidden" name="SELECTSEAT[0]" value="">';
          while ($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) 
          { 
            //echo "<form action='buy.php' method='post'>\n";
            echo "<tr>\n";
            //print_r($row);
            foreach ($row as $key => $item) 
            {
              if($key == "NO_SEAT")
              {
              	$no = $item;
              }
              if($key == "STATUS")
              {
              	if($item == "n")
              	{
              		echo "<td id=\"green\" width=\"10%\" bgcolor=\"#80FF00\">\n";
              		//echo "<input type=\"checkbox\" name=\"$no\" value=\"y\"></td>";
              		echo "<input name='SELECTSEAT[]' type='checkbox' value='$no'>";
              	}
              	else if($item == "y")
              	{
              		echo "<td id=\"red\" width=\"10%\" bgcolor=\"#FF7B00\">\n";
              	}
              }
              else
              {
              	echo "<td width=\"10%\">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
      		  }
            }
            echo "</tr>\n";
            //echo "</form>\n";
          }
          echo "</table>\n";
        }
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
          echo "<input type=\"hidden\" name=\"SELECTTRAIN\" value=\"$select_train\">";
          echo "<input type=\"hidden\" name=\"SELECTTYPE\" value=\"$select_type\">";
          echo "<input type=\"hidden\" name=\"SELECTBETWEEN\" value=\"$select_between\">";
          echo "<input type=\"hidden\" name=\"SELECTBOGIE\" value=\"$select_bogie\">";
      ?>
		<b>Name</b>
		<input name='NAME' type='input'>
		<b>Tel</b>
		<input name='TEL' type='input'>
    <b>No_Bogie</b>
    <input name='SELECTOLDBOGIE' type='input'>
    <b>No_Seat</b>
    <input name='SELECTOLDSEAT' type='input'><br><br>
		<input name='buy' type='submit' value='Buy'>
	</tr>
  </table>
</form>
		
<div style="position: absolute; top: 100%; left: -20%; " align="center">
    

				
</div>				
				</div>
			</div>
            <div class="footer"><br>
            	 
            </div>
        
    	</div>
	</body>  
</html>









