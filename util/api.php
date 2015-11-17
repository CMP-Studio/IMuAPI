<?php


function formatResponse($data)
{
  //Setup headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Max-Age: 3628800');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  if(array_key_exists('callback', $_GET))
  {
    // JSONP
      header('Content-Type: text/javascript; charset=utf8');
      $callback = $_GET['callback'];
      return $callback.'('.$data.');';

  }else{
      // JSON
      header('Content-Type: application/json; charset=utf8');
      return $data;
  }
}


 ?>
