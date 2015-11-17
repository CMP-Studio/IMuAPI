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

$columns = array("resource");

$terms = array("irn", "$irn");
try {
  $res = $search->search("emultimedia",$columns,$terms);
} catch (Exception $e) {
  //echo $e;
 sendError(406);
}

if(isset($res->rows[0]["resource"]))
{
  $media = $res->rows[0]["resource"];
}
else
{
 sendError(404);
}
$temp_file = tempnam(sys_get_temp_dir(), 'IMU');
saveFile($temp_file, $media);

$fn = $media["identifier"];
$mime = $media["mimeType"] . "/" .  $media["mimeFormat"];

sendFile($temp_file,$mime,$fn);

function saveFile($newloc, $file)
{
  // Save a copy of the resource
  $temp = $file['file'];
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

function sendFile($location, $mime, $filename)
{

  header("Content-Type: $mime");
  header("Content-Disposition: attachment; filename=\"$filename\"");
  readfile($location);
}
function sendError($code)
{
  header($_SERVER["SERVER_PROTOCOL"] . " $code", TRUE, $code);
  die();
}
 ?>
