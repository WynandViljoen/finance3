
<?php
	include("header.html");
	include("dbcurrency.php");
	
	$id = $_POST['id'];

	echo "<br><br><br>";

	if ((isset($_POST["delete"])))
	{
		$sql = "DELETE FROM `transfers` WHERE (`Id` = $id)";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$id' deleted successfully from table txincome.";

		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['description'] . ", ". $_POST['date'] . ", ". $_POST['amount'] .", ". $_POST['accountInto'] .", ". $_POST['accountFrom'];
			$sql2 = "INSERT INTO `logs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'transfers', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);		    
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
	}

	echo "<br><br><br>";
	echo "<br>Click <a href=\"transfers.php\">HERE </a> to go back to previous page.";

?>