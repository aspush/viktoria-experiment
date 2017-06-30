<?php
include ("lib/common.php");

$reader = new Reader("resources/test1.txt", RowTest1::class);
$data1 = $reader->readAll();

$reader = new Reader("resources/test2.txt", RowTest2::class);
$data2 = $reader->readAll();
$data = [];
//dump($data1);
//dump($data2);


/** @var RowTest1 $row1 */
foreach($data1 as $row1) {
    /** @var RowTest2 $row2 */
    foreach($data2 as $row2) {
        if ($row1->getFIO() == $row2->getFio()) {
            $data[] = new PersonSummary($row1, $row2);
        }
    }
}

//dump ($data2);



?>
    <script src="https://code.jquery.com/jquery-git.js"></script>
    <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
    <link rel="stylesheet" type="text/css" href="https://mottie.github.io/tablesorter/css/theme.dropbox.css" />
    <link rel="stylesheet" type="text/css" href="https://mottie.github.io/tablesorter/css/theme.default.css" />

    <script>
        $(function(){
            $("#myTable").tablesorter({
                theme: "default"
            });
        });
    </script>

<table id="myTable">
    <thead>
        <tr>
            <?php
            foreach(PersonSummary::getColumns() as $column) {
                echo "<th>$column</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        /** @var PersonSummary $row */
        foreach($data as $row) {
            echo "<tr>";
            echo "<td>" . $row->getFio() . "</td>";
            echo "<td>" . $row->getAge() . "</td>";
            echo "<td>" . $row->getFamilyDescription() . "</td>";
            echo "<td>" . ($row->hasSiblings() ? "Да" : "Нет") . "</td>";
            echo "<td>" . ($row->hasFamilyProblems() ? "Да" : "Нет") . "</td>";
            echo "<td>" . ($row->getSex()==MALE ? "М" : "Ж") . "</td>";
            echo "<td>" . $row->getAcceptanceRejectionBall() . "</td>";
            echo "<td>" . $row->getAcceptanceRejectionPercentage() . "</td>";
            echo "<td>" . $row->getAcceptanceRejectionDescription() . "</td>";
            echo "<td>" . $row->getCooperationBall() . "</td>";
            echo "<td>" . $row->getCooperationPercentage() . "</td>";
            echo "<td>" . $row->getCooperationDescription() . "</td>";
            echo "<td>" . $row->getSymbiosisBall() . "</td>";
            echo "<td>" . $row->getSymbiosisPercentage() . "</td>";
            echo "<td>" . $row->getSymbiosisDescription() . "</td>";
            echo "<td>" . $row->getAuthoritarianHyperSocializationBall() . "</td>";
            echo "<td>" . $row->getAuthoritarianHyperSocializationPercentage() . "</td>";
            echo "<td>" . $row->getAuthoritarianHyperSocializationDescription() . "</td>";
            echo "<td>" . $row->getLittleLooserBall() . "</td>";
            echo "<td>" . $row->getLittleLooserPercentage() . "</td>";
            echo "<td>" . $row->getLittleLooserDescription() . "</td>";
            echo "<td>" . $row->getBallZakharov() . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php

// Что анализируем:
/**
 * 1 - выводим таблицу
 * 2 - среднее по каждому коэффициенту
 * 3 - среднее по группам
 *      по возрастам
 *      по полу
 *      по девочкам
 *
 * Желаемый результат: в экспериментальной группе баллы больше
 */

$all = function() {return true;};
$hasSiblings = function(PersonSummary $person) {return $person->hasSiblings();};
$hasNoSiblings = function(PersonSummary $person) {return !$person->hasSiblings();};

$hasSiblingsCorrection = function(PersonSummary $person) {return $person->hasSiblings() && !$person->hasFamilyProblems();};
$hasNoSiblingsCorrection = function(PersonSummary $person) {return !$person->hasSiblings() && !$person->hasFamilyProblems();};

$male = function(PersonSummary $person) {return $person->getSex()==MALE;};
$female = function(PersonSummary $person) {return $person->getSex()==FEMALE;};

$getterAcceptanceRejectionBall = function(PersonSummary $person) {return $person->getAcceptanceRejectionBall();};
$getterAcceptanceRejectionPercentage = function(PersonSummary $person) {return $person->getAcceptanceRejectionPercentage();};

$getterCooperationBall = function(PersonSummary $person) {return $person->getCooperationBall();};
$getterCooperationPercentage = function(PersonSummary $person) {return $person->getCooperationPercentage();};

$getterSymbiosisBall = function(PersonSummary $person) {return $person->getSymbiosisBall();};
$getterSymbiosisPercentage = function(PersonSummary $person) {return $person->getSymbiosisPercentage();};

$getterAuthoritarianHyperSocializationBall = function(PersonSummary $person) {return $person->getAuthoritarianHyperSocializationBall();};
$getterAuthoritarianHyperSocializationPercentage = function(PersonSummary $person) {return $person->getAuthoritarianHyperSocializationPercentage();};

$getterLittleLooserBall = function(PersonSummary $person) {return $person->getLittleLooserBall();};
$getterLittleLooserPercentage = function(PersonSummary $person) {return $person->getLittleLooserPercentage();};

$getterBallZakharov = function(PersonSummary $person) {return $person->getBallZakharov();};
$getterBallTemmel = function(PersonSummary $person) {return $person->getBallTemmel();};

echo "<br>";

//echo "балл Захаров, все<br>";
//AnalysisService::printAnalysis($data, $all, $getterBallZakharov);
//AnalysisService::printAnalysis($data, $all, $getterBallZakharov);
//echo "<br>";

echo "<h1>Без корректировкой на конфликт в семье, полная выборка</h1>";
AnalysisService::printScopeAnalysis("балл Захаров", $data, $hasSiblings, $hasNoSiblings, $getterBallZakharov);
AnalysisService::printScopeAnalysis("балл Тэмл", $data, $hasSiblings, $hasNoSiblings, $getterBallTemmel);
AnalysisService::printScopeAnalysis("Варга, параметр 1", $data, $hasSiblings, $hasNoSiblings, $getterAcceptanceRejectionBall);
AnalysisService::printScopeAnalysis("Варга, параметр 2", $data, $hasSiblings, $hasNoSiblings, $getterCooperationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 3", $data, $hasSiblings, $hasNoSiblings, $getterSymbiosisBall);
AnalysisService::printScopeAnalysis("Варга, параметр 4", $data, $hasSiblings, $hasNoSiblings, $getterAuthoritarianHyperSocializationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 5", $data, $hasSiblings, $hasNoSiblings, $getterLittleLooserBall);

echo "<h1>С корректировкой на конфликт в семье</h1>";
AnalysisService::printScopeAnalysis("балл Захаров", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterBallZakharov);
AnalysisService::printScopeAnalysis("балл Тэмл", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterBallTemmel);
AnalysisService::printScopeAnalysis("Варга, параметр 1", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterAcceptanceRejectionBall);
AnalysisService::printScopeAnalysis("Варга, параметр 2", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterCooperationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 3", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterSymbiosisBall);
AnalysisService::printScopeAnalysis("Варга, параметр 4", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterAuthoritarianHyperSocializationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 5", $data, $hasSiblingsCorrection, $hasNoSiblingsCorrection, $getterLittleLooserBall);

echo "<h1>С разбивкой по полу (эксперимент - М, контроль - Д)</h1>";
AnalysisService::printScopeAnalysis("балл Захаров", $data, $male, $female, $getterBallZakharov);
AnalysisService::printScopeAnalysis("балл Тэмл", $data, $male, $female, $getterBallTemmel);
AnalysisService::printScopeAnalysis("Варга, параметр 1", $data, $male, $female, $getterAcceptanceRejectionBall);
AnalysisService::printScopeAnalysis("Варга, параметр 2", $data, $male, $female, $getterCooperationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 3", $data, $male, $female, $getterSymbiosisBall);
AnalysisService::printScopeAnalysis("Варга, параметр 4", $data, $male, $female, $getterAuthoritarianHyperSocializationBall);
AnalysisService::printScopeAnalysis("Варга, параметр 5", $data, $male, $female, $getterLittleLooserBall);
//echo AnalysisService::avg($data, $hasSiblings, $getterBallTemml);

//    dump( AnalysisService::moda([1,2,3,2,3], function($a) {return true;}, function($a) {return $a;}));
//