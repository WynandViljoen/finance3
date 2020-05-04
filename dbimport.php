<body>
<html>


<?php

define('FILE_ENCRYPTION_BLOCKS', 10000);

include("header.html");

  define('DS', DIRECTORY_SEPARATOR);
	echo "<br><br><br>";
	echo "<h2 style=\"color:red;\">If there is an existing database called 'finance' it will be deleted/replaced by this import!</h2><br>";

  echo "<form method=\"post\" enctype=\"multipart/form-data\">";
  echo "<table>";
  echo "Option 1: Create new Blank Database<br><input type=\"submit\" value=\"Create Blank\" name=\"blank\"><br><br>";

  echo "Option 2: Create database from template<br>";
  echo "<input type=\"submit\" value=\"Create from template\" name=\"template\">&nbsp&nbsp&nbsp";
  echo " <a href=\"importtemplate.php\" target=\"_blank\">View Template </a><br><br>";

  echo "Options 3: Import Unencrypted database<br>";
	echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\"><br>";

	echo "<input type=\"submit\" value=\"Import Unencrypted File\" name=\"unencrypted\"><br><br>";

  echo "Option 4: Import Encrypted database<br>";
  echo "<input type=\"file\" name=\"fileToUploadEncrypted\" id=\"fileToUploadEncrypted\"><br>";
  echo "Password: <input name=\"password\"size=25 type=\"password\"><br>";
  echo "<input type=\"submit\" value=\"Import Encrypted File\" name=\"encrypted\">";
  
  echo "</table>";
  echo "</form>";
  

if((isset($_POST["template"])) OR (isset($_POST["blank"]))) 
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $path = "templates";
    $filename = "template.sql";

    if (isset($_POST["blank"]))
    $filename = "blank.sql";

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
    $uploadedfile = $path . DS . $filename; 
    $sql = file_get_contents($uploadedfile);
    $mysqli = new mysqli("localhost", "root", "", "finance");
    $mysqli->multi_query($sql);

    echo "<br><br><br>";
    echo "<br>Click <a href=\"accountbalances.php\">HERE </a> to go to the Account Balances page.";
} 


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
         // if ($line == "")
         //   echo "<br><h2 style=\"color:red;\">Import Failed, the file might be corrupt.</h2><br>";
         // else
         //   echo "<br><h2 style=\"color:green;\">Database has been successfully imported</h2><br>";

          $files = glob($path . DS . '*'); // get all file names
          foreach($files as $file)
          { 
            if(is_file($file))
              unlink($file); // delete file
          }

          echo "<br><br><br>";
          echo "<br>Click <a href=\"accountbalances.php\">HERE </a> to go to the Account Balances page.";
      }

      else
        echo "Sorry, File format not allowed";
  }   


if(isset($_POST["encrypted"])) 
{
   $path = "uploads";
   $target_dir = $path . DS;
   $target_file = $target_dir . basename($_FILES["fileToUploadEncrypted"]["name"]);
   //$filename2 = basename($_FILES["fileToUpload"]["name"]);
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   $decryptPassword = $_POST['password'];


   // Allow certain file formats
   if ($imageFileType != "esql") 
   {
      echo "<br>Sorry, File format not allowed<br>";
      //echo "Target_file: $target_file AND Extension: $imageFileType";
   }

   else if ($decryptPassword == "") 
   {
      echo "<br>Please add a valid decryption password<br>";
   } 

   // if everything is ok, try to upload file
   else 
   {
       // Check if file already exists
        if (file_exists($target_file)) 
        {
           echo "File already exists on server.<br>";
           $uploadedfile = $path . DS . basename( $_FILES["fileToUploadEncrypted"]["name"]);
        }

        else if (move_uploaded_file($_FILES["fileToUploadEncrypted"]["tmp_name"], $target_file)) 
        {
           //echo "The following file has been uploaded: ";
           $uploadedfile = $path . DS . basename( $_FILES["fileToUploadEncrypted"]["name"]);
           echo $uploadedfile;
           //echo "<br>";
        }

        //$fileName = 'ZABudget_2020-05-02_21-35-55.esql';
        //$fullpath = "uploads" . DS . $fileName;
        //$key = $_POST['password'];
        $newFile = $target_dir . pathinfo(basename($_FILES["fileToUploadEncrypted"]["name"]),PATHINFO_FILENAME) . '.sql';
        decryptFile($uploadedfile, $decryptPassword, $newFile);

        //$newFile = pathinfo($uploadedfile,PATHINFO_FILENAME);
        //decryptFile($fileName, $key, $newFile . '.sql');

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

        // Import info from uploaded file into the finance database 
        $sql = file_get_contents($newFile);
        $mysqli = new mysqli("localhost", "root", "", "finance");
        $mysqli->multi_query($sql);

        $line = fgets(fopen($newFile, 'r'));
        if ($line == "")
          echo "<br><h2 style=\"color:red;\">Import Failed, the file might be corrupt or the decryption password was wrong.</h2><br>";
        else
          echo "<br><h2 style=\"color:green;\">Database has been successfully imported</h2><br>";

        $files = glob($path . DS . '*'); // get all file names
        foreach($files as $file)
        { 
          if(is_file($file))
            unlink($file); // delete file
        }

        echo "<br><br><br>";
        echo "<br>Click <a href=\"accountbalances.php\">HERE </a> to go to the Account Balances page.";
    }

}    


function decryptFile($source, $key, $dest)
{
    $key = substr(sha1($key, true), 0, 16);

    $error = false;
    if ($fpOut = fopen($dest, 'w')) {
        if ($fpIn = fopen($source, 'rb')) {
            // Get the initialzation vector from the beginning of the file
            $iv = fread($fpIn, 16);
            while (!feof($fpIn)) {
                $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1)); // we have to read one block more for decrypting than for encrypting
                $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                // Use the first 16 bytes of the ciphertext as the next initialization vector
                $iv = substr($ciphertext, 0, 16);
                fwrite($fpOut, $plaintext);
            }
            fclose($fpIn);
        } else {
            $error = true;
        }
        fclose($fpOut);
    } else {
        $error = true;
    }

    return $error ? false : $dest;
}

?>

</body>
</html>