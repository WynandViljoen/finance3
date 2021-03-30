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

	$startdate = mktime(0,0,0,1,1,2017);
	$startdate = date("Y-m-d", $startdate);

	echo "<div align=center>";
	echo "<br><b>Add New Account Type (Master Filter):<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Account Type</th><th>Description</th><th>Create</th>";

	echo "<form method=\"post\">";
		echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"accounttype\" placeholder=\"Add the unique account type\" size=30></td>";
		echo "<td style=\"width:90%;\"><input style=\"width:100%;\" name=\"description\" placeholder=\"Add long description of account type here\" size=60 </td>";
		echo "<td style=\"width:10%;\"><input type=submit name=\"createType\" value=\"Create\"></td></tr>";
	echo "</form>";
	echo "</table>";

	echo "<br><br><b><div align=center>";
	echo "<br><b>Add New Account:<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Account</th><th>Account Type</th><th>Balance</th><th>Date</th><th>Description</th><th>Create</th>";

	echo "<form method=\"post\">";

		echo "<tr><td style=\"width:26%;\"><input style=\"width:100%;\" name=\"Account\" placeholder=\"Add account name here...\" size=60 </td>";

		echo "<td align=center style=\"width:10%;\"><select id=\"accounttype\" name=\"accounttype\">";
		$sql = "SELECT `accounttype` FROM `accounttypes`";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			echo "<option value=\"" . $row['0'] . "\"> " . $row['0'] . "</option>";
		echo "</select></td>";

		echo "<td style=\"width:16%;\"><input style=\"width:100%;\" name=\"balance\" placeholder=\"Amount without $currencysymbol \" size=60 </td>";				

		echo "<td style=\"width:16%;\" align=center><input name=\"startdate\" value=$startdate size=10>";

		echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('startdate', false, 'ymd', '-');\"></td>";	

		echo "<td style=\"width:33%;\"><input style=\"width:100%;\" name=\"description\" placeholder=\"Account description\" size=60 </td>";	

		echo "<td style=\"width:8%;\" align=center><input type=submit name=\"createAccount\" value=\"Create\"></td></tr>";
	echo "</form>";
	echo "</table><br>";	


	echo "<br><b><div align=center>";
	echo "<br><br><b>List of Existing Account Types:<br>";
	echo "</div>";

	echo "<table align=center border=1 class=\"mytable\"><th>Account Type</th><th>Description</th><th>Delete</th><th>Update</th>";
	$sql = "SELECT * FROM `accounttypes`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		echo "<form method=\"post\">";
			echo "<input type=\"hidden\" name=\"accounttypeold\" value=\"" . $row['0'] . "\">";
			echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";

			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"accounttypenew\" value=\"" .$row['0'] . "\"></td>";
			echo "<td style=\"width:50%;\"><input style=\"width:100%;\" name=\"descriptionnew\" value=\"" .$row['1'] . "\"></td>";
		
			echo "<td align=center style=\"width:10%;\">";
			echo "<input type=\"submit\" name=\"deleteType\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td>";

			echo "<td align=center style=\"width:10%;\">";
			echo "<input type=\"submit\" name=\"updateType\" value=\"  \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td></tr>";		

		echo "</form>";
	} 
	echo "</table>";


	echo "<div align=center>";
	echo "<br><br><b>List of Existing Accounts with opening balances: <br>";
	echo "</div>";


	echo "<table align=center border=1 class=\"mytable\"><th>Account</th><th>Account Type</th><th>Balance</th><th>Date</th><th>Description</th><th>Delete</th><th>Update</th>";
	$sql = "SELECT * FROM `accounts`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$amount = $row['2'];

		echo "<form method=\"post\">";
			echo "<input type=\"hidden\" name=\"accountold\" value=\"" . $row['0'] . "\">";	
			echo "<input type=\"hidden\" name=\"accounttypeold\" value=\"" . $row['1'] . "\">";
			echo "<input type=\"hidden\" name=\"balanceold\" value=\"" . $row['2'] . "\">";
			echo "<input type=\"hidden\" name=\"mydateold\" value=\"" . $row['3'] . "\">";
			echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['4'] . "\">";	
			echo "<tr><td style=\"width:25%;\"><input style=\"width:100%;\" name=\"accountnew\" value=\"" .$row['0'] . "\"></td>";
			echo "<td align=center style=\"width:10%;\"><select id=\"accounttypenew\" name=\"accounttypenew\">";

			$sql2 = "SELECT `accounttype` FROM `accounttypes`";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
				echo "<option value=\"" . $row2['0'] . "\"> " . $row2['0'] . "</option>";
			echo "<option value=\"" . $row['1'] . "\" selected> " . $row['1'] . "</option>";
			echo "</select></td>";

			echo "<td align=right style=\"width:10%;\"><input style=\"width:100%;\" name=\"balancenew\" value=\"" .$row['2'] . "\"></td>";
			echo "<td style=\"width:10%;\"><input style=\"width:100%;\" name=\"mydatenew\" value=\"" .$row['3'] . "\"></td>";

			echo "<td style=\"width:60%;\"><input style=\"width:100%;\" name=\"descriptionnew\" value=\"" .$row['4'] . "\"></td>";
		
			echo "<td align=center style=\"width:10%;\">";
			echo "<input type=\"submit\" name=\"deleteAccount\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td>";

			echo "<td align=center style=\"width:10%;\">";
			echo "<input type=\"submit\" name=\"updateAccount\" value=\"  \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td></tr>";		
		echo "</form>";

	} 
	echo "</table>";

	if ((isset($_POST["createType"])))
	{
		$accounttype = $_POST['accounttype'];
		$description = $_POST['description'];	

		$sql = "INSERT INTO `accounttypes` VALUES ('$accounttype', '$description')";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Record: '$accounttype', '$description' inserted successfully into accounttypes table.";
		    $mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['accounttype'] . ", ". $_POST['description'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'accounttypes', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);	
		}
		else
		{
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}
	
		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";	
	}

	if ((isset($_POST["createAccount"])))
	{
		$description = $_POST['description'];
		$mydate  = $_POST['startdate'];
		$amount = $_POST['balance'];
		$account = $_POST['Account'];
		$accounttype = $_POST['accounttype'];	

		$sql = "INSERT INTO `accounts` VALUES ('$account', '$accounttype', $amount, '$mydate', '$description')";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Record: '$account', '$accounttype', $amount, '$mydate', '$description' inserted successfully into accounts table.";
		    $mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['Account'] . ", ". $_POST['accounttype'] . ", ". $_POST['balance'] . ", ". $_POST['startdate'] . ", ". $_POST['description'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'accounts', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);	
		}
		else
		{
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}
	
		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";	
	}

	if ((isset($_POST["deleteType"])))
	{
		$accounttypeold = $_POST['accounttypeold'];
		$descriptionold = $_POST['descriptionold'];

		$sql = "DELETE FROM `accounttypes` WHERE (`accounttype` = '$accounttypeold')";
		if ($result=mysqli_query($con,$sql))
		{	
		    echo "Field '$accounttypeold' deleted successfully into table incomes.";

		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['accounttypeold'] . ", ". $_POST['descriptionold'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'accounttypes', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);				    	
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);

		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";	
	}

	if ((isset($_POST["updateType"])))
	{
		$accounttypeold = $_POST['accounttypeold'];
		$descriptionold = $_POST['descriptionold'];
		$accounttypenew = $_POST['accounttypenew'];
		$descriptionnew = $_POST['descriptionnew'];

		if ($descriptionold != $descriptionnew)
		{	
			$sql = "UPDATE `accounttypes` SET `Description` = '$descriptionnew' WHERE (`accounttype` = '$accounttypeold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "Field '$accounttypeold' has been successfully updated in table incomes.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['accounttypeold'] . "]" . ": ". $_POST['descriptionold'] . " ---> ". $_POST['descriptionnew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'accounttypes', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}	
			else
		    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($accounttypeold != $accounttypenew)
	    {
		    $sql = "UPDATE `accounttypes` SET `accounttype` = '$accounttypenew' WHERE (`accounttype` = '$accounttypeold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accounttypeold' has been successfully updated to '$accounttypenew' in table incomes.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = $_POST['accounttypeold'] . " ---> " . $_POST['accounttypenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update-id', 'accounttypes', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";	
	}

	if ((isset($_POST["deleteAccount"])))
	{
		$accountold = $_POST['accountold'];
		$accounttypeold = $_POST['accounttypeold'];
		$balanceold = $_POST['balanceold'];
		$mydateold = $_POST['mydateold'];
		$descriptionold = $_POST['descriptionold'];

		$sql = "DELETE FROM `accounts` WHERE (`account` = '$accountold')";
		if ($result=mysqli_query($con,$sql))
		{	
		    echo "Field '$accountold' deleted successfully into table accounts.";

		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['accountold'] . ", ". $_POST['accounttypeold'] . ", ". $_POST['balanceold'] . ", ". $_POST['mydateold'] . ", ". $_POST['descriptionold'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'accounts', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);	
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);

		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";	
	}

	if ((isset($_POST["updateAccount"])))		
	{
		$accountold = $_POST['accountold'];
		$accountnew = $_POST['accountnew'];
		$accounttypeold = $_POST['accounttypeold'];
		$accounttypenew = $_POST['accounttypenew'];
		$balanceold = $_POST['balanceold'];
		$balancenew = $_POST['balancenew'];
		$mydateold = $_POST['mydateold'];
		$mydatenew = $_POST['mydatenew'];
		$descriptionold = $_POST['descriptionold'];
		$descriptionnew = $_POST['descriptionnew'];

	    if ($accounttypeold != $accounttypenew)
	    {
		    $sql = "UPDATE `accounts` SET `accounttype` = '$accounttypenew' WHERE (`Account` = '$accountold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accountold' has been successfully updated in table accounts.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['accountold'] . "]: ". $_POST['accounttypeold'] . " ---> ". $_POST['accounttypenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'accounts', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($balanceold != $balancenew)
	    {
		    $sql = "UPDATE `accounts` SET `Balance` = $balancenew WHERE (`Account` = '$accountold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accountold' has been successfully updated in table accounts.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['accountold'] . "]: ". $_POST['balanceold'] . " ---> ". $_POST['balancenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'accounts', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($mydateold != $mydatenew)
	    {
		    $sql = "UPDATE `accounts` SET `Date` = '$mydatenew' WHERE (`Account` = '$accountold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accountold' has been successfully updated in table accounts.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['accountold'] . "]: ". $_POST['mydateold'] . " ---> ". $_POST['mydatenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'accounts', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($descriptionold != $descriptionnew)
	    {
		    $sql = "UPDATE `accounts` SET `Description` = '$descriptionnew' WHERE (`Account` = '$accountold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accountold' has been successfully updated in table accounts.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['accountold'] . "]: ". $_POST['descriptionold'] . " ---> ". $_POST['descriptionnew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'accounts', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($accountold != $accountnew)
	    {
		    $sql = "UPDATE `accounts` SET `Account` = '$accountnew' WHERE (`Account` = '$accountold')";
			if ($result=mysqli_query($con,$sql))
			{	
			    echo "<br>Field '$accountold' has been successfully updated to '$accountnew' in table incomes.";

				$mydate = date("Y-m-d H:i:s");
				$mystring = $_POST['accountold'] . " ---> " . $_POST['accountnew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update-id', 'accounts', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);	
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"accountslist.php\">HERE </a> to reload this page.";

	}
?>

