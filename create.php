<?php
$url = $_POST["longUrl"];
$shortUrl = $_POST["shortUrl"];
include("dblogin.php");



$mysqli = new mysqli(dbhost, dbuser, dbpass, dbname);


if (!$mysqli) {
  echo "ERROR";
}


function createEntry($mysqli ,$longURL, $shortUrl){
  $stmt = $mysqli->prepare("INSERT INTO urls (LongURL, ShortURL) VALUES(?,?)");
  $stmt->bind_param("ss", $longURL, $shortUrl);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
}

$res = createEntry($mysqli, $url, $shortUrl);

print json_encode($res);
die();
?>