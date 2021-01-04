<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/Chart.min.js"></script>
</head>
<body>
<div class="container">
	<canvas id="graph"></canvas>
</div>
<?php
$landesname = array();
$summecases = array();
$summetode = array();
$month = array();
$q = intval($_GET['q']);
$con = mysqli_connect('localhost','root','','covid19');
if (!$con) {
  die('Verbindungsfehler ' . mysqli_error($con));
}

mysqli_select_db($con,"covid19");
$sql="SELECT landesname, SUM(cases) AS summecases, SUM(deaths), month AS summetode FROM countriesandterritory, records, daterep WHERE landesname = '".$q."' AND records.recordID = countriesandterritory.countryID AND id = recordID GROUP BY landesname, month;";
$result = mysqli_query($con,$sql);
while($rows = $result->fetch_array()){
	$landesname = $rows['landesname'];
	$summecases = $rows['summecases'];
	$summetode = $rows['summetode'];
	$month = $rows['month'];
}
?>
<script>
var chartdata = {
				title: landesname,
				labels: month,
				datasets: [
					{
						label: "Gemeldete Infizierte",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: $summecases
					},
					{
						label: "Tote",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(79, 202, 70, 0.75)",
						borderColor: "rgba(79, 202, 70, 1)",
						pointHoverBackgroundColor: "rgba(79, 202, 70, 1)",
						pointHoverBorderColor: "rgba(59, 202, 70, 1)",
						data: $summetode
					}
				]
			};
			
			var ctx = $("#graph");
			
			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata,
				options: {
					title: {
						display: true,
						text: data[0].landesname
					}
				}
			});
</script>
<?php
mysqli_close($con);
?>
</body>
</html>