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

tr{cursor: pointer; transition: all .25s ease-in-out}
            .selected{background-color: lightgreen; color: #000;}

</style>

<?php
	include("header.html");
	include("dbcurrency.php");
	echo "<br><br><br>";

	
	echo "<table align=center border=1 class=\"mytable\"><th>Graph Name</th><th>Graph Description</th><th>Auto Show</th><th>Graph Type</th><th>Delete</th><th>Modify</th>";

	$sql = "SELECT * FROM `graphs`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
			echo "<form method=\"post\">";
			echo "<input type=\"hidden\" name=\"graphnameold\" value=\"" . $row['0'] . "\">";
			echo "<tr><td style=\"width:30%;\">" .$row['0'] . "</td>";
			echo "<td style=\"width:50%;\">" .$row['1'] . "</td>";
			
			if ($row['2'] == 0)
			echo "<td align=center style=\"width:10%;\">No</td>";
			else
			echo "<td align=center style=\"width:10%;\">Yes</td>";

			if ($row['3'] == 0)
			{
				echo "<td align=center style=\"width:10%;\">Income/Expense</td>";
				echo "<td align=center style=\"width:10%;\">";
				echo "<input type=\"submit\" name=\"delete\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td>";
				echo "<td align=center style=\"width:10%;\">";
				echo "<input type=\"submit\" name=\"updateIncomeExpense\" value=\"  \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td></tr>";
			}
			else 
			{
				echo "<td align=center style=\"width:10%;\">Account</td>";	
				echo "<td align=center style=\"width:10%;\">";
				echo "<input type=\"submit\" name=\"delete\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td>";
				echo "<td align=center style=\"width:10%;\">";
				echo "<input type=\"submit\" name=\"updateAccount\" value=\"  \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td></tr>";
			}	
	
			echo "</form>";	
		
	} 
	echo "<form method=\"post\">";
	echo "<tr><td colspan=6 align=center>";
	echo "<input type=submit name=\"createIncomeExpense\" value=\"Create New Income / Expense Graph\">&nbsp&nbsp&nbsp&nbsp&nbsp";
	echo "<input type=submit name=\"createAccount\" value=\"Create New Account Graph\"> ";
	echo "</td></tr>";
	echo "</form>";
	echo "</table><br><br>";
	


	if ((isset($_POST["createAccount"])))
	{
		echo "<form method=\"post\">";

		echo "<table align=center border=1 class=\"mytable\"><th>Graph Name</th><th>Graph Description</th><th>Auto Show</th><th>Graph Type</th>";
			//echo "<input type=\"hidden\" name=\"incomeold\" value=\"" . $row['0'] . "\">";
			//echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";
			echo "<input type=\"hidden\" name=\"graphtype\" value=1>";
			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"graphname\" placeholder=\"Add unique Graph name here\"></td>";
			echo "<td style=\"width:40%;\"><input style=\"width:100%;\" name=\"graphdescription\" placeholder=\"Add the graph description here\"></td>";
			echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshow\" value=1></td>";
			//echo "<td style=\"width:10%;\"><input style=\"width:100%;\" name=\"autoshow\" placeholder=\"Put Checkbox here...\"></td>";
			//echo "<td style=\"width:20%;\"><input style=\"width:100%;\" name=\"graphtype\" placeholder=\"Put Dropdown here...\"></td>";
			echo "<td align=center style=\"width:10%;\">Account</td>";
			echo "</tr>";	
		echo "</table><br><br>";

		echo "<div align=center>";
		echo "<br><b>Select Fields that will form part of the Graph: <br>";
		echo "</div>";

		echo "<table align=center border=1><tr><td>";

		echo "<table border=1>";
		echo "<th colspan=2>Increase Graph Value</th>";
		//echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

	  	//echo "<th colspan=2 align=center>Accounts</th>";

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
			echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
		  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

		  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
			echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
		  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
	  	}


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  	//echo "<tr><td colspan=2 align=center><input type=submit name=\"create\" value=\"Submit\"></td></tr>";
	  	echo "</table></td><td>";


		echo "<table border=1>";
		echo "<th colspan=2>Decrease Graph Value</th>";
		//echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

	  	//echo "<th colspan=2 align=center>Accounts</th>";

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
			echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
		  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

		  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
			echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
		  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
	  	}



	  	
	  	echo "</table></td></tr><tr><td colspan=2 align=center>";
		echo "<input type=submit name=\"submitAccount\" value=\"Create Graph\"></td></tr>";
	  	echo "</table>";

	  	echo "</form>";

	}

	if ((isset($_POST["submitAccount"])))
	{
		$autoshow = 0;
		if(!empty($_POST['autoshow']))
			$autoshow = 1;
			
		$sql = "INSERT INTO `graphs` VALUES ('" . $_POST['graphname'] ."', '" . $_POST['graphdescription'] ."', $autoshow, " . $_POST['graphtype'] .")";
		$result=mysqli_query($con,$sql);

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'incomeaccountview', 'Account', '" . $row['0'] ."', 0)";
			if ($_POST['addaccount'][$row['0']] == "income")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'expenseaccountview', 'Account', '" . $row['0'] ."', 0)";
			if ($_POST['addaccount'][$row['0']] == "expense")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'intoaccountview', 'IntoAccount', '" . $row['0'] ."', 0)";
			if ($_POST['addtransfer'][$row['0']] == "intoaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'fromaccountview', 'FromAccount', '" . $row['0'] ."', 0)";
			if ($_POST['addtransfer'][$row['0']] == "fromaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'incomeaccountview', 'Account', '" . $row['0'] ."', 1)";
			if ($_POST['subtractaccount'][$row['0']] == "income")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'expenseaccountview', 'Account', '" . $row['0'] ."', 1)";
			if ($_POST['subtractaccount'][$row['0']] == "expense")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'intoaccountview', 'IntoAccount', '" . $row['0'] ."', 1)";
			if ($_POST['subtracttransfer'][$row['0']] == "intoaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'fromaccountview', 'FromAccount', '" . $row['0'] ."', 1)";
			if ($_POST['subtracttransfer'][$row['0']] == "fromaccount")
				$result2=mysqli_query($con,$sql2);

		}


		echo "<br><br><br>";
			echo "<br>Graph Created. Click <a href=\"graphcreator.php\">HERE </a> to reload this page."; 
	}


	if ((isset($_POST["createIncomeExpense"])))
	{
		echo "<form method=\"post\">";

		echo "<table align=center border=1 class=\"mytable\"><th>Graph Name</th><th>Graph Description</th><th>Auto Show</th><th>Graph Type</th>";
			//echo "<input type=\"hidden\" name=\"incomeold\" value=\"" . $row['0'] . "\">";
			//echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";
			echo "<input type=\"hidden\" name=\"graphtype\" value=0>";
			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"graphname\" placeholder=\"Add unique Graph name here\"></td>";
			echo "<td style=\"width:40%;\"><input style=\"width:100%;\" name=\"graphdescription\" placeholder=\"Add the graph description here\"></td>";
			//echo "<td style=\"width:10%;\"><input style=\"width:100%;\" name=\"autoshow\" placeholder=\"Put Checkbox here...\"></td>";
			echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshow\" value=1></td>";
			//echo "<label for=\"vehicle1\"> I have a bike</label><br>
			//echo "<td style=\"width:20%;\"><input style=\"width:100%;\" name=\"graphtype\" placeholder=\"Put Dropdown here...\"></td>";
			echo "<td align=center style=\"width:10%;\">Income / Expense</td>";
			echo "</tr>";	
		echo "</table><br><br>";

		echo "<div align=center>";
		echo "<br><b>Select Fields that will form part of the Graph: <br>";
		echo "</div>";

		echo "<table align=center border=1><tr><td>";

		echo "<table border=1>";
		echo "<th colspan=2>Increase Graph Value</th>";
		echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  	echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"include\" value=\"include\">include</td></tr>";
	  	}

		echo "<th colspan=2 align=center>Expenses</th>";

		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  	echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" include\" value=\"include\">include</td></tr>";
	  	}



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  	//echo "<tr><td colspan=2 align=center><input type=submit name=\"create\" value=\"Submit\"></td></tr>";
	  	echo "</table></td><td>";


		echo "<table border=1>";
		echo "<th colspan=2>Decrease Graph Value</th>";
		echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  	echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" include\" value=\"include\">include</td></tr>";
	  	}

		echo "<th colspan=2 align=center>Expenses</th>";

		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			echo "<tr><td>$field</td><td>";
			echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  	echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" include\" value=\"include\">include</td></tr>";
	  	}
 	
	  	echo "</table></td></tr><tr><td colspan=2 align=center>";
		echo "<input type=submit name=\"submitIncomeExpense\" value=\"Create Graph\"></td></tr>";
	  	echo "</table>";

	  	echo "</form>";
  	}


	if ((isset($_POST["submitIncomeExpense"])))
	{
		$autoshow = 0;
		if(!empty($_POST['autoshow']))
			$autoshow = 1;
			

		$sql = "INSERT INTO `graphs` VALUES ('" . $_POST['graphname'] ."', '" . $_POST['graphdescription'] ."', $autoshow, " . $_POST['graphtype'] .")";
		$result=mysqli_query($con,$sql);


		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'incomeview', 'Income', '" . $row['0'] ."', 0)";
			if ($_POST['addincome'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'incomeview', 'Income', '" . $row['0'] ."', 1)";
			if ($_POST['subtractincome'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

		}

		echo "<br>";
		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'expenseview', 'Expense', '" . $row['0'] ."', 0)";
			if ($_POST['addexpenses'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphname'] ."', 'expenseview', 'Expense', '" . $row['0'] ."', 1)";
			if ($_POST['subtractexpenses'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

		}

			echo "<br><br><br>";
			echo "<br>Graph Created. Click <a href=\"graphcreator.php\">HERE </a> to reload this page."; 

	}

	if ((isset($_POST["delete"])))
	{
		$graphname = $_POST['graphnameold'];

		//$sql = "DELETE FROM `graphelement` WHERE (`graphname` = '$graphname')";
		//$result=mysqli_query($con,$sql);

		$sql = "DELETE FROM `graphs` WHERE (`graphName` = '$graphname')";
		$result=mysqli_query($con,$sql);

		echo "<br><br><br>$sql";
		echo "<br>Graph Deleted. Click <a href=\"graphcreator.php\">HERE </a> to reload this page."; 

	}

	if ((isset($_POST["updateAccount"])))
	{
		$graphnameold = $_POST['graphnameold'];
		echo "<form method=\"post\">";

		$sql = "SELECT * FROM `graphs` WHERE (`graphname` = '$graphnameold')";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{
			//if(!empty($_POST['autoshow']))
			//$autoshow = 1;
			
			echo "<table align=center border=1 class=\"mytable\"><th>Graph Name</th><th>Graph Description</th><th>Auto Show</th><th>Graph Type</th>";
			echo "<input type=\"hidden\" name=\"graphnameold\" value=\"" . $row['0'] . "\">";
			echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";
			echo "<input type=\"hidden\" name=\"autoshowold\" value=\"" . $row['2'] . "\">";
			echo "<input type=\"hidden\" name=\"graphtype\" value=1>";
			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"graphnamenew\" value=\"" . $row['0'] . "\"></td>";
			echo "<td style=\"width:40%;\"><input style=\"width:100%;\" name=\"graphdescriptionnew\" value=\"" . $row['1'] . "\"></td>";
			
			if ($row['2'] == 0)
				echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshownew\" value=1></td>";
			else 
				echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshownew\" checked value=1></td>";

			echo "<td align=center style=\"width:10%;\">Income / Expense</td>";
			echo "</tr>";	
			echo "</table><br><br>";
		}

		echo "<div align=center>";
		echo "<br><b>Select Fields that will form part of the Graph: <br>";
		echo "</div>";

		echo "<table align=center border=1><tr><td>";

		echo "<table border=1>";
		echo "<th colspan=2>Increase Graph Value</th>";
		//echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

	  	//echo "<th colspan=2 align=center>Accounts</th>";

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT `viewtable` FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '0')) ORDER BY `viewtable`";
				if ($result2=mysqli_query($con,$sql2))
					$rowcount = mysqli_num_rows($result2); 
			if ($rowcount == 0)	
			{
				echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
				echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
			  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

			  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
				echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
			  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
		  	}
		  	else if ($rowcount == 1)	
			{
				$row=mysqli_fetch_row($result2);
				if ($row['0'] == "incomeaccountview")
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
				else if ($row['0'] == "expenseaccountview")
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";					
				}
				else if ($row['0'] == "intoaccountview")
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";					
				}
				else if ($row['0'] == "fromaccountview")
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";					
				}
			}
			else if ($rowcount == 2)	
			{
				$row=mysqli_fetch_row($result2);
				$row2=mysqli_fetch_row($result2);
				if (($row['0'] == "expenseaccountview") && ($row2['0'] == "fromaccountview"))
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "expenseaccountview") && ($row2['0'] == "intoaccountview"))
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "fromaccountview") && ($row2['0'] == "incomeaccountview"))
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "incomeaccountview") && ($row2['0'] == "intoaccountview"))
				{
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"addaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"addtransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
			}
	  	}


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  	//echo "<tr><td colspan=2 align=center><input type=submit name=\"create\" value=\"Submit\"></td></tr>";
	  	echo "</table></td><td>";


		echo "<table border=1>";
		echo "<th colspan=2>Decrease Graph Value</th>";
		//echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

	  	//echo "<th colspan=2 align=center>Accounts</th>";

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT `viewtable` FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '1')) ORDER BY `viewtable`";
				if ($result2=mysqli_query($con,$sql2))
					$rowcount = mysqli_num_rows($result2); 
			if ($rowcount == 0)	
			{
				echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
				echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
			  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

			  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
				echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
			  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
		  	}
		  	else if ($rowcount == 1)	
			{
				$row=mysqli_fetch_row($result2);
				if ($row['0'] == "incomeaccountview")
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
				else if ($row['0'] == "expenseaccountview")
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";					
				}
				else if ($row['0'] == "intoaccountview")
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";					
				}
				else if ($row['0'] == "fromaccountview")
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";					
				}
			}
			else if ($rowcount == 2)	
			{
				$row=mysqli_fetch_row($result2);
				$row2=mysqli_fetch_row($result2);
				if (($row['0'] == "expenseaccountview") && ($row2['0'] == "fromaccountview"))
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "expenseaccountview") && ($row2['0'] == "intoaccountview"))
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\" checked=\"checked\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "fromaccountview") && ($row2['0'] == "incomeaccountview"))
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\" checked=\"checked\">transfer from account</th></tr>";
				}
				else if (($row['0'] == "incomeaccountview") && ($row2['0'] == "intoaccountview"))
				{
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" income\" value=\"income\" checked=\"checked\">income into account";
				  	echo "<input type=\"radio\" name=\"subtractaccount[$field]\" id=\" expense\" value=\"expense\">expense from account<br>";

				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" exclude\" value=\"exclude\">exclude";
					echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" intoaccount\" value=\"intoaccount\" checked=\"checked\">transfer into account";
				  	echo "<input type=\"radio\" name=\"subtracttransfer[$field]\" id=\" fromaccount\" value=\"fromaccount\">transfer from account</th></tr>";
				}
			}
	  	}



	  	
	  	echo "</table></td></tr><tr><td colspan=2 align=center>";
		echo "<input type=submit name=\"submitupdateAccount\" value=\"Update Graph\"></td></tr>";
	  	echo "</table>";

	  	echo "</form>";
	}

	if ((isset($_POST["submitupdateAccount"])))	
	{
		$graphnameold = $_POST['graphnameold'];
		$descriptionold = $_POST['descriptionold'];
		$autoshowold = $_POST['autoshowold'];

		$graphnamenew = $_POST['graphnamenew'];
		$graphdescriptionnew = $_POST['graphdescriptionnew'];

		$autoshownew = 0;
		if(!empty($_POST['autoshownew']))
			$autoshownew = 1;

		$sql = "DELETE FROM `graphelement` WHERE (`graphname` = '$graphnameold')";
		$result=mysqli_query($con,$sql);
			
		if ($descriptionold != $graphdescriptionnew)
		{
			$sql = "UPDATE `graphs` SET `graphDescription` = '$graphdescriptionnew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}

		if ($autoshowold != $autoshownew)
		{
			$sql = "UPDATE `graphs` SET `AutoShow` = '$autoshownew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}				

		if ($graphnameold != $graphnamenew)
		{
			$sql = "UPDATE `graphs` SET `graphName` = '$graphnamenew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}

		$sql = "SELECT * FROM `accounts`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'incomeaccountview', 'Account', '" . $row['0'] ."', 0)";
			if ($_POST['addaccount'][$row['0']] == "income")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'expenseaccountview', 'Account', '" . $row['0'] ."', 0)";
			if ($_POST['addaccount'][$row['0']] == "expense")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'intoaccountview', 'IntoAccount', '" . $row['0'] ."', 0)";
			if ($_POST['addtransfer'][$row['0']] == "intoaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'fromaccountview', 'FromAccount', '" . $row['0'] ."', 0)";
			if ($_POST['addtransfer'][$row['0']] == "fromaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'incomeaccountview', 'Account', '" . $row['0'] ."', 1)";
			if ($_POST['subtractaccount'][$row['0']] == "income")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'expenseaccountview', 'Account', '" . $row['0'] ."', 1)";
			if ($_POST['subtractaccount'][$row['0']] == "expense")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'intoaccountview', 'IntoAccount', '" . $row['0'] ."', 1)";
			if ($_POST['subtracttransfer'][$row['0']] == "intoaccount")
				$result2=mysqli_query($con,$sql2);

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'fromaccountview', 'FromAccount', '" . $row['0'] ."', 1)";
			if ($_POST['subtracttransfer'][$row['0']] == "fromaccount")
				$result2=mysqli_query($con,$sql2);

		}

			echo "<br><br><br>";
			echo "<br>Graph Updated. Click <a href=\"graphcreator.php\">HERE </a> to reload this page."; 

	}

	if ((isset($_POST["updateIncomeExpense"])))
	{
		$graphnameold = $_POST['graphnameold'];
		echo "<form method=\"post\">";

		$sql = "SELECT * FROM `graphs` WHERE (`graphname` = '$graphnameold')";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{
			//if(!empty($_POST['autoshow']))
			//$autoshow = 1;
			
			echo "<table align=center border=1 class=\"mytable\"><th>Graph Name</th><th>Graph Description</th><th>Auto Show</th><th>Graph Type</th>";
			echo "<input type=\"hidden\" name=\"graphnameold\" value=\"" . $row['0'] . "\">";
			echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";
			echo "<input type=\"hidden\" name=\"autoshowold\" value=\"" . $row['2'] . "\">";
			echo "<input type=\"hidden\" name=\"graphtype\" value=0>";
			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"graphnamenew\" value=\"" . $row['0'] . "\"></td>";
			echo "<td style=\"width:40%;\"><input style=\"width:100%;\" name=\"graphdescriptionnew\" value=\"" . $row['1'] . "\"></td>";
			
			if ($row['2'] == 0)
				echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshownew\" value=1></td>";
			else 
				echo "<td align=center style=\"width:10%;\"><input type=\"checkbox\" name=\"autoshownew\" checked value=1></td>";

			echo "<td align=center style=\"width:10%;\">Income / Expense</td>";
			echo "</tr>";	
		echo "</table><br><br>";
		}
		
		echo "<div align=center>";
		echo "<br><b>Select Fields that will form part of the Graph: <br>";
		echo "</div>";

		echo "<table align=center border=1><tr><td>";

		echo "<table border=1>";
		echo "<th colspan=2>Increase Graph Value</th>";
		echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT * FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '0'))";
			if ($result2=mysqli_query($con,$sql2))
				$rowcount = mysqli_num_rows($result2); 

			if ($rowcount)
			{
				echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"exclude\" value=\"exclude\">exclude";
		  		echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"include\" value=\"include\" checked=\"checked\">include</td></tr>";
		  	}
		  	else
		  	{
				echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  		echo "<input type=\"radio\" name=\"addincome[$field]\" id=\"include\" value=\"include\">include</td></tr>";
		  	}

	  	}

		echo "<th colspan=2 align=center>Expenses</th>";

		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT * FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '0'))";
			if ($result2=mysqli_query($con,$sql2))
				$rowcount = mysqli_num_rows($result2); 

			if ($rowcount)
			{
				echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" exclude\" value=\"exclude\">exclude";
		  		echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" include\" value=\"include\" checked=\"checked\">include</td></tr>";
		  	}
		  	else 
		  	{
				echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  		echo "<input type=\"radio\" name=\"addexpenses[$field]\" id=\" include\" value=\"include\">include</td></tr>";
		  	}
	  	}
	  	echo "</table></td><td>";


		echo "<table border=1>";
		echo "<th colspan=2>Decrease Graph Value</th>";
		echo "<tr><th colspan=2 align=center>Incomes</th></tr>";

		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT * FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '1'))";
			if ($result2=mysqli_query($con,$sql2))
				$rowcount = mysqli_num_rows($result2); 

			if ($rowcount)
			{			
				echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" exclude\" value=\"exclude\">exclude";
		  		echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" include\" value=\"include\" checked=\"checked\">include</td></tr>";
		  	}
		  	else 
		  	{
				echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  		echo "<input type=\"radio\" name=\"subtractincome[$field]\" id=\" include\" value=\"include\">include</td></tr>";		  		
		  	}
	  	}

		echo "<th colspan=2 align=center>Expenses</th>";

		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$field = $row['0'];
			$rowcount = 0;
			echo "<tr><td>$field</td><td>";
			$sql2 = "SELECT * FROM `graphelement` WHERE ((`graphname` = '$graphnameold') AND (`FieldString` = '$field') AND (`operation` = '1'))";
			if ($result2=mysqli_query($con,$sql2))
				$rowcount = mysqli_num_rows($result2); 

			if ($rowcount)
			{			
				echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" exclude\" value=\"exclude\">exclude";
		  		echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" include\" value=\"include\" checked=\"checked\">include</td></tr>";
		  	}
		  	else
		  	{
		  		echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" exclude\" value=\"exclude\" checked=\"checked\">exclude";
		  		echo "<input type=\"radio\" name=\"subtractexpenses[$field]\" id=\" include\" value=\"include\">include</td></tr>";
		  	}
	  	}
 	
	  	echo "</table></td></tr><tr><td colspan=2 align=center>";
		echo "<input type=submit name=\"submitupdateIncomeExpense\" value=\"Update Graph\"></td></tr>";
	  	echo "</table>";

	  	echo "</form>";

	}


	if ((isset($_POST["submitupdateIncomeExpense"])))
	{


		$graphnameold = $_POST['graphnameold'];
		$descriptionold = $_POST['descriptionold'];
		$autoshowold = $_POST['autoshowold'];

		$graphnamenew = $_POST['graphnamenew'];
		$graphdescriptionnew = $_POST['graphdescriptionnew'];

		$autoshownew = 0;
		if(!empty($_POST['autoshownew']))
			$autoshownew = 1;

		$sql = "DELETE FROM `graphelement` WHERE (`graphname` = '$graphnameold')";
		$result=mysqli_query($con,$sql);
			
		if ($descriptionold != $graphdescriptionnew)
		{
			$sql = "UPDATE `graphs` SET `graphDescription` = '$graphdescriptionnew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}

		if ($autoshowold != $autoshownew)
		{
			$sql = "UPDATE `graphs` SET `AutoShow` = '$autoshownew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}				

		if ($graphnameold != $graphnamenew)
		{
			$sql = "UPDATE `graphs` SET `graphName` = '$graphnamenew' WHERE (`graphName` = '$graphnameold')";
			$result=mysqli_query($con,$sql);
		}

		$sql = "SELECT * FROM `incomes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'incomeview', 'Income', '" . $row['0'] ."', 0)";
			if ($_POST['addincome'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'incomeview', 'Income', '" . $row['0'] ."', 1)";
			if ($_POST['subtractincome'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

		}

		echo "<br>";
		$sql = "SELECT * FROM `expenses`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
		{	
			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'expenseview', 'Expense', '" . $row['0'] ."', 0)";
			if ($_POST['addexpenses'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

			$sql2 = "INSERT INTO `graphelement` (`graphname`, `viewtable`, `FieldHeader`, `FieldString`, `operation`) VALUES ('" . $_POST['graphnamenew'] ."', 'expenseview', 'Expense', '" . $row['0'] ."', 1)";
			if ($_POST['subtractexpenses'][$row['0']] == "include")
			{
				//echo $sql2 . "<br>";
				$result2=mysqli_query($con,$sql2);
			}

		}

			echo "<br><br><br>";
			echo "<br>Graph Updated. Click <a href=\"graphcreator.php\">HERE </a> to reload this page."; 

	}


?>