<?php

@ob_start(PHP_OUTPUT_HANDLER_CLEANABLE, PHP_OUTPUT_HANDLER_REMOVABLE);
$libDir = dirname(__FILE__)."/../libs/";
$cfgDir = dirname(__FILE__)."/../cfg/";

require_once($libDir.'path.inc');
require_once($libDir.'get_host_info.inc');
require_once($libDir.'rabbitMQLib.inc');
require_once($libDir.'logger.inc');

//$logger = new LoggerClient(__FILE__);
//set_error_handler(array($logger, 'onError'));
//$logger->logg("test Log");
$client = new rabbitMQClient($cfgDir."testRabbitMQ.ini","testClient");//Check this part in the .ini file

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = $_POST["type"];
$request['username'] = $_POST['username'];
$request['password'] = $_POST['password'];
$request['bnet'] = $_POST['bnet'];
$response = $client->send_request($request);
//$response = $client->publish($request);
@ob_end_clean();
//print_r($response);
$test = "testResponse";
echo json_encode($response);
exit(0);
?>
