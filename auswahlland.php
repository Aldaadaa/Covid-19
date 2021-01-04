<?php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'covid19');
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

?>

<!doctype HTML>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="mystyle.css">
		<div class="topnav">
			<a href="/covid_database/index.php">Home</a>
			<a href="/covid_database/top5.html">Meiste Infizierte</a>
			<a href="/covid_database/bottom5.html">Wenigste Infizierte</a>
			<a href="/covid_database/singleCountry.php">Einzelnes Land</a>
			<a href="/covid_database/linegraph.html">Gesamte Fälle</a>
		</div>
		<title>Infizierte und Tote</title>
		<style>
			.chart-container {
				width: 640px;
				height: auto;
			}
		</style>
	</head>
	<body>
		<div>
			<?php
				$laender = $mysqli->query("SELECT DISTINCT landesname FROM countriesandterritory;");
			?>
			<br>
			<form name="form" action="auswahlland.php" method="post">
			<label id="auswahl">Wählen Sie ein Land aus: </label>
			<select name="land">

			<?php
			while($rows = $laender->fetch_array()){
				$landesname = $rows['landesname'];
				echo "<option value='".$landesname."'>$landesname</option>";	
			}
			?>
			</select>
			<input type="submit" name="button" value="Abfragen"/>
			</form>
			</div>

		<div class="chart-container">
			<canvas id="countrycanvas"></canvas>
		</div>
		<?php
			$land = $_POST["land"];
		?>
		<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
		<script type="text/javascript"><!--
			var auswahl ="<?php echo $land ?>";
			$(document).ready(function(){
				$.ajax({
					url : ("http://localhost/covid_database/datafunction.php?land="+auswahl),
					type : "GET",
					success : function(data){
						console.log(data);
						var landesname = [];
						var summecases = [0, 0, 0, 0, 0, 0, 0];
						var summetode = [0, 0, 0, 0, 0, 0, 0];
						var month = [12, 1, 2, 3, 4, 5, 6];
						var erster = data[0].month;
						if(erster == 12){
							erster = 0;
						}
						var k = erster;
			
						for(var i in data){
							landesname.push(data[i].landesname);
							summecases[k] = data[i].summecases;
							summetode[k] = data[i].summetode;
							k++;
						}
			
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
									data: summecases
								},
								{
									label: "Tote",
									fill: false,
									lineTension: 0.1,
									backgroundColor: "rgba(79, 202, 70, 0.75)",
									borderColor: "rgba(79, 202, 70, 1)",
									pointHoverBackgroundColor: "rgba(79, 202, 70, 1)",
									pointHoverBorderColor: "rgba(59, 202, 70, 1)",
									data: summetode
								}
							]
						};
			
			var ctx = $("#countrycanvas");
			
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

		},
		error : function(data) {
			
		}
	})
});

		</script>
		<h4>Fehlende Angaben wurden mit 0 aufgefüllt.</h4>
	</body>
</html>