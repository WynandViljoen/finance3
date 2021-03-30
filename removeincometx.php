
<?php
	include("header.html");
	include("dbcurrency.php");	
	
	$id = $_POST['id'];

	echo "<br><br><br>";

	if ((isset($_POST["delete"])))
	{
		$sql = "DELETE FROM `txincome` WHERE (`Id` = $id)";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "Field '$id' deleted successfully from table txincome.";

		   	$mydate = date("Y-m-d H:i:s");
			$mystring = $_POST['description'] . ", ". $_POST['date'] . ", ". $_POST['amount'] .", ". $_POST['account'] .", ". $_POST['income'];
			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'txincome', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);		    
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);
	}

	echo "<br><br><br>";
	echo "<br>Click <a href=\"income.php\">HERE </a> to go back to previous page.";

?>