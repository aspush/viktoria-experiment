<?php

class AnalysisService {
    public static function count($persons, $filter)
    {
        $filtered = array_filter($persons, $filter);
        return count($filtered);
    }

    /**
     * Среднее арифметическое
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float
     */
    public static function avg($persons, $filter, $getter)
    {
        $filtered = array_filter($persons, $filter);
        $filteredMapped = array_map($getter, $filtered);

        return array_sum($filteredMapped) / count($filteredMapped);
    }

    /**
     * Медиана
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float
     */
    public static function mediana($persons, $filter, $getter)
    {
        $filtered = array_filter($persons, $filter);
        $filtered = array_map($getter, $filtered);

        sort($filtered, SORT_NUMERIC);

        if (count($filtered)%2 === 0) {
            $middle = (int)(count($filtered) / 2);
            return ($filtered[ $middle-1 ] + $filtered[ $middle ]) / 2;
        }
        else {
            $middle = count($filtered) / 2;
            return $filtered[ (int)floor( $middle ) ];
        }
    }

    /**
     * Мода
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float[]
     */
    public static function moda($persons, $filter, $getter)
    {
        $filtered = array_filter($persons, $filter);
        $filtered = array_map($getter, $filtered);

        $valuesCount = [];
        $result = [];

        foreach($filtered as $val) {
            if (!isset($valuesCount[$val])) {
                $valuesCount[$val] = 1;
            }
            else {
                $valuesCount[$val]++;
            }
        }

        $max = max($valuesCount);

        foreach($valuesCount as $val=>$count) {
            if ($count===$max) {
                $result[] = $val;
            }
        }

        sort($result);

        return $result;
    }

    /**
     * Средне квадратичное отклонение по ГОСТ
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float
     */
    public static function sko($persons, $filter, $getter)
    {
        $filtered = array_filter($persons, $filter);
        $filtered = array_map($getter, $filtered);

        $avg = self::avg($persons, $filter, $getter);

        $n = count($filtered) <= 30 ? (count($filtered) - 1) : count($filtered);

        $result = sqrt(
            array_sum(
                array_map(function($a) use ($avg) {
                    return ($a - $avg) * ($a - $avg);
                }, $filtered)
            ) / $n
        );

        return $result;
    }

    /**
     * Коэффициент вариации
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float
     */
    public static function Cv($persons, $filter, $getter)
    {
        $sko = self::sko($persons, $filter, $getter);
        $avg = self::avg($persons, $filter, $getter);

        return $sko / $avg;
    }

    /**
     * Средняя ошибка средней арифметической
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     * @internal param $method
     * @return float
     */
    public static function m($persons, $filter, $getter)
    {
        $filtered = array_filter($persons, $filter);
        $filtered = array_map($getter, $filtered);

        $n = count($filtered) <= 30 ? (count($filtered) - 1) : count($filtered);
        $sko = self::sko($persons, $filter, $getter);

        return $sko / sqrt($n);
    }

    public static function tCriteriaStudent($avg1, $avg2, $m1, $m2)
    {
        return abs($avg1 - $avg2) / sqrt($m1*$m1 + $m2*$m2);
    }

    public static function formatFloat($num) {
        return number_format($num, 2, ".", "");
    }

    /**
     * @param $persons PersonSummary[]
     * @param $filter callable(PersonSummary)
     * @param $getter callable(PersonSummary)
     */
    public static function printAnalysis($persons, $filter, $getter)
    {
        echo "Размер выборки: " . AnalysisService::count($persons, $filter) . "<br>";
        echo "Среднее: " . AnalysisService::avg($persons, $filter, $getter) . "<br>";
        echo "Медиана: " . AnalysisService::mediana($persons, $filter, $getter) . "<br>";
        echo "Мода: " . implode(", ", AnalysisService::moda($persons, $filter, $getter)) . "<br>";
        echo "СКО: " . AnalysisService::sko($persons, $filter, $getter) . "<br>";
        echo "Коэффициент вариации: " . ( AnalysisService::Cv($persons, $filter, $getter) * 100 ) . "%<br>";
        echo "Средняя ошибка средней арифметической: " . AnalysisService::m($persons, $filter, $getter) . "<br>";
    }

    public static function printScopeAnalysis($title, $persons, $filterExperiment, $filterControl, $getter)
    {
        echo $title . ", экспериментальная группа:<br>";
        self::printAnalysis($persons, $filterExperiment, $getter);

        echo "<br>";

        echo $title . ", контрольная группа:<br>";
        self::printAnalysis($persons, $filterControl, $getter);

        echo "<br>";
        echo "t-критерий Стьюдента: " . self::tCriteriaStudent(
                AnalysisService::avg($persons, $filterExperiment, $getter),
                AnalysisService::avg($persons, $filterControl, $getter),
                AnalysisService::m($persons, $filterExperiment, $getter),
                AnalysisService::m($persons, $filterControl, $getter)
            ) .  "<br>";

//        echo "U-критерий Манна-Уитни: <br>";
//        $rangs = AnalysisService::rangs($persons, $filterExperiment, $filterControl, $getter);

        echo "<hr>";
    }

    private static function rangs($persons, $filterExperiment, $getter)
    {
    }
}