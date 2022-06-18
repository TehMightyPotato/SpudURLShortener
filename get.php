<?php
$url = $_POST["longUrl"];
include("dblogin.php");

$mysqli = new mysqli(dbhost, dbuser, dbpass, dbname);


if (!$mysqli) {
  echo "ERROR";
}


function getRows($mysqli, $longURL)
{
  $stmt = $mysqli->prepare("SELECT * FROM urls WHERE LongURL = ?");
  $stmt->bind_param("s", $longURL);
  $stmt->execute();
  $result = $stmt->get_result();
  $statistic = $result->fetch_all(MYSQLI_ASSOC);
  return $statistic;
}

$res = getRows($mysqli, $url);

print json_encode($res);
die();
