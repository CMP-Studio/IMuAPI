<?php
require_once "/var/www/html/imu-api/IMu.php";
require_once IMu::$lib . '/Session.php';
require_once IMu::$lib . '/Module.php';

class imuSearch
{


  private $server;
  private $port;

  private $session;

  public function __construct($serverURL, $serverPort)
  {
    $this->server = $serverURL;
    $this->port = $serverPort;
  }

  public function version()
  {
    return IMu::VERSION;
  }

  public function connect()
  {
    try
    {
      $this->session = new IMuSession($this->server, $this->port);
      $this->session->connect();
      return true;
    }
    catch (Exception $e)
    {
      throw $e;
    }
    return false;
  }

  public function search($module, $columns, $terms=null)
  {
    try
    {
      $mod = new IMuModule($module, $this->session);
      if(isset($terms))
      {
        $mod->findTerms($terms);
      }
      else
      {
          $mod->findTerms("irn", "-1", '>'); //Should match everything
      }
      $itt = 100;
      //Fetch all
      $bigresult = new stdClass();
      $bigresult->rows = array();
      $offset = 0;
      do {

        $result = $mod->fetch('start', $offset, $itt, $columns);
        $bigresult->rows = array_merge($bigresult->rows, $result->rows);
        $offset += $itt;
        print "$offset\n";

      } while ($result->count == $itt);

      return $bigresult;
    }
    catch (Exception $e)
    {
      throw $e;
    }
    return null;

  }




}




?>
