o#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function getQuote()
{

    //gets a new random quote from the quote API
    $quote;
    
    //not sure what format the quote is going to be in, but
    //if it's in the format of a string for the quote and and
    //array for all of the removed word tokens, return a list of the tokens
    $tokens;
    
    //preferably, with both of these, I should be able to just run getQuote and put that
    //into the game direcly

    return array("quote" => $quote, "quoteTokens" => $tokens);

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
      return doLogin();
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}

$server = new rabbitMQServer("apiConn.ini","apiServer");

$server->process_requests('requestProcessor');
exit();
?>

