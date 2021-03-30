<body>
<html>


<?php

define('FILE_ENCRYPTION_BLOCKS', 10000);
define('DS', DIRECTORY_SEPARATOR);

  echo "<br><br><br>";
  echo "<h2 style=\"color:red;\">If there is an existing database called 'finance' it will be deleted/replaced by this import!</h2><br>";

  echo "<form method=\"post\" enctype=\"multipart/form-data\">";
  echo "<table>";

  echo "One and only option: Import Unencrypted database<br>";
  echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\"><br>";

  echo "<input type=\"submit\" value=\"Import Unencrypted File\" name=\"unencrypted\"><br><br>";
  
  echo "</table>";
  echo "</form>";

  if(isset($_POST["unencrypted"])) 
  {

      $path = "uploads";
      $target_dir = $path . DS;
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $filename2 = basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      // Allow certain file formats
      if ($imageFileType == "sql") 
      {
         // Check if file already exists
  	     if (file_exists($target_file)) 
  	     {
  	         echo "File already exists on server.<br>";
  	         $uploadedfile = $path . DS . basename( $_FILES["fileToUpload"]["name"]);
  	     }

         else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
         {
  	        echo "The following file has been uploaded: ";
  	        $uploadedfile = $path . DS . basename( $_FILES["fileToUpload"]["name"]);
  	        echo $uploadedfile;
  	        echo "<br>";
         }
         //echo "Target_file: $target_file AND Extension: $imageFileType<br>";
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
              echo "Database deleted successfully<br>";
          else 
              echo "Error deleting record: " . mysqli_error($conn) . "<br>";

      		// Create new empty finance database
      		$sql = "CREATE DATABASE finance";
      		if ($conn->query($sql) === TRUE)
      		    echo "Database created successfully<br>";
      		else 
      		    echo "Error creating database: " . $conn->error;

          // Import info from uploaded file into the finance database 
          $sql = file_get_contents($uploadedfile);
      		$mysqli = new mysqli("localhost", "root", "", "finance");
      		$mysqli->multi_query($sql);

          $line = fgets(fopen($uploadedfile, 'r'));
          echo "<br><b style=\"color:green;\">If the output in the line below is readable, then the database was imported correctly:</b><br>$line";
          echo "<br><b style=\"color:red;\">If the line above is not readable, the database file might be corrupt.</b><br>";

          $files = glob($path . DS . '*'); // get all file names
          foreach($files as $file)
          { 
            if(is_file($file))
              unlink($file); // delete file
          }

          sleep(1);
          header("Location: session.php");

          //echo "<br><br><br>";
          //echo "<br>Click <a href=\"accountbalances.php\">HERE </a> to go to the Account Balances page.";
          //include("session.php");


      }

      else
        echo "Sorry, File format not allowed";
  } 
    



?>

</body>
</html>