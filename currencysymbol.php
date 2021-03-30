<html>
<head>

</head>

<style type="text/css" media="screen">


body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:50%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }

th{
	background-color:#7595e1; 
	border-bottom:1px solid #D0D0D0; border-right:1px solid #D0D0D0;
	border-left:1px solid #fff; border-top:1px solid #fff;
	padding:5px 5px 5px 5px; color:#333;
}


</style>

<?php
	include("header.html");
	include("dbcurrency.php");
	echo "<br><br><br>";
	
	$mydate = date("Y-m");
	$mydatet = date("Y-m-t"); 

	echo "<div align=center>";
	echo "<br><b>Change the currency Symbol(s) and Rate of exchange<br>";
	echo "</div>";

	$sql = "SELECT * FROM `currency`";
	echo "<table align=center class=\"mytable\" border=1><th>Currency 1 Symbol</th><th>Currency 2 Symbol</th><th>Rate of Exchange</th><th>Primary timezone</th><th>Submit</th>";
	$result=mysqli_query($con,$sql);
	
	$row = mysqli_fetch_row($result);
	if (mysqli_num_rows($result) == 0)
	{
		//echo "<br>There is nothing in the table!<br>";
		$row['0'] = "";
		$row['1'] = "";
		$row['2'] = "";
		$row['3'] = "";
	}	

	echo "<form method=\"post\">";
		echo "<tr><td><input type=\"text\" name=\"currency1\" value=\"" . $row['0'] . "\"></td>";
		echo "<td><input type=\"text\" name=\"currency2\" value=\"" . $row['1'] . "\"></td>";
		echo "<td><input type=\"text\" name=\"ROE\" value=\"" . $row['2'] . "\"></td>";

		echo "<td><select id=\"timezone\" name=\"timezone\">";
			echo "<option value=\"America/Vancouver\">America/Vancouver</option>";
			echo "<option value=\"Africa/Johannesburg\">Africa/Johannesburg</option>";
			echo "<option selected value=\"" . $row['3'] ."\">" . $row['3'] . "</option>";
		echo "</select></td>";


		echo "<td align=center style=\"width:5%;\">";
		echo "<input type=\"submit\" name=\"submit\" value=\"submit\"></td></tr>";
	echo "</form>";

	echo "</table>";


	if (isset($_POST["submit"]))
	{
		$currency1 = $_POST['currency1'];
		$currency2 = $_POST['currency2'];
		$ROE = $_POST['ROE'];
		$timezone = $_POST['timezone'];

		if (($ROE == "") OR ($ROE == "0"))
			$ROE = 1;


		//echo "currency1: " . $currency1 . ", currency2: " . $currency2 . ", ROE: " . $ROE . "<br>";

		$sql = "DELETE FROM `currency` WHERE 1";
		$result=mysqli_query($con,$sql);

		$sql = "INSERT INTO `currency` (`currency1`, `currency2`, `ROE`, `timezone`) VALUES ('$currency1','$currency2',$ROE, '$timezone')";
		if ($result=mysqli_query($con,$sql))
		{
			$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['currency1'] . ", ". $_POST['currency2'] . ", ". $ROE  . ", ". $timezone;
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'currency', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);

		    echo "Currency Table has the following entries: " . $_POST['currency1'] . ", " . $_POST['currency2'] .", " . $_POST['ROE'];
		}
		else
			echo "Operation failed";

		echo "<br><br><br>";
		echo "<br>Click <a href=\"currencysymbol.php\">HERE </a> to reload this page.";
	}

?>
