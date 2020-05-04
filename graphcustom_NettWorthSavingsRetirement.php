<!DOCTYPE HTML>
<html>
	<head>
    </head>
    <body>
        <script src="js/jquery-1.9.1.min.js"></script>
        <script language="javascript" type="text/javascript" src="datepicker.js"></script>
		<style type="text/css" media="screen">
			@import "datepicker.css";
		</style>
<?php
	
	include("header.html");
	include("graphheading.php");

	$myseries = "";

	// ONLY ADD Net Worth Graph
	$sql2 = "SELECT SUM(`Balance`) FROM `accounts`";
	if ($result2=mysqli_query($con,$sql2))
	while ($row2=mysqli_fetch_row($result2))
	{
		$NetWorth = $row2['0'];
	}

	for ($i=$startMonth; $i <= $counter; $i++)
	{
		$year = floor($startYear + ($i / 12));
		$month = $i % 12;
		$dateString = $year . "-". $month ."-01"; 
		$startdate = date("Y-m-d", strtotime($dateString));
		$enddate = date("Y-m-t", strtotime($dateString));
		$xaxis [$i - $startMonth] = $enddate;
		$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
		$expenseTotal = 0;
		$balance = 0;
		$currentbalance[$i - $startMonth] = $NetWorth;
	}

		$sql = "SELECT `total`, `month` FROM `incomeaccountview` ORDER BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))	
			if (is_numeric(array_search($row['1'],$yearmonth)))
			{
				for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
					$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');
			}
			else if ($row['1'] < $yearmonth[0])
				for ($i=0;$i < count($yearmonth); $i ++)
					$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');	

		$sql = "SELECT `total`, `month` FROM `expenseaccountview` ORDER BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
			{
				for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
					$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');	
			}
			else if ($row['1'] < $yearmonth[0])
				for ($i=0;$i < count($yearmonth); $i ++)
					$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');		
				
		$lastvalue = $currentbalance[count($currentbalance) - 1];

		$myaverage = number_format(($lastvalue - $currentbalance[0]) / (count($currentbalance) - 1), 2);

		$lastvalue = number_format((float)$lastvalue, 2); 

		$myseries .= "name: 'Net Worth ($currencysymbol $lastvalue | $currencysymbol $myaverage)" . "',";	
		$myseries .= " data: [";
	
		for ($i=0;$i < count($currentbalance); $i++)
		{
			$currentbalance[$i] = number_format((float)$currentbalance[$i], 2, '.', '');
			$myseries .=  $currentbalance[$i] . ", ";
		}
		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";

	$myseries .= "visible: true";
	$myseries .= "}, {";


	// ADD SAVINGS Graph
	$sql2 = "SELECT SUM(`Balance`) FROM `accounts` WHERE ((`Account` LIKE '%Savings') OR (`Account` LIKE '%TFSA'))";
	if ($result2=mysqli_query($con,$sql2))
	while ($row2=mysqli_fetch_row($result2))
	{
		$Savings = $row2['0'];
	}

	for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$dateString = $year . "-". $month ."-01"; 
			$startdate = date("Y-m-d", strtotime($dateString));
			$enddate = date("Y-m-t", strtotime($dateString));
			$xaxis [$i - $startMonth] = $enddate;
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$expenseTotal = 0;
			$balance = 0;
			$currentbalance[$i - $startMonth] = $Savings;
		}

			$sql = "SELECT `total`, `month` FROM `intoaccountview` WHERE ((`IntoAccount` LIKE '%Savings') OR (`IntoAccount` LIKE '%TFSA')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{	
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');		
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');		


			$sql = "SELECT `total`, `month` FROM `fromaccountview` WHERE ((`FromAccount` LIKE '%Savings') OR (`FromAccount` LIKE '%TFSA')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');				
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');

			$sql = "SELECT `total`, `month` FROM `incomeaccountview` WHERE ((`Account` LIKE '%Savings') OR (`Account` LIKE '%TFSA')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))	
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');	

			$sql = "SELECT `total`, `month` FROM `expenseaccountview` WHERE ((`Account` LIKE '%Savings') OR (`Account` LIKE '%TFSA')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');	
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');	
				
	
		$lastvalue = $currentbalance[count($currentbalance) - 1];
		$myaverage = number_format(($lastvalue - $currentbalance[0]) / (count($currentbalance) - 1), 2);
		$lastvalue = number_format((float)$lastvalue, 2); 

		$myseries .= "name: 'Savings ($currencysymbol $lastvalue | $currencysymbol $myaverage)" . "',";	
		$myseries .= " data: [";
	
		for ($i=0;$i < count($currentbalance); $i++)
		{
			$currentbalance[$i] = number_format((float)$currentbalance[$i], 2, '.', '');
			$myseries .=  $currentbalance[$i] . ", ";
		}
		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";

	$myseries .= "visible: true";
	$myseries .= "}, {";


	// ADD Retirement Graph
	$sql2 = "SELECT SUM(`Balance`) FROM `accounts` WHERE ((`Account` LIKE '%RRSP') OR (`Account` LIKE '%Pension'))";
	if ($result2=mysqli_query($con,$sql2))
	while ($row2=mysqli_fetch_row($result2))
	{
		$Retirement = $row2['0'];
	}

	for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$dateString = $year . "-". $month ."-01"; 
			$startdate = date("Y-m-d", strtotime($dateString));
			$enddate = date("Y-m-t", strtotime($dateString));
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$xaxis [$i - $startMonth] = $enddate;
			$expenseTotal = 0;
			$balance = 0;
			$currentbalance[$i - $startMonth] = $Retirement;
		}

			$sql = "SELECT `total`, `month` FROM `intoaccountview` WHERE ((`IntoAccount` LIKE '%RRSP') OR (`IntoAccount` LIKE '%Pension')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{	
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');		
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');		


			$sql = "SELECT `total`, `month` FROM `fromaccountview` WHERE ((`FromAccount` LIKE '%RRSP') OR (`FromAccount` LIKE '%Pension')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');				
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');

			$sql = "SELECT `total`, `month` FROM `incomeaccountview` WHERE ((`Account` LIKE '%RRSP') OR (`Account` LIKE '%Pension')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))	
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] += number_format((float)$row['0'], 2, '.', '');	

			$sql = "SELECT `total`, `month` FROM `expenseaccountview` WHERE ((`Account` LIKE '%RRSP') OR (`Account` LIKE '%Pension')) ORDER BY `month` ASC";
			if ($result=mysqli_query($con,$sql))
			while ($row=mysqli_fetch_row($result))
				if (is_numeric(array_search($row['1'],$yearmonth)))
				{
					for ($i = array_search($row['1'],$yearmonth); $i < count($yearmonth) ; $i++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');	
				}
				else if ($row['1'] < $yearmonth[0])
					for ($i=0;$i < count($yearmonth); $i ++)
						$currentbalance[$i] -= number_format((float)$row['0'], 2, '.', '');	
	
		$lastvalue = $currentbalance[count($currentbalance) - 1];
		$myaverage = number_format(($lastvalue - $currentbalance[0]) / (count($currentbalance) - 1), 2);		
		$lastvalue = number_format((float)$lastvalue, 2); 

		$myseries .= "name: 'Retirement ($currencysymbol $lastvalue | $currencysymbol $myaverage)" . "',";	
		$myseries .= " data: [";
	
		for ($i=0;$i < count($currentbalance); $i++)
		{
			$currentbalance[$i] = number_format((float)$currentbalance[$i], 2, '.', '');
			$myseries .=  $currentbalance[$i] . ", ";
		}
		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";

		$myseries .= "visible: true";
	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

	$myXaxisString = "[";

	for ($i=0;$i < count($xaxis); $i++)
	{
		$myXaxisString .= "'" . $xaxis[$i] . "', ";
	}
	$myXaxisString = rtrim($myXaxisString, ", ");
	$myXaxisString .= "]";

?>


 <script src="js/jquery-1.9.1.min.js"></script>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">

$(function () {
	$('#container').highcharts({

    title: {
        text: 'Graph of All Expenses (Total | Average per month where applicable)'
    },

    yAxis: {
        title: {
            text: 'Total for Month'
        }
    },
    xAxis: {
        categories: <?php echo $myXaxisString; ?>
    },
    

    legend: {
        layout: 'horizontal',
        align: 'left',
        verticalAlign: 'bottom'
    },

   

    series: [{
        <?php echo $myseries; ?>
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 900
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
    });
});

</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
		
<figure class="highcharts-figure">
    <div id="container" style="height: 700px"></div>
</figure>

	</body>
</html>
