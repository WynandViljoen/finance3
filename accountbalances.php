<html>
<head>

<script language="javascript" type="text/javascript" src="datepicker.js"></script>

</head>

<style type="text/css" media="screen">

@import "datepicker.css";

body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:40%; font-size:12px;
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
tr{cursor: pointer; transition: all .25s ease-in-out}
            .selected{background-color: lightgreen; color: #000;}

<link rel="stylesheet" href="datepicker.css" type="text/css"/>
</style>

<?php
	include("header.html");
	include("dbcurrency.php");
	echo "<br><br><br>";


	if ((isset($_POST["submit"])))
	{
		$enddate = $_POST["EndDate"];
	}
	else if ((isset($_POST["reset"])))
	{
		$enddate = date("Y-m-d"); 
	}
	else
	{
		$enddate = date("Y-m-d"); 
	}

	$i = -1;
	
	echo "<div align=center>";
	echo "Account Balances (currently showing: $enddate)<br>";

	echo "<form method=\"post\">";
		echo "Date: ";
		echo "<input name=\"EndDate\" value=$enddate size=11 > ";
		echo "<img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('EndDate', false, 'ymd', '-');\"> ";
		echo " <input type=submit name=\"submit\" value=\"Submit\"> ";
		echo "<input type=submit name=\"reset\" value=\"Reset\">";
	echo "</form>";

	echo "<table id=\"table\" class=\"mytable\" border=1><th>Account</th><th>Balance</th>";
	$sql3 = "SELECT * FROM `accounttypes` ORDER BY `accounttype` DESC";
	if ($result3=mysqli_query($con,$sql3))
	while ($row3=mysqli_fetch_row($result3))
	{
		$counter = 0;
		$i += 1;
		$currentbalance[$i] = 0.00;
		echo "<tr><td colspan=3><b  style=\"font-size:14px;\">". $row3['0'] ." Balances</td></tr>";
		$type[$i] = $row3['0'];

		$sql = "SELECT * FROM `accounts` WHERE (`accounttype` = '" . $type[$i] ."')";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{

			$name = $row['0'];
			$balance = $row['2'];

			$sql2 = "SELECT SUM(`Amount`) FROM `transfers` WHERE ((`IntoAccount` = '" . $name ."') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance += $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `transfers` WHERE ((`FromAccount` = '" . $name ."') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance -= $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `txincome` WHERE ((`Account` = '" . $name ."') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance += $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `txexpense` WHERE ((`Account` = '" . $name ."') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance -= $row2['0'];
			} 

			$balance = number_format((float)$balance, 2, '.', '');
			$currentbalance[$i] += $balance;
			

			echo "<tr><td>$name</td><td align=right>$currencysymbol ". number_format((float)$balance, 2) ."</td></tr>";
			$counter += 1;
		}
		
	}
	
	echo "</table>";
	$networth = 0;

	echo "<p style=\"font-size:16px; color:green;\">";
	for ($a = 0; $a <= $i; $a ++)
	{
		echo $type[$a] ." Balances: $currencysymbol " . number_format((float)$currentbalance[$a], 2) . "<br>";
		$networth += $currentbalance[$a];

	}

	$currencysymbol2 = "";
	$networth2 = $networth;

	$sql = "SELECT `currency2`, `ROE` FROM `currency`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$currencysymbol2 = $row['0'];
		$networth2 = number_format($networth2 * $row['1'], 2);;
	}
	
		$networth = number_format((float)$networth, 2);
		echo "</p><p style=\"font-size:20px; color:green;\"><b><br>Net Worth: $currencysymbol $networth";
		if ($currencysymbol2 != "")
			echo " ($currencysymbol2 $networth2)";
		echo "</p>";

		echo "</div>";
?>

<script>
            
            function selectedRow()
            {
                
                var index,
                    table = document.getElementById("table");
            
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                       // if(typeof index !== "undefined")
                      //  {
                      //     table.rows[index].classList.toggle("selected");
                     //   }
                        console.log(typeof index);
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected");
                        console.log(typeof index);
                     };
                }
                
            }

            selectedRow();
        </script>

</html>

