#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('deploymentRabbit.inc');

require_once('RabbitLogger/490Logger.php');

require_once('getDB.php');

function processCreate($packageName, $version, $lastUpdate)
{
    echo "CREATE:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL.$lastUpdate.PHP_EOL;
}

function processFail($packageName, $version)
{
    echo "FAIL:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
}

function processRollback($packageName, $version)
{
    echo "ROLLBACK:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
}

function processInstall($packageName, $version)
{
    echo "INSTALL:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
}



function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "create":
      return processCreate($request['packageName'],$request['version'],$request['lastUpdate']);
    case "fail":
      return processFail($request['packageName'],$request['version']);
    case "rollback":
      return processRollback($request['packageName'],$request['version']);
    case "install":
      return processInstall($request['packageName'],$request['version']);
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}



$logger = new rabbitLogger("RabbitLogger/logger.ini", "testListener");
$server = new deploymentListener("deploymentConn.ini","deploymentServer");

$foundDB = true;

$GLOBALS['logger'] = $logger;


$db = getDB();




if (!isset($db)) 
{
    $logger->log_rabbit('Error', 'Game database in dbServer not connected. Is the server up?');
    echo 'Game database in dbServer not connected. Is the server up?'.PHP_EOL;
    $foundDB = false;
    
    //exit();
}
else
{
    $GLOBALS['db'] = $db;
}


if($foundDB == false)
{
    exit();
}

echo "Started deployment listener".PHP_EOL;

$server->process_requests('requestProcessor');

?>
