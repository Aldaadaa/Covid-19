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
$query = sprintf("SELECT landesname, SUM(cases) AS summecases, SUM(deaths), month AS summetode FROM countriesandterritory, records, daterep WHERE landesname <> 'Brazil' AND records.recordID = countriesandterritory.countryID AND id = recordID GROUP BY landesname, month;");

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