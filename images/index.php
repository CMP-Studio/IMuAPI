<?php
require_once __DIR__ . "/../util/api.php";
require_once __DIR__ . "/../util/imuSearch.php";
require_once __DIR__ . "/../config.php";

$server = emuServer();
$port = emuPort();
$search = new imuSearch($server, $port);
try {
  $search->connect();
} catch (Exception $e) {
  sendError(503);
}



if(isset($_GET["irn"]))
{
  $irn = $_GET["irn"];
}
else
{
 sendError(400);
}

$columns = array("image.resource{source:master}");

$terms = array("irn", "$irn");
try {
  $res = $search->search("ecatalogue",$columns,$terms);
} catch (Exception $e) {
  //echo "$e";
 sendError(406);
}


if(isset($res->rows[0]["image"]["resource"]))
{
  $img = $res->rows[0]["image"]["resource"];
}
else
{
 sendError(404);
}
$temp_img = tempnam(sys_get_temp_dir(), 'IMU');
saveImg($temp_img, $img);

$fn = $img["identifier"];
$mime = $img["mimeFormat"];

sendImage($temp_img,$mime,$fn);

function saveImg($newloc, $image)
{
  // Save a copy of the resource
  $temp = $image['file'];
  $copy = fopen( $newloc, 'wb');
  for (;;)
  {
     $data = fread($temp, 4096); // read 4K at a time
     if ($data === false || strlen($data) == 0)
     break;
     fwrite($copy, $data);
  }
  fclose($copy);
}

function sendImage($location, $mime, $filename)
{
  $mimeFull = "image/$mime";

  header("Content-Type: $mimeFull");
  header("Content-Disposition: attachment; filename=\"$filename\"");
  readfile($location);
}
function sendError($code)
{
  header($_SERVER["SERVER_PROTOCOL"] . " $code", TRUE, $code);
  die();
}
 ?>
