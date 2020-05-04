
<?php

include("header.html");

define('FILE_ENCRYPTION_BLOCKS', 10000);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	date_default_timezone_set ('America/Vancouver');

	define('DS', DIRECTORY_SEPARATOR);

	echo "<br><br><br>";
	echo "<h2 style=\"color:green;\">Database export page</h2><br>";

	echo "<table>";
	echo "<form method=\"post\">";
		echo "Option 1: Export database as a plaintext file<br>";
		echo "<input type=text name=\"myfilenamePlain\" placeholder=\"Type the prefix filename here...\" size=60><br>";
		echo "<input type=submit name=\"exportPlaintext\" value=\"Export Plaintext Database\">";


		echo "<br><br><br>Option 2: Export database as an encrypted file<br>";
		echo "<input type=text name=\"myfilename\" placeholder=\"Type the prefix filename here...\" size=60><br>";
		echo "<input type=password name=\"password\" placeholder=\"Type an encryption password\" size=60 ><br>";
		echo "<input type=password name=\"confirmpassword\" placeholder=\"Confirm the encryption password\" size=60><br>";
		echo "<input type=submit name=\"exportEncrypted\" value=\"Export Encrypted Database\">";
	echo "</form>";
	echo "</table>";


	if ((isset($_POST["exportPlaintext"])))
	{
			if ($_POST['myfilenamePlain'] == "")
				$fileprefix = "dump";
			else
				$fileprefix = $_POST['myfilenamePlain'];

			$database = 'finance';
			$user = 'root';
			$pass = '';
			$host = 'localhost';
			$path = "exports";
			$filename = $fileprefix . '_' .  date("Y-m-d_H-i-s") .'.sql';
			$dir = dirname(__FILE__) . DS . $path . DS . $filename;

			$files = glob($path . DS . '*'); // get all file names
          	foreach($files as $file)
          	{ 
            	if(is_file($file))
              	unlink($file); // delete file
          	}

			$mysqlDir = 'C:'.DS.'wamp64'.DS.'bin'.DS.'mysql'.DS.'mysql5.7.26'.DS.'bin';    // Paste your mysql directory here and be happy
			$mysqldump = $mysqlDir.DS.'mysqldump';

			//Windows
			//exec("{$mysqldump} --user={$user} --password={$pass} --host={$host} -B {$database} --result-file={$dir} 2>&1", $output);

			//Linux or Enviromental variable
			exec("mysqldump --user={$user} --password={$pass} --host={$host} -B {$database} --result-file={$dir} 2>&1", $output);
			var_dump($output);
			echo "<br><br><h3>Plaintext database has been exported and can be downloaded below</h3>";

			echo "<a href=\"" . $path . DS . $filename . "\">Download</a>";
	}

	if ((isset($_POST["exportEncrypted"])))
	{
		if (($_POST['password'] == $_POST['confirmpassword']) AND ($_POST['password'] != ""))
		{
			if ($_POST['myfilename'] == "")
				$fileprefix = "dump";
			else
				$fileprefix = $_POST['myfilename'];

			$database = 'finance';
			$user = 'root';
			$pass = '';
			$host = 'localhost';
			$path = "exports";
			//$filename = $fileprefix . '_' .  date("Y-m-d_H-i-s") .'.sql';
			$filename = $fileprefix .'.sql';
			$dir = dirname(__FILE__) . DS . $path . DS . $filename;

			$files = glob($path . DS . '*'); // get all file names
          	foreach($files as $file)
          	{ 
            	if(is_file($file))
              	unlink($file); // delete file
          	}

			$mysqlDir = 'C:'.DS.'wamp64'.DS.'bin'.DS.'mysql'.DS.'mysql5.7.26'.DS.'bin';    // Paste your mysql directory here and be happy
			$mysqldump = $mysqlDir.DS.'mysqldump';

			//Windowns
			//exec("{$mysqldump} --user={$user} --password={$pass} --host={$host} -B {$database} --result-file={$dir} 2>&1", $output);
			//Linux or Enviromental variable
			exec("mysqldump --user={$user} --password={$pass} --host={$host} -B {$database} --result-file={$dir} 2>&1", $output);
			var_dump($output); 

			$newfilename = $fileprefix . '_' .  date("Y-m-d_H-i-s") .'.esql';

	   		$key = $_POST['password'];

			encryptFile($path . DS . $filename, $key, $path . DS . $newfilename);

			$files = glob($path . DS . '*.sql'); // get all file names
          	foreach($files as $file)
          	{ 
            	if(is_file($file))
              	unlink($file); // delete file
          	}

          	echo "<br><br><h3>Password-protected database has been exported and can be downloaded below</h3>";
			echo "<a href=\"" . $path . DS . $newfilename . "\">Download</a>";
		}
		else
		{
			echo "<br>Passwords did not match (or are empty), database could not be exported! <br>";
		}
	}
		

function encryptFile($source, $key, $dest)
{
    $key = substr(sha1($key, true), 0, 16);
    $iv = openssl_random_pseudo_bytes(16);

    $error = false;
    if ($fpOut = fopen($dest, 'w')) {
        // Put the initialzation vector to the beginning of the file
        fwrite($fpOut, $iv);
        if ($fpIn = fopen($source, 'rb')) {
            while (!feof($fpIn)) {
                $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                // Use the first 16 bytes of the ciphertext as the next initialization vector
                $iv = substr($ciphertext, 0, 16);
                fwrite($fpOut, $ciphertext);
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

</html>