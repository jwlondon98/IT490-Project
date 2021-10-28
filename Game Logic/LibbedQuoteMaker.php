<?php

include 'QuoteGetter.php';

MakeLibbedQuote();

function MakeLibbedQuote()
{
    $quoteObj = GetLibbedQuote();
    $posArr = $quoteObj->posArray;
    ProcessPOSArray($quoteObj->posArray);
}

function ProcessPOSArray($arr)
{
    echo "\nPROCESSING POS ARRAY\n";
    
    // $tagsToCheck = ("ADJ", "VERB", "NOUN", "PROPN");
    
    for ($i = 0; $i < count($arr); $i++)
    {
        $text = $arr[$i]['text'];
        $tag = $arr[$i]['tag'];
        echo ("\ntext: " . $text . '  tag: ' . $tag);
    }
    echo "\n";
}

class QuoteObject
{
    public $quote;
    public $posArray;

    function __construct($q, $arr)
    {
        $this->quote = $q;
        $this->posArray = $arr;
    }
}