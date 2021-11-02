<?php

include 'QuoteGetter.php';

MakeLibbedQuote();

function MakeLibbedQuote()
{
    $quoteObj = GetLibbedQuote();
    $posArr = $quoteObj->posArray;
    $posArrCount = count($posArr);
    echo $quoteObj->quote;
    $retArr = ProcessPOSArray($quoteObj->posArray);

    for ($i = 0; $i < $posArrCount; $i++)
    {
        echo $retArr[$i] . " ";
    }
    echo "\n\n";
}

function ProcessPOSArray($arr)
{
    // echo "\nPROCESSING POS ARRAY\n";
    
    // nouns, verbs, adjectives
    $tagsToCheck = array("NN", "NNS", "NNP", "NNPS", 
        "VB");//, "VBD", "VBG", "VBN", "VBP", "VBZ");
        // "JJ", "JJR", "JJS");

    $numPOSElems = 0;
    $arrCount = count($arr);

    $maxPOSElements = 3;
    if ($arrCount >= 15 && $arrCount < 25)
        $maxPOSElements = 6;
    else if ($arrCount >= 25)
        $maxPOSElements = 10;

    $returnArr = array();
    $normalArr = array();
    $matchedPOSArr = array();

    $prevMatchedIndex = -1;
    // for each element in the POS array
    for ($i = 0; $i < $arrCount; $i++)
    {
        // get text and tag
        $text = $arr[$i]['text'];
        $tag = $arr[$i]['tag'];

        // if tag = current tag to compare 
        if (in_array($tag, $tagsToCheck) &&
            $numPOSElems < $maxPOSElements &&
            $prevMatchedIndex != $i - 1)
        {
            $matchedPOSArr[$i] = $text; 
            $prevMatchedIndex = $i;
            // echo ("|| " . $text . "\n");
            $numPOSElems++;
            // echo ("\ntext: " . $text . '  tag: ' . $tag);
        }
        else 
        {
            $normalArr[$i] = $text;
        }
    }

    for ($j = 0; $j < $arrCount; $j++)
    {
        if (array_key_exists($j, $normalArr))
            $returnArr[$j] = $normalArr[$j];
        else if (array_key_exists($j, $matchedPOSArr))
            $returnArr[$j] = "___";
    }    

    echo "\n";

    return $returnArr;
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