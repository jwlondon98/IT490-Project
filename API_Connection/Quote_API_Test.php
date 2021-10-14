<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://quotes15.p.rapidapi.com/quotes/random/",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: quotes15.p.rapidapi.com",
		"x-rapidapi-key: 858a670fb5msh2f906f02d058ee4p133dccjsn356293c3b633"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) 
{
	echo "cURL Error #:" . $err;
} 
else 
{
    $json = json_decode($response, true);
    $quote = $json['content'];
    $origin = $json['originator'];
    //$originJSON = json_decode($origin, true);
    //$author = $originJSON['name'];
	echo "\n" . $json['content'] . "\t\n" . $origin['name'] . "\n\n";
}