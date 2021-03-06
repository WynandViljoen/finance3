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
	$xaxis = [];
	$expenseSeries = [];

	$sql2 = "SELECT DISTINCT `Income` FROM `incomeview`";
	if ($result2=mysqli_query($con,$sql2))
	while ($row2=mysqli_fetch_row($result2))
	{
		$objectId = $row2['0'];
		
		for ($i=$startMonth; $i <= $counter; $i++)
		{
			$year = floor($startYear + ($i / 12));
			$month = $i % 12;
			$xaxis [$i - $startMonth] = date("Y-m-t", strtotime($year . "-". $month ."-01"));
			$yearmonth [$i - $startMonth] = date("Y-m", strtotime($year . "-". $month ."-01"));
			$expenseSeries[$i - $startMonth] = 0;
		}	

		$sql = "SELECT `total`, `month` FROM `incomeview` WHERE (`Income` = '" . $objectId . "') ORDER BY `month` ASC";
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

		$myseries .= "name: '" . $objectId . " ($currencysymbol $total | $currencysymbol $average)" . "',";	
		$myseries .= " data: [";
		
		for ($i=0;$i < count($expenseSeries); $i++)
			$myseries .=  $expenseSeries[$i] . ", ";

		$myseries = rtrim($myseries, ", ");
		$myseries .= "], ";
		$myseries .= "visible: false";
		$myseries .= "}, {";
	}
	$myseries = rtrim($myseries, "}, {");


	$myXaxisString = "[";

	for ($i=0;$i < count($xaxis); $i ++)
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
        text: 'Graph of All Incomes (Total | Average per month)'
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
