<?php
include("Reader.php");
include("RowTest1.php");
include("RowTest2.php");
include("RowTest3.php");
include("PersonSummary.php");
include("analysis/AnalysisService.php");

define("MALE", 1);
define("FEMALE", 2);

function dump($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

function dump_($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}