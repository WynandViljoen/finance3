<html>
<head>

<script type="text/javascript" src="tablefilter_all_min.js"></script>
<script language="javascript" type="text/javascript" src="datepicker.js"></script>

</head>

<style type="text/css" media="screen">

@import "filtergrid2.css";
@import "datepicker.css";

body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:90%; font-size:12px;
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

tr{cursor: pointer; transition: all .25s ease-in-out}
            .selected{background-color: lightgreen; color: #000;}
</style>

<?php
	include("header.html");
	include("dbcurrency.php");
	echo "<br><br>";
	echo "<br>Click <a href=\"preauthorised.php\">HERE </a> to reload this page.";
	
	//$mydate = date("Y-m");
	//$mydatet = date("Y-m-t"); 

	echo "<div align=center>";
	echo "<br><b>List of all Pre-Authorised payments<br>";
	echo "</div>";

	$mydate = date("Y-m"); 
	$counter = 0;
	$lastAccount = "";

	$sql2 = "SELECT `Account` FROM `accounts` ORDER BY `accounttype` DESC";
	if ($result2=mysqli_query($con,$sql2))
	while ($row2=mysqli_fetch_row($result2))
		$lastAccount = $row2['0'];



	$sql = "SELECT * FROM `preauthorised` ORDER BY `Description`";
	echo "<table align=center id=\"table2\" class=\"mytable\" border=1><th>Description</th><th>Account</th><th>Category</th>";
	echo "<th>StartDate</th><th>EndDate</th><th>MinAmount</th><th>MaxAmount</th><th>Verfied</th><th>Update</th><th>Delete</th>";
	echo "<tr><td colspan=5>Total:</td><td align=right id=\"table2Tot1\" style=\"background-color:#FFFFCC;\">";
	echo "</td><td align=right id=\"table2Tot2\" style=\"background-color:#FFFFCC;\"></td></tr>";
	if ($result=mysqli_query($con,$sql))
	while ($row=mysqli_fetch_row($result))
	{	
		$counter ++;

		echo "<tr><form method=\"post\">";
		
		echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['0'] . "\">";
		echo "<input type=\"hidden\" name=\"counter\" value=$counter>";
		echo "<input type=\"hidden\" name=\"port$counter\" value=\"" . $row['3'] . "\">";

		$minAmount = $row['5'];
		$minAmount = number_format((float)$minAmount, 2, '.', '');	

		$maxAmount = $row['6'];
		$maxAmount = number_format((float)$maxAmount, 2, '.', '');	


		
		

		if ($row['8'] == 0)
		{
			
			echo "<td><input name=\"description$counter\" value=\"" . $row['1']  . "\"></td>";
			
			echo "<td style=\"width:16%;\"><select id=\"Account$counter\" name=\"Account$counter\">";	
			$sql2 = "SELECT `Account` FROM `accounts` ORDER BY `accounttype` DESC";
			if ($result2=mysqli_query($con,$sql2))
			while ($row2=mysqli_fetch_row($result2))
				echo "<option value=\"" . $row2['0'] . "\"> " . $row2['0'] . "</option>";
			

			echo "<option selected value=\"" . $row['2'] . "\"> " . $row['2'] . "</option>";
			echo "</select></td>";
			

			//echo "<td> " . $row['2'] . "</td>";
			echo "<td><input name=\"category$counter\" value=\"" . $row['7']  . "\"></td>";
			//echo "<td> " . $row['7'] . "</td>";

			echo "<td style=\"width:16%;\" align=center><input name=\"dateone$counter\" value=" . $row['3']  . " size=10>";
			echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('dateone$counter', false, 'ymd', '-');\"></td>";	

			//echo "<td align=center> " . $row['3'] . "</td>";

			echo "<td style=\"width:16%;\" align=center><input name=\"datetwo$counter\" value=" . $row['4']  . " size=10>";
			echo " <img src=\"calendar.jpg\" style=\"width:22px;height:22px;vertical-align:bottom;\" onclick=\"displayDatePicker('datetwo$counter', false, 'ymd', '-');\"></td>";


			//echo "<td align=center> " . $row['4'] . "</td>";
			echo "<td><input name=\"minAmount$counter\" value=\"" . $row['5']  . "\"></td>";
			echo "<td><input name=\"maxAmount$counter\" value=\"" . $row['6']  . "\"></td>";
			//echo "<td align=right> $currencysymbol $minAmount </td>";
			//echo "<td align=right> $currencysymbol $maxAmount </td>";
			echo "<td align=center><input type=\"checkbox\" id=\"checkbox\" name=\"checkbox\">";

		}
		else
		{ 
			
			echo "<td> " . $row['1'] . "</td>";
			echo "<td> " . $row['2'] . "</td>";
			echo "<td> " . $row['7'] . "</td>";
			echo "<td align=center> " . $row['3'] . "</td>";
			echo "<td align=center> " . $row['4'] . "</td>";
			echo "<td align=right> $currencysymbol $minAmount </td>";
			echo "<td align=right> $currencysymbol $maxAmount </td>";
			echo "<td align=center><input type=\"checkbox\" id=\"checkbox\" name=\"checkbox\" checked>";

			echo "<input type=\"hidden\" name=\"description$counter\" value=\"" . $row['1']  . "\">";
			echo "<input type=\"hidden\" name=\"Account$counter\" value=" . $row['2']  . ">";
			echo "<input type=\"hidden\" name=\"category$counter\" value=\"" . $row['7']  . "\">";
			echo "<input type=\"hidden\" name=\"dateone$counter\" value=" . $row['3']  . ">";
			echo "<input type=\"hidden\" name=\"datetwo$counter\" value=" . $row['4']  . ">";
			echo "<input type=\"hidden\" name=\"minAmount$counter\" value=" . $row['5']  . ">";
			echo "<input type=\"hidden\" name=\"maxAmount$counter\" value=" . $row['6']  . ">";

		}

		//echo "<td align=center>  " . $row['6'] . " </td>";

		echo "<td align=center style=\"width:6%;\"> ";
		echo "<input type=\"submit\" name=\"update\" value=\" \" style=\"background:url(update.jpg) no-repeat;vertical-align:bottom;border: none;\">  </td>";


		echo "<td align=center style=\"width:5%;\">";
		if ($row['8'] == 0)
		echo "<input type=\"submit\" name=\"delete\" value=\" \" style=\"background:url(delete.jpg) no-repeat;vertical-align:bottom;border: none;\">";
		
		echo " </td></tr>";
		
		echo "</form>";

		echo "</tr>";


		
	}
	echo "</table>";

	echo "<form method=\"post\">";
	echo "<input type=\"hidden\" name=\"lastAccount\" value=\"" . $lastAccount  . "\">";
	echo "<br><input type=submit name=\"create\" value=\"Create New Pre-Authorised\"></td>";
	echo "</form>";


	if ((isset($_POST["update"])))
	{
		$verified = 0;
		if(!empty($_POST['checkbox']))
			$verified = 1;

		$i = $_POST['counter'];
		$id = $_POST['id'];
		//$date = $_POST['date'. $i];
		//$costPerUnit = $_POST['costPerUnit'. $i];
		$description = $_POST['description'. $i];
		$category = $_POST['category'. $i];
		$dateone = $_POST['dateone'. $i];
		$datetwo = $_POST['datetwo'. $i];
		$minAmount = $_POST['minAmount'. $i];
		$maxAmount = $_POST['maxAmount'. $i];
		$Account = $_POST['Account'. $i];
		

		//$sql = "UPDATE `purchase` SET `date` = '$date' WHERE (`id` = '$id')";
		//	$result=mysqli_query($con,$sql);
			//echo "<br>$sql<br>";

		$sql = "UPDATE `preauthorised` SET `verified` = '$verified' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);

		$sql = "UPDATE `preauthorised` SET `description` = '$description' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);
			
		$sql = "UPDATE `preauthorised` SET `Category` = '$category' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);	

		$sql = "UPDATE `preauthorised` SET `StartDate` = '$dateone' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);	

		$sql = "UPDATE `preauthorised` SET `EndDate` = '$datetwo' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);

		$sql = "UPDATE `preauthorised` SET `MinAmount` = '$minAmount' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);

		$sql = "UPDATE `preauthorised` SET `MaxAmount` = '$maxAmount' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);	

		$sql = "UPDATE `preauthorised` SET `Account` = '$Account' WHERE (`id` = '$id')";
			$result=mysqli_query($con,$sql);

			//echo "<br>$sql<br>";	

		//echo "<br><br><br>";
		//echo "UPDATE `preauthorised` SET `StartDate` = '$dateone' WHERE (`id` = '$id') <br>";
		//echo "UPDATE `preauthorised` SET `Category` = '$category' WHERE (`id` = '$id') <br>";

		echo "<br><br><br>";
		echo "<br>Click <a href=\"preauthorised.php\">HERE </a> to reload this page.";
	}

	if ((isset($_POST["delete"])))
	{
		$id = $_POST['id'];
		$i = $_POST['counter'];

		$sql = "DELETE FROM `preauthorised` WHERE (`id` = $id)";
		if ($result=mysqli_query($con,$sql))
		{
		    echo "<br><br>Field '$id' deleted successfully from table preauthorised.";

		   	$mydate = date("Y-m-d H:i:s");
		   	$mystring = $_POST['description'. $i] . ", ". $_POST['category'. $i] . ", ". $_POST['dateone'. $i] .", ". $_POST['datetwo'. $i] .", ". $_POST['minAmount'. $i]  .", ". $_POST['maxAmount'. $i]  .", ". $_POST['Account'. $i];

			$sql2 = "INSERT INTO `mylogs` (`actionTaken`, `dbTable`, `timeStamp`, `fullEntry`) VALUES ('remove', 'preauthorised', '$mydate' ,'$mystring')";
			$result2=mysqli_query($con,$sql2);		    
		}
		else
	    	echo "ERROR: Could not execute $sql. " . mysqli_error($con);

	    echo "<br><br><br>";
		echo "<br>Click <a href=\"preauthorised.php\">HERE </a> to reload this page.";
	}

	if ((isset($_POST["create"])))
	{

		$lastAccount = $_POST['lastAccount'];
		$sql2 = "INSERT INTO `preauthorised` (`Description`, `Account`, `StartDate`, `EndDate`, `MinAmount`, `MaxAmount`, `Category`, `verified`) VALUES ('AAAANew', '$lastAccount', '1970-01-01' ,'9999-12-31', 0,0,'None',0)";
			$result2=mysqli_query($con,$sql2);	

		echo "<br><br><br>";
		echo $sql2;
		echo "<br><br><br>";
		echo "<br>Click <a href=\"preauthorised.php\">HERE </a> to reload this page.";
	}

		//echo "<br><br><br>";
		//echo "<br>Click <a href=\"preauthorised.php\">HERE </a> to reload this page.";
?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table2_Props = 	{ 
							//rows_counter: true,  
		                    btn_reset: true,  
		                    loader: true,  
		                    loader_text: "Filtering data...", 
							col_1: "select", 							
							col_5: "none", 
							col_6: "none", 
							col_7: "none", 
							col_8: "none", 
							col_9: "none", 
							col_2: "select",							
							display_all_text: " [ Show all ] ",
							sort_select: true, 
							alternate_rows: true,
							rows_counter_text: "Total rows: ", 
							col_operation: {  
                                id: ["table2Tot1","table2Tot2"],  
                                col: [5,6],  
                                operation: ["sum","sum"],  
                                write_method: ["innerHTML","innerHTML"],  
                                exclude_row: [2,2],  
                                decimal_precision: [2,2]  
                            },   
                    		rows_always_visible: [2]  
						};
var tf2 = 	setFilterGrid( "table2",table2_Props );
//]]>


</script>


<script>
            
            function selectedRow()
            {
                
                var index,
                    table = document.getElementById("table2");
            
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                       // if(typeof index !== "undefined")
                      //  {
                      //     table.rows[index].classList.toggle("selected");
                     //   }
                        console.log(typeof index);
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected");
                        console.log(typeof index);
                     };
                }
                
            }

            selectedRow();
        </script>