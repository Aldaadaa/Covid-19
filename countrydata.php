<?php
//header = json
header('Content-Type: application/json');

//database login
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'covid19');

//connection to database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//Abfrage
$query = sprintf("SELECT landesname, SUM(cases) AS summecases, SUM(deaths) AS summetode FROM countriesandterritory, records WHERE records.recordID = countriesandterritory.countryID GROUP BY landesname;");

$result = $mysqli->query($query);

//Zurückgegebene Daten speichern
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//print out results
print json_encode($data);