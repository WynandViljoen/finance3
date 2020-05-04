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

	// Grpah for Net Salary Income
	for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$xaxis [$i - $startMonth] = date("Y-m-t", strtotime($year . "-". $month ."-01"));
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$expenseSeries[$i - $startMonth] = 0;
		}	

		$sql = "SELECT SUM(`total`), `month` FROM `incomeview` WHERE (`Income` LIKE 'income: Salary%') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] += number_format((float)$row['0'], 2, '.', '');
	
		$sql = "SELECT SUM(`total`), `month` FROM `expenseview` WHERE ((`Expense` LIKE 'expense: EI%') OR (`Expense` LIKE 'expense: CPP%') OR (`Expense` LIKE 'expense: Tax%')) GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] -= number_format((float)$row['0'], 2, '.', '');

		$sql = "SELECT SUM(`total`), `month` FROM `intoaccountview` WHERE (`Intoaccount` = 'long-term: Seaspan Pension') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] -= number_format((float)$row['0'], 2, '.', '');			

		$total = 0;
		$average = 0;

		for ($i=0;$i < count($expenseSeries); $i++)
			$total += $expenseSeries[$i];

		$average = $total / count($expenseSeries);
		$total = number_format((float)$total, 2);
		$average = number_format((float)$average, 2); 

		$myseries .= "name: 'Net Salary Income ($currencysymbol $total | $currencysymbol $average)" . "',";	
		$myseries .= " data: [";
		
		for ($i=0;$i < count($expenseSeries); $i++)
			$myseries .=  $expenseSeries[$i] . ", ";

		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";
		$myseries .= "visible: true";
		$myseries .= "}, {";


	// GRAPH FOR Non-payslip Expenses
	for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$xaxis [$i - $startMonth] = date("Y-m-t", strtotime($year . "-". $month ."-01"));
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$expenseSeries[$i - $startMonth] = 0;
		}	


		$sql = "SELECT SUM(`total`), `month` FROM `expenseview` WHERE (`Expense` NOT LIKE 'expense: EI%') AND (`Expense` NOT LIKE 'expense: CPP%') AND (`Expense` NOT LIKE 'expense: Tax%') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] = number_format((float)$row['0'], 2, '.', '');

		$total = 0;
		$average = 0;

		for ($i=0;$i < count($expenseSeries); $i++)
			$total += $expenseSeries[$i];

		$average = $total / count($expenseSeries);
		$total = number_format((float)$total, 2);
		$average = number_format((float)$average, 2); 

		$myseries .= "name: 'Net (Non-payslip) Expenses ($currencysymbol $total | $currencysymbol $average)" . "',";	
		$myseries .= " data: [";
		
		for ($i=0;$i < count($expenseSeries); $i++)
			$myseries .=  $expenseSeries[$i] . ", ";

		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";
		$myseries .= "visible: true";
		$myseries .= "}, {";


	// Graph for Net Salary Income - Net Expense
	for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$xaxis [$i - $startMonth] = date("Y-m-t", strtotime($year . "-". $month ."-01"));
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$expenseSeries[$i - $startMonth] = 0;
		}	

		$sql = "SELECT SUM(`total`), `month` FROM `incomeview` WHERE (`Income` LIKE 'income: Salary%') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] += number_format((float)$row['0'], 2, '.', '');
	
		$sql = "SELECT SUM(`total`), `month` FROM `expenseview` WHERE ((`Expense` LIKE 'expense: EI%') OR (`Expense` LIKE 'expense: CPP%') OR (`Expense` LIKE 'expense: Tax%')) GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] -= number_format((float)$row['0'], 2, '.', '');

		$sql = "SELECT SUM(`total`), `month` FROM `intoaccountview` WHERE (`Intoaccount` = 'long-term: Seaspan Pension') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] -= number_format((float)$row['0'], 2, '.', '');			

		$sql = "SELECT SUM(`total`), `month` FROM `expenseview` WHERE (`Expense` NOT LIKE 'expense: EI%') AND (`Expense` NOT LIKE 'expense: CPP%') AND (`Expense` NOT LIKE 'expense: Tax%') GROUP BY `month` ASC";
		if ($result=mysqli_query($con,$sql))
		while ($row=mysqli_fetch_row($result))
			if (is_numeric(array_search($row['1'],$yearmonth)))
				$expenseSeries[array_search($row['1'],$yearmonth)] -= number_format((float)$row['0'], 2, '.', '');			

		$total = 0;
		$average = 0;

		for ($i=0;$i < count($expenseSeries); $i++)
			$total += $expenseSeries[$i];

		$average = $total / count($expenseSeries);
		$total = number_format((float)$total, 2);
		$average = number_format((float)$average, 2); 

		$myseries .= "name: 'Net Salary Income - Net Expense ($currencysymbol $total | $currencysymbol $average)',";	
		$myseries .= " data: [";
		
		for ($i=0;$i < count($expenseSeries); $i++)
			$myseries .=  $expenseSeries[$i] . ", ";

		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";
		$myseries .= "visible: true";


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
