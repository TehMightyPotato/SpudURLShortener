<?php
if (isset($_GET["rd"])) {
  $shortUrl = $_GET["rd"];
  include("dblogin.php");

  $mysqli = new mysqli(dbhost, dbuser, dbpass, dbname);

  if (!$mysqli) {
    echo "ERROR";
  }

  function getRows($mysqli, $shortUrl)
  {
    $stmt = $mysqli->prepare("SELECT LongURL FROM urls WHERE ShortURL = ?");
    $stmt->bind_param("s", $shortUrl);
    $stmt->execute();
    $result = $stmt->get_result();
    $statistic = $result->fetch_all(MYSQLI_ASSOC);
    return $statistic;
  }

  $res = getRows($mysqli, $shortUrl);

  if (is_null($res) || !$res) {
    http_response_code(404);
    include('404.php');
    die();
  } else {
    $REDIR = $res[0]["LongURL"];
    echo "<script type='text/javascript'>document.location.href='{$REDIR}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $REDIR . '">';
  }
}
