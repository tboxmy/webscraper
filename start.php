<?php

require 'vendor/autoload.php';
$htmlcontent = file_get_contents('source/datahtml.dat');
// echo $htmlcontent;
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlcontent);
libxml_clear_errors();
$xpath = new DOMXPath($doc);

$i = 0;
$tds = array();
$output = fopen('output/results.csv', 'w') or die("Unable to open file!");
foreach($xpath->query('//tbody[@id="mytable"]/tr/td/text()') as $td) {
    /* 30 is each row's old-cell-count */

    $tds[] = $td->nodeValue;
    /* 3 is each cell's old-cell-count */
    if($i % 9 == 8) {
        echo implode(",", $tds)."\n";
        fputcsv($output, $tds);
        $tds = array(); // initialise
    }
    // if($i % 30 == 29) {
    //     echo "!!\n";
    // }
    $i++;
}
fclose($output);
