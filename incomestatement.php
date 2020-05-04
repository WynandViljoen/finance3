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
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
.mastertable{
	width:70%; font-size:12px;
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
		$startdate= $_POST["StartDate"];
		$enddate = $_POST["EndDate"];
	}
	else if ((isset($_POST["reset"])))
	{
		$startdate = date("Y-m-01");
		$enddate = date("Y-m-t"); 
	}
	else
	{
		$startdate = date("Y-m-01");
		$enddate = date("Y-m-t"); 
	}
	
	echo "<table align=center class=\"mastertable\" border=1><tr><td>";
	echo "<table id=\"table\" align=center  class=\"mytable\" border=1>";

	echo "<form method=\"post\">";
		echo "<th colspan=2>Income Statement</th>";
		echo "<tr><td align=right>From: </td>";
		echo "<td><input name=\"StartDate\" value=$startdate size=11> ";
		echo "<img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('StartDate', false, 'ymd', '-');\"> ";	
		echo "<tr><td align=right>To: </td>";
		echo "<td><input name=\"EndDate\" value=$enddate  size=11> ";
		echo "<img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('EndDate', false, 'ymd', '-');\"> ";	
		echo "<tr><td></td><td><input type=submit name=\"submit\" value=\"Submit\"> ";
		echo "<input type=submit name=\"reset\" value=\"Reset\"></td></tr>";
	echo "</form>";

	echo "<tr><td colspan=2 align=center><b>Showing $startdate to $enddate</td></tr>";
	
	echo "<tr><td>Total Income: </td>";
	$incomeTotal = 0;
	$sql = "SELECT SUM(`Amount`) FROM `txincome` WHERE ((`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$incomeTotal += $row['0'];
	}
	$incomeTotal = number_format((float)$incomeTotal, 2, '.', '');
	echo "<td align=right><b>$currencysymbol ". number_format((float)$incomeTotal, 2) ." </td></tr>";
	
	echo "<tr><td>Total Expense: </td>";
	$expenseTotal = 0;
	$sql = "SELECT SUM(`Amount`) FROM `txexpense` WHERE ((`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$expenseTotal += $row['0'];
	}
	$expenseTotal = number_format((float)$expenseTotal, 2, '.', '');
	echo "<td align=right><b>$currencysymbol ". number_format((float)$expenseTotal, 2) ." </td></tr>";
	
	echo "<tr><td>Net Profit / Loss: </td>";
	$profit = $incomeTotal - $expenseTotal;
	echo "<td align=right><b>$currencysymbol ". number_format((float)$profit, 2) ." </td></tr>";
	

	$sql = "SELECT * FROM `expenses`";
	echo "<th>Expense</th><th>Amount</th>";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$expenseTotal = 0;
		$expenseId = $row['0'];
		$sql2 = "SELECT SUM(`Amount`) FROM `txexpense` WHERE ((`Expense` = '" . $expenseId ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
		if ($result2=mysqli_query($con,$sql2))
		while ($row2=mysqli_fetch_row($result2))
		{
			$expenseTotal += $row2['0'];
		}
		$expenseTotal = number_format((float)$expenseTotal, 2, '.', '');
		echo "<tr><td>". $row['0'] ."</td><td align=right>$currencysymbol ". number_format((float)$expenseTotal, 2) ."</td></tr>"; 		
	}
	echo "</table></td>";


	echo "<td valign=top><table id=\"table2\" align=center class=\"mytable\"  border=1>";

	$sql = "SELECT * FROM `incomes`";
	echo "<th>Income</th><th>Amount</th>";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$incomeTotal = 0;
		$incomeId = $row['0'];
		$sql2 = "SELECT SUM(`Amount`) FROM `txincome` WHERE ((`Income` = '" . $incomeId ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
		if ($result2=mysqli_query($con,$sql2))
		while ($row2=mysqli_fetch_row($result2))
		{
			$incomeTotal += $row2['0'];
		}
		$incomeTotal = number_format((float)$incomeTotal, 2, '.', '');
		echo "<tr><td>". $row['0'] ."</td><td align=right>$currencysymbol ". number_format((float)$incomeTotal, 2) ."</td></tr>"; 		
	}

	$i = -1;
	echo "<th>Account</th><th>Balance</th>";
	$sql3 = "SELECT * FROM `accounttypes` ORDER BY `accounttype` DESC";
	if ($result3=mysqli_query($con,$sql3))
	while ($row3=mysqli_fetch_row($result3))
	{
		$counter = 0;
		$i += 1;
		$currentbalance[$i] = 0.00;
		echo "<tr><td colspan=2><b  style=\"font-size:14px;\">". $row3['0'] ." Balances</td></tr>";
		$type[$i] = $row3['0'];

		$sql = "SELECT * FROM `accounts` WHERE (`accounttype` = '" . $type[$i] ."')";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{

			$name = $row['0'];
			$balance = 0;

			$sql2 = "SELECT SUM(`Amount`) FROM `transfers` WHERE ((`IntoAccount` = '" . $name ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance += $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `transfers` WHERE ((`FromAccount` = '" . $name ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance -= $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `txincome` WHERE ((`Account` = '" . $name ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
			{
				$balance += $row2['0'];
			} 

			$sql2 = "SELECT SUM(`Amount`) FROM `txexpense` WHERE ((`Account` = '" . $name ."') AND (`Date` >= '" . $startdate . "') AND (`Date` <= '" . $enddate . "'))";
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
	
	echo "</td></table>";
	
	echo "</table>";

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

            function selectedRow2()
            {
                
                var index2,
                    table2 = document.getElementById("table2");
            
                for(var i = 1; i < table2.rows.length; i++)
                {
                    table2.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                       // if(typeof index !== "undefined")
                      //  {
                      //     table.rows[index].classList.toggle("selected");
                     //   }
                        console.log(typeof index2);
                        // get the selected row index
                        index2 = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected");
                        console.log(typeof index2);
                     };
                }
                
            }

            selectedRow();
            selectedRow2();
        </script>

</html>