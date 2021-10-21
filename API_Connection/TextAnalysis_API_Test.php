<?php

function PerformTextAnalysis ($quote)
{
	$curl = curl_init("https://api.nlpcloud.io/v1/en_core_web_lg/entities");


	$txtArr = array("text"=>$quote);
	$data = json_encode($txtArr);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		"content-type: application/json",
		"Authorization: Token 306c129e4a83f43155c16b646847edc2f069e8af"	],
	);


	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) 
		echo "cURL Error #:" . $err;
	else 
	{
		echo "QUOTEEEE: " . $quote;
		echo $response;
	}
}