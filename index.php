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
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/Chart.min.js"></script>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<meta charset="utf-8">
	<title>Covid Datenbank</title>
	<div class="topnav">
		<a href="/covid_database/index.php">Home</a>
		<a href="/covid_database/top5.html">Meiste Infizierte</a>
		<a href="/covid_database/bottom5.html">Wenigste Infizierte</a>
		<a href="/covid_database/singleCountry.php">Einzelnes Land</a>
		<a href="/covid_database/linegraph.html">Gesamte Fälle</a>
	</div>
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
</body>
</html>