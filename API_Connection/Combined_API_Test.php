<?php

include 'Quote_API_Test.php';
$quoteJSON = GetQuote();
$quote = $quoteJSON['content'];
$origin = $quoteJSON['originator'];
$quoteURL = $quoteJSON['url'];
echo "\n" . $quote . "\t\n" . $origin['name'] . "\t\n". $quoteURL ."\n\n";

include 'TextAnalysis_API_Test.php';
$analysisJSON = PerformTextAnalysis($quote);
// echo $analysisJSON['entities'];
