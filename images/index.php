<?php
require_once __DIR__ . "/../util/api.php";
require_once __DIR__ . "/../util/imuSearch.php";
require_once __DIR__ . "/../config.php";

$server = emuServer();
$port = emuPort();
$search = new imuSearch($server, $port);
$search->connect();

if(isset($_GET["irn"]))
{
  $irns = $_GET["irn"];
  $irn = explode(',', $irns);
}
else
{
  exit();
}
$images = array();
$columns = array("image.resource{source:master}");
foreach ($irn as $key => $i)
{
  $terms = array("irn", "$i");
  try {
    $res = $search->search("ecatalogue",$columns,$terms);
  } catch (Exception $e) {
    $res = null;
  }
  $images[] = $res;
}

var_dump($res);
 ?>
