<?php

require_once('LibbedQuoteMaker.php');

function GetLibbedQuote()
{
    include '../API_Connection/QuoteAPI.php';
    $quoteJSON = GetQuote();
    $quote = $quoteJSON['content'];
    $origin = $quoteJSON['originator'];
    $quoteURL = $quoteJSON['url'];

    include '../API_Connection/TextAnalysisAPI.php';
    $posArray = GetPOSArray($quote);
    $text = $posArray[0]['text'];
    $tag = $posArray[0]['tag'];

    return new QuoteObject($quote, $posArray);
}