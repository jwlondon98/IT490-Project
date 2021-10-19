<?php

function PerformTextAnalysis ($quote)
{
	$curl = curl_init();
	
	curl_setopt_array($curl, [
		CURLOPT_URL => "https://text-analysis12.p.rapidapi.com/ner/api/v1.1",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\n    \"language\": \"english\",\n    \"text\": \" . $quote .\\n\"\n}",
		CURLOPT_HTTPHEADER => [
			"content-type: application/json",
			"x-rapidapi-host: text-analysis12.p.rapidapi.com",
			"x-rapidapi-key: 858a670fb5msh2f906f02d058ee4p133dccjsn356293c3b633"
		],
	]);
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		echo $response;
	}
}