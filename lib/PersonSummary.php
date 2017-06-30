<?php
class PersonSummary extends RowTest2 {
    private $ballZakharov;
    private $ballTemmel;

    function __construct(RowTest1 $row1, RowTest2 $row2)
    {
        parent::__construct($row2->getData());
        $this->ballZakharov = $row1->getBallZakharov();
        $this->ballTemmel = $row1->getBallTemmell();
    }

    public static function getColumns()
    {
        $cols = parent::getColumns();
        $cols[] = "Балл Захаров";
        $cols[] = "Балл Тэммл";
        return $cols;
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
    public function getBallTemmel()
    {
        return $this->ballTemmel;
    }
}