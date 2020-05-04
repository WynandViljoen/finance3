<?php

	$server = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "finance";
	$currencysymbol = "";
	
	date_default_timezone_set ('America/Vancouver');


	$con=mysqli_connect($server,$username,$password,$database);
	
	if (mysqli_connect_errno())
	{
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}


	$sql = "SELECT `currency1`,`timezone` FROM `currency`";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{
		$currencysymbol = $row['0'];
		if ($row['1'] != "")
			date_default_timezone_set ('' . $row['1'] . '');
	}


?>