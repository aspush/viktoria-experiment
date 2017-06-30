<?php

class RowTest1
{
    private $FIO;
    private $sex;
    private $hasSiblings;
    private $ballZakharov;
    private $ballTemmell;
    private $data;

    function __construct($data)
    {
        if (count($data)<4) {
            dump($data);
        }

        $this->FIO = $data[0];
        $this->sex = $data[1] == "М" ? MALE : FEMALE;
        $this->hasSiblings = $data[2] == "Да";
        $this->ballZakharov = $this->parseFloat($data[3]);
        $this->ballTemmell = $this->parseFloat($data[4]);
        $this->data = $data;
    }

    private function parseFloat($num) {
        return trim(str_replace(",", ".", $num));
    }

    public static function getColumns() {
        return ["ФИО", "Пол", "Есть братья?", "Бал"];
    }

    /**
     * @return String
     */
    public function getFIO()
    {
        return $this->FIO;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return bool
     */
    public function hasSiblings()
    {
        return $this->hasSiblings;
    }

    /**
     * @return int
     */
    public function getBallZakharov()
    {
        return $this->ballZakharov;
    }

    /**
     * @return float
     */
    public function getBallTemmell()
    {
        return $this->ballTemmell;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}