#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('LibbedQuoteMaker.php');

// returns an array in which each element is a word in a random quote
// an element can be a parts of speech tag (in all caps) which will identify
// a blank space where text can be inputted by a player for the lib
function getQuoteRabbit()
{
  return MakeLibbedQuote();
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
    case "getQuote":
      return getQuoteRabbit();
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}

$server = new rabbitMQServer("apiConn.ini","apiServer");

$server->process_requests('requestProcessor');
exit();
?>

