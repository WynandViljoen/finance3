<?php

	include("dbcurrency.php");

	if ((isset($_POST["submit"])))
	{
		$startdate= $_POST["StartDate"];
		$enddate = $_POST["EndDate"];
		$startYear = date("Y", mktime (0,0,0,1,1,substr($startdate,0,4)));
		$startMonth = date("m", mktime (0,0,0,substr($startdate,5,2),1,2019));
		$endYear = date("Y", mktime (0,0,0,1,1,substr($enddate,0,4)));
		$endMonth = date("m", mktime (0,0,0,substr($enddate,5,2),1,2019));
	}
	else 
	{
		$startdate = mktime(0,0,0,1,1,2019);
		$enddate = date("Y-m-d"); 
		$startYear = (int)date("Y", $startdate);
		$startMonth = date("m", $startdate);
		$endYear = date("Y");
		$endMonth = date("m") - 1;
		$startdate = date("Y-m-d", $startdate);
	}
	
	echo "<br><br><br><form method=\"post\">";
	echo "<tr><td><table border=1 align =center >";
	echo "<tr><td align=right>From: </td>";
	echo "<td><input name=\"StartDate\" value=$startdate size=11> ";
	echo "<img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('StartDate', false, 'ymd', '-');\"> ";

	echo "<tr><td align=right>To: </td>";
	echo "<td><input name=\"EndDate\" value=$enddate  size=11> ";
	echo "<img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('EndDate', false, 'ymd', '-');\"> ";	
	echo "<tr><td></td><td><input type=submit name=\"submit\" value=\"Submit\"> ";
	echo "<input type=submit name=\"reset\" value=\"Reset\"></td></tr>";
	echo "</table>";
	echo "</form><br><br>";

	$counter = ($endYear - $startYear)*12 + ($endMonth);

?>