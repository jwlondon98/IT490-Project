<?php

// API REF: https://docs.nlpcloud.io/?shell#introduction



// Gets tagged Parts of Speech array for quote
function GetPOSArray ($quote)
{
	$curl = curl_init("https://api.nlpcloud.io/v1/en_core_web_lg/dependencies");

	$txtArr = array("text"=>$quote);
	$data = json_encode($txtArr);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		"content-type: application/json",
		"Authorization: Token 2fbd29996b463d904614a3a799aa962113677eef"	],
	);


	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) 
		echo "cURL Error #:" . $err;
	else 
	{
		$jsonResponse = GetJSONFromResponse($response);
		return $jsonResponse['words'];
	}
}

function GetJSONFromResponse($response)
{
	$startIndex = strpos($response, "words") - 2;
	$length = strlen($response) - $startIndex;
	// echo "RESPONSE:\n" . $response . "\n\n";
	$retStr = substr($response, $startIndex, $length);
	// echo "RETURN STRING:\n" . $retStr . "\n\n";
	return json_decode($retStr, true);
}
