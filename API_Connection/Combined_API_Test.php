<?php

include 'Quote_API_Test.php';
$quoteJSON = GetQuote();
$quote = $quoteJSON['content'];
$origin = $quoteJSON['originator'];
$quoteURL = $quoteJSON['url'];
echo "\n" . $quote . "\t\n" . $origin['name'] . "\t\n". $quoteURL ."\n\n";

include 'TextAnalysis_API_Test.php';
$analysisArray = PerformTextAnalysis($quote);
ProcessAnalysisArray($analysisArray);

function ProcessAnalysisArray($arr)
{
    echo "\nANALYSIS ARRAY PROCESSING START";
    for ($i = 0; $i < count($arr); $i++)
    {
        $text = $arr[$i]['text'];
        $tag = $arr[$i]['tag'];
        echo ("\ntext: " . $text . '  tag: ' . $tag);
    }
    echo "\n";
}
