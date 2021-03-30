<html>
<head>

<script type="text/javascript" src="tablefilter_all_min.js"></script>
<script language="javascript" type="text/javascript" src="datepicker.js"></script>

</head>

<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "filtergrid2.css";
@import "datepicker.css";

/*====================================================
	- General html elements
=====================================================*/

body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
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
	
	echo "<div align=center>";
	echo "<br>All Recorded log files:</a><br>";
	echo "</div>";

	$mydate = date("Y-m"); 

	$sql = "SELECT * FROM `mylogs` ORDER BY `id` DESC";
	echo "<table align=center id=\"table2\" class=\"mytable\" border=1><th>Action Taken</th><th>Table Name</th><th>Date</th><th>Info</th>";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		echo "<tr><td style=\"width:10%;\">" . $row['1'] . " </td><td style=\"width:10%;\"> " . $row['2'] . " </td><td align=right  style=\"width:15%;\"> " . $row['3'] . " </td><td  style=\"width:65%;\"> " . $row['4'] . " </td>";
	}
	echo "</table>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table2_Props = 	{ 
							rows_counter: true, 
		                    btn_reset: true,  
		                    loader: true,  
		                    loader_text: "Filtering data...", 
		                    col_0: "select",
							col_1: "select", 								
							display_all_text: " [ Show all ] ",
							sort_select: true, 
							alternate_rows: true,
							rows_counter_text: "Total rows: "
						};
var tf2 = 	setFilterGrid( "table2",table2_Props );
//]]>


</script>