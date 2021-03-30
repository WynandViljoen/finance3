<html>
<head>

<script type="text/javascript" src="tablefilter_all_min.js"></script>

</head>

<style type="text/css" media="screen">
@import "filtergrid2.css";

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
	echo "<br><b>Add New source of Expenses:<br>";
	echo "</div>";
	echo "<table align=center border=1 class=\"mytable\"><th>Expense</th><th>Description</th><th>Create</th>";

	echo "<form method=\"post\">";

	echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"expense\" placeholder=\"Add the unique expense name here\" size=30></td>";
	echo "<td style=\"width:90%;\"><input style=\"width:100%;\" name=\"description\" placeholder=\"Add long description of expense here\" size=60 </td>";
	echo "<td style=\"width:10%;\"><input type=submit name=\"create\" value=\"Submit\"></td></tr>";

	echo "</form>";
	echo "</table>";
	
	echo "<div align=center>";
	echo "<br><br><b>List of Expenses:<br>";
	echo "</div>";



	echo "<table align=center border=1 class=\"mytable\"><th>Expense</th><th>Description</th><th>Delete</th><th>Update</th>";
	$sql = "SELECT * FROM `expenses`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		echo "<form method=\"post\">";
		echo "<input type=\"hidden\" name=\"expenseold\" value=\"" . $row['0'] . "\">";
		echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";

		echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"expensenew\" value=\"" .$row['0'] . "\"></td>";
		echo "<td style=\"width:50%;\"><input style=\"width:100%;\" name=\"descriptionnew\" value=\"" .$row['1'] . "\"></td>";
	
		echo "<td align=center style=\"width:10%;\">";
		echo "<input type=\"submit\" name=\"delete\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td>";

		echo "<td align=center style=\"width:10%;\">";
		echo "<input type=\"submit\" name=\"update\" value=\"  \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\"> </td></tr>";		


		echo "</form>";
	} 
	echo "</table>";


	if ((isset($_POST["create"])))
	{	
		$expense = $_POST['expense'];
		$description = $_POST['description'];
		$sql = "INSERT INTO `expenses` VALUES ('$expense', '$description')";

		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$expense' with description '$description' inserted successfully into tables incomes.";
		    $mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['expense'] . ", ". $_POST['description'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'expenses', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);		    
		}
		else
		{
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"expenseslist.php\">HERE </a> to reload this page.";		
	}

	if ((isset($_POST["delete"])))
	{
		$expenseold = $_POST['expenseold'];
		$descriptionold = $_POST['descriptionold'];

		$sql = "DELETE FROM `expenses` WHERE (`Expense` = '$expenseold')";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$expenseold' deleted successfully into table incomes.";

		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['expenseold'] . ", ". $_POST['descriptionold'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'expenses', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);		    
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);

		echo "<br><br><br>";
		echo "<br>Click <a href=\"expenseslist.php\">HERE </a> to reload this page.";		    

	}

	if ((isset($_POST["update"])))
	{
		$expenseold = $_POST['expenseold'];
		$descriptionold = $_POST['descriptionold'];
		$expensenew = $_POST['expensenew'];
		$descriptionnew = $_POST['descriptionnew'];
		
		if ($descriptionold != $descriptionnew)
		{	
			$sql = "UPDATE `expenses` SET `Description` = '$descriptionnew' WHERE (`Expense` = '$expenseold')";
			if ($result=mysqli_query($con,$sql))
			{
			    echo "Field '$expenseold' has been successfully updated in table incomes.";

			   	$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['expenseold'] . "]: ". $_POST['descriptionold'] . " ---> ". $_POST['descriptionnew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'expenses', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);			    
			}

			else
		    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($expenseold != $expensenew)
	    {
		    $sql = "UPDATE `expenses` SET `Expense` = '$expensenew' WHERE (`Expense` = '$expenseold')";
			if ($result=mysqli_query($con,$sql))
			{
			    echo "<br>Field '$expenseold' has been successfully updated to '$expensenew' in table incomes.";

			   	$mydate = date("Y-m-d H:i:s");
				$mystring = $_POST['expenseold'] . " ---> " . $_POST['expensenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update-id', 'expenses', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);			    
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"expenseslist.php\">HERE </a> to reload this page.";				
	}

?>