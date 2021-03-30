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
	echo "<br><b>Add New Income Source: <br>";
	echo "</div>";

	echo "<table align=center border=1 class=\"mytable\"><th>Income</th><th>Description</th><th>Create</th>";

	echo "<form method=\"post\">";
		echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"income\" placeholder=\"Add the income unique name here\" size=30></td>";
		echo "<td style=\"width:90%;\"><input style=\"width:100%;\" name=\"description\" placeholder=\"Add long description of Income here\" size=60 </td>";
		echo "<td style=\"width:10%;\"><input type=submit name=\"create\" value=\"Submit\"></td></tr>";
	echo "</form>";
	echo "</table>";

	echo "<div align=center>";
	echo "<br><br><b>List of Incomes sources: <br>";
	echo "</div>";

	echo "<table align=center border=1 class=\"mytable\"><th>Income</th><th>Description</th><th>Delete</th><th>Update</th>";

	$sql = "SELECT * FROM `incomes`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		echo "<form method=\"post\">";
			echo "<input type=\"hidden\" name=\"incomeold\" value=\"" . $row['0'] . "\">";
			echo "<input type=\"hidden\" name=\"descriptionold\" value=\"" . $row['1'] . "\">";
			echo "<tr><td style=\"width:30%;\"><input style=\"width:100%;\" name=\"incomenew\" value=\"" .$row['0'] . "\"></td>";
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
		$income = $_POST['income'];
		$description = $_POST['description'];

		$sql = "INSERT INTO `incomes` VALUES ('$income', '$description')";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$income' with description '$description' inserted successfully into tables incomes.";
		    $mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['income'] . ", ". $_POST['description'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('add', 'incomes', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);
		}
		else
		{
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"incomeslist.php\">HERE </a> to reload this page.";
	}

	if ((isset($_POST["delete"])))
	{
		$income = $_POST['incomeold'];
		$description = $_POST['descriptionold'];

		$sql = "DELETE FROM `incomes` WHERE (`Income` = '$income')";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$income' deleted successfully into table incomes.";
		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['incomeold'] . ", ". $_POST['descriptionold'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'incomes', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);

		echo "<br><br><br>";
		echo "<br>Click <a href=\"incomeslist.php\">HERE </a> to reload this page.";    
	}

	if ((isset($_POST["update"])))
	{
		$incomeold = $_POST['incomeold'];
		$descriptionold = $_POST['descriptionold'];
		$incomenew = $_POST['incomenew'];
		$descriptionnew = $_POST['descriptionnew'];

		if ($descriptionold != $descriptionnew)
		{	
			$sql = "UPDATE `incomes` SET `Description` = '$descriptionnew' WHERE (`Income` = '$incomeold')";
			if ($result=mysqli_query($con,$sql))
			{
			    echo "Field '$incomeold' has been successfully updated in table incomes.";
			   	$mydate = date("Y-m-d H:i:s");
				$mystring = "[" . $_POST['incomeold'] . "]: ". $_POST['descriptionold'] . " ---> ". $_POST['descriptionnew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update', 'incomes', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);
			}
			else
		    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
		}

	    if ($incomenew != $incomeold)
	    {
		    $sql = "UPDATE `incomes` SET `Income` = '$incomenew' WHERE (`Income` = '$incomeold')";
			if ($result=mysqli_query($con,$sql))
			{    
				echo "<br>Field '$incomeold' has been successfully updated to '$incomenew' in table incomes.";
			   	$mydate = date("Y-m-d H:i:s");
				$mystring = $_POST['incomeold'] . " ---> ". $_POST['incomenew'];
				$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('update-id', 'incomes', '$mydate' ,'$mystring')";
				$result2=mysqli_query($con,$sql2);
			}
			else
		    	echo "<br>ERROR: Could not execute $sql. " . mysqli_error($con);
		}

		echo "<br><br><br>";
		echo "<br>Click <a href=\"incomeslist.php\">HERE </a> to reload this page.";
	}

?>