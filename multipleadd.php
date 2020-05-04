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

	$today = date("Y-m-d");

	echo "<div align=center>";
	echo "<br><b>Add new expense transaction(s)<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Description</th><th>Date</th><th>Amount</th><th>Expense</th><th>Account</th><th>Create</th>";

	echo "<form method=\"post\">";
	for ($i=0; $i < 20; $i++)
	{
		echo "<tr><td style=\"width:26%;\"><input style=\"width:100%;\" name=\"description$i\" placeholder=\"Transaction description\" size=60 </td>";
		echo "<td style=\"width:16%;\" align=center><input name=\"EndDate$i\" value=$today size=10>";

		echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('EndDate$i', false, 'ymd', '-');\"></td>";	

		echo "<td style=\"width:16%;\"><input style=\"width:100%;\" name=\"amount$i\" placeholder=\"Amount without $currencysymbol \" size=60 </td>";

		
		echo "<td style=\"width:16%;\"><select id=\"expense$i\" name=\"expense$i\">";
		$sql = "SELECT `Expense` FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";


		echo "<td style=\"width:16%;\"><select id=\"Account$i\" name=\"Account$i\">";
		$sql = "SELECT `Account` FROM `accounts` ORDER BY `accounttype` DESC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		if ($i == 0)
			echo "<td rowspan=20 style=\"width:8%;\" align=center><input type=submit name=\"submitExpense\" value=\"Create\"></td>";
		echo "</tr>";
	}
	echo "</form>";
	echo "</table><br>";


	echo "<div align=center>";
	echo "<br><b>Add new income transaction(s)<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Description</th><th>Date</th><th>Amount</th><th>Account</th><th>Income</th><th>Create</th>";

	echo "<form method=\"post\">";
	for ($i=0; $i < 8; $i++)
	{
		echo "<tr><td style=\"width:26%;\"><input style=\"width:100%;\" name=\"description$i\" placeholder=\"Transaction description\" size=60 </td>";
		echo "<td style=\"width:16%;\" align=center><input name=\"IncomeDate$i\" value=$today size=10>";

		echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('IncomeDate$i', false, 'ymd', '-');\"></td>";	

		echo "<td style=\"width:16%;\"><input style=\"width:100%;\" name=\"amount$i\" placeholder=\"Amount without $currencysymbol \" size=60 </td>";

		echo "<td style=\"width:16%;\"><select id=\"Account$i\" name=\"Account$i\">";
		$sql = "SELECT `Account` FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		echo "<td style=\"width:16%;\"><select id=\"Income$i\" name=\"Income$i\">";
		$sql = "SELECT `Income` FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		if ($i == 0)
			echo "<td rowspan=8 style=\"width:8%;\" align=center><input type=submit name=\"submitIncome\" value=\"Create\"></td>";
		echo "</tr>";
	}
	echo "</form>";
	echo "</table><br>";


	echo "<div align=center>";
	echo "<br><b>Add new transfer transaction(s)<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Description</th><th>Date</th><th>Amount</th><th>Into</th><th>From</th><th>Create</th>";

	echo "<form method=\"post\">";
	for ($i=0; $i < 8; $i++)
	{
		echo "<tr><td style=\"width:26%;\"><input style=\"width:100%;\" name=\"description$i\" placeholder=\"Transaction description\" size=60 </td>";
		echo "<td style=\"width:16%;\" align=center><input name=\"TransferDate$i\" value=$today size=10>";

		echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('TransferDate$i', false, 'ymd', '-');\"></td>";	

		echo "<td style=\"width:16%;\"><input style=\"width:100%;\" name=\"amount$i\" placeholder=\"Amount without $currencysymbol \" size=60 </td>";

		echo "<td style=\"width:16%;\"><select id=\"accountsinto$i\" name=\"accountsinto$i\">";
		$sql = "SELECT `Account` FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		echo "<td style=\"width:16%;\"><select id=\"accountsfrom$i\" name=\"accountsfrom$i\">";
		$sql = "SELECT `Account` FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		if ($i == 0)
			echo "<td rowspan=8 style=\"width:8%;\" align=center><input type=submit name=\"submitTransfer\" value=\"Create\"></td>";
		echo "</tr>";
	}
	echo "</form>";
	echo "</table><br>";



	if ((isset($_POST["submitExpense"])))
	{
		for ($i=0; $i<20;$i++)
		{
			if (($_POST['description' . $i] != "") AND is_numeric($_POST['amount' . $i]))
			{
				$sql = "INSERT INTO `txexpense` (`Description`, `Date`, `Amount`, `Expense`, `Account`) VALUES (\"". $_POST['description' . $i] ."\", \"". $_POST['EndDate' . $i] ."\", ". $_POST['amount' . $i] .", \"". $_POST['expense' . $i] ."\", \"". $_POST['Account' . $i] ."\")";
				if ($result=mysqli_query($con,$sql))
				{
					$mydate = date("Y-m-d H:i:s");
					$mystring = $_POST['description' . $i] . ", ". $_POST['EndDate' . $i] . ", ". $_POST['amount' . $i] .", ". $_POST['expense' . $i] .", ". $_POST['Account' . $i];
					$sql2 = "INSERT INTO `logs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'txexpense', '$mydate' ,'$mystring')";
					$result2=mysqli_query($con,$sql2);

				    echo "Added to the Expense Table: " . $_POST['description' . $i] . ", " . $_POST['EndDate' . $i] . ", " . $_POST['amount' . $i] . ", " . $_POST['expense' . $i] . ", " . $_POST['Account' . $i] . "<br>";
				}

				else
			    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
			    //echo $sql . "<br>";
			}	
		}
	}
	
	else if ((isset($_POST["submitIncome"])))
	{
		for ($i=0; $i<8;$i++)
		{
			if (($_POST['description' . $i] != "") AND is_numeric($_POST['amount' . $i]))
			{
				$sql = "INSERT INTO `txincome` (`Description`, `Date`, `Amount`, `Account`, `Income`) VALUES (\"". $_POST['description' . $i] ."\", \"". $_POST['IncomeDate' . $i] ."\", ". $_POST['amount' . $i] .", \"". $_POST['Account' . $i] ."\", \"". $_POST['Income' . $i] ."\")";
				if ($result=mysqli_query($con,$sql))
				{    
					$mydate = date("Y-m-d H:i:s");
					$mystring = $_POST['description' . $i] . ", ". $_POST['IncomeDate' . $i] . ", ". $_POST['amount' . $i] .", ". $_POST['Account' . $i] .", ". $_POST['Income' . $i];
					$sql2 = "INSERT INTO `logs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'txincome', '$mydate' ,'$mystring')";
					$result2=mysqli_query($con,$sql2);

					echo "Added to the Income Table: " . $_POST['description' . $i] . ", " . $_POST['IncomeDate' . $i] . ", " . $_POST['amount' . $i] . ", " . $_POST['Account' . $i] . ", " . $_POST['Income' . $i] . "<br>";
				}
				else
			     	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
			    //echo $sql . "<br>";
			}
		}
	}

	else if ((isset($_POST["submitTransfer"])))
	{
		for ($i=0; $i<8;$i++)
		{
			if (($_POST['description' . $i] != "") AND is_numeric($_POST['amount' . $i]))
			{			
				$sql = "INSERT INTO `transfers` (`Description`, `Date`, `Amount`, `IntoAccount`, `FromAccount`) VALUES (\"". $_POST['description' . $i] ."\", \"". $_POST['TransferDate' . $i] ."\", ". $_POST['amount' . $i] .", \"". $_POST['accountsinto' . $i] ."\", \"". $_POST['accountsfrom' . $i] ."\")";
				if ($result=mysqli_query($con,$sql))
				{    
					$mydate = date("Y-m-d H:i:s");
					$mystring = $_POST['description' . $i] . ", ". $_POST['TransferDate' . $i] . ", ". $_POST['amount' . $i] .", ". $_POST['accountsinto' . $i] .", ". $_POST['accountsfrom' . $i];
					$sql2 = "INSERT INTO `logs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'transfers', '$mydate' ,'$mystring')";

					echo "Added to the Transfer Table: " . $_POST['description' . $i] . ", " . $_POST['TransferDate' . $i] . ", " . $_POST['amount' . $i] . ", " . $_POST['accountsinto' . $i] . ", " . $_POST['accountsfrom' . $i] . "<br>";
				}
				else
			    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
				//echo $sql . "<br>";
			}
		}
	}

?>