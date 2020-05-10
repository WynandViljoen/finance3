<html>
<head> 
  <link rel="stylesheet" href="dropdown.css">
</head>

<style type="text/css" media="screen">
body {background-color: #dddddd;}
</style>

<body>


<?php

session_start();
?>

<?php
	
	//include("header.html");

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

	$rowscount = 0;
	$sql = "SELECT * FROM `session`";
	if($result=mysqli_query($con,$sql))
	{
		$row = mysqli_fetch_row($result);
		$rowscount = mysqli_num_rows($result);
	}
		//echo "<br>Value of RowCount: $rowscount<br>";
	if ($rowscount == 0)
	{
		$myId = $_SERVER['REMOTE_ADDR'];
		$mydate = date("Y-m-d H:i:s");
		//echo "<br>I am inside if statement $myId + $mydate <br>";
		$sql2 = "INSERT INTO `session` (`IPAddress`, `Date`) VALUES ('$myId', '$mydate')";
		$result2=mysqli_query($con,$sql2);

		$_SESSION['username'] = $myId;
		//echo "<br>$sql2 + $myId<br>";
		$sql = "SELECT * FROM `session`";
		if($result=mysqli_query($con,$sql))
		{
			$row = mysqli_fetch_row($result);
			//echo "<br>sessions table: " . $row['0'] . " + " . $row['1'] . " <br>";
		}

		$files = glob(session_save_path() . '/sess_*'); // get all file names
		foreach($files as $file)
		{  //iterate files
  			if(is_file($file) && ($file != session_save_path() . "/sess_" . session_id()))
  			{
    			unlink($file); // delete file
  			}
		}
		
	}	

	if (!isset($_SESSION['username']))
	{
		echo "<br><br><br>Your session cannot be validated!<br>";
		if ($_SERVER['REMOTE_ADDR'] == $row['0'])
		{
			echo "As you are connecting from the same IP address, your session can be reset.";
			echo "<h4 style=\"color:red;\">PLEASE NOTE THAT THE CURRENT DATABASE WILL BE DELETED! In the future.....</h4>";
			echo "<form method=\"post\">";
			echo "<input type=\"hidden\" value=\"" . $row['0'] . "\" name=\"IPAddress\">";
			echo "<input type=\"submit\" value=\"Reset Session\" name=\"resetsession\"><br><br>";
			echo "</form>";
		}
		else
		{
			echo "Your IP address is <b>" . $_SERVER['REMOTE_ADDR'] . "</b><br>The user currently logged in has an IP address of <b>" . $row['0'] . "</b>.";
			echo "<br>This user has been logged in at <b>" . $row['1'] . "</b>";
			echo "<br>Please create a new container to run your application.";
		}
		
	}
	else
	{
		//header("Location: accountbalances.php");
		echo "<br><br><br>";
    	echo "<br>Click <a href=\"accountbalances.php\">HERE </a> to go to the Account Balances page.";
	}


	if ((isset($_POST["resetsession"])))
	{
		echo "<br>Sessions are being saved to the following file: " . session_save_path();
		echo "<br>My session txt file is: " . session_id();

		$files = glob(session_save_path() . '/sess_*'); // get all file names
		foreach($files as $file)
		{  //iterate files
  			if(is_file($file) && ($file != session_save_path() . "/sess_" . session_id()))
  			{
    			unlink($file); // delete file
  			}
		}

		$IpAddress = $_POST['IPAddress'];
		$sql = "DELETE FROM `session` WHERE (`IPAddress` = '$IpAddress')";
		$result=mysqli_query($con,$sql);

		$myId = $_SERVER['REMOTE_ADDR'];
		$mydate = date("Y-m-d H:i:s");
		$sql2 = "INSERT INTO `session` (`IPAddress`, `Date`) VALUES ('$myId', '$mydate')";
		if ($result2=mysqli_query($con,$sql2))
			$_SESSION['username'] = $myId;

		$servername = "localhost";
        $username = "root";
        $password = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) 
            die("Connection failed: " . $conn->connect_error);
          
        // Delete any existing finance database on server
        $sql = "DROP DATABASE finance";  
        if (mysqli_query($conn, $sql)) 
            echo "<br>Database deleted successfully<br>";
        else 
            echo "Error deleting record: " . mysqli_error($conn) . "<br>";

        // Create new empty finance database
        $sql = "CREATE DATABASE finance";
        if ($conn->query($sql) === TRUE)
            echo "Database created successfully<br>";
        else 
            echo "Error creating database: " . $conn->error;

		header("Location: dbimport.php");
	}
?>



</body>
</html>