<?php
class RowTest2 {
    private $fio;
    private $age;
    private $familyDescription;
    private $hasSiblings;
    private $hasFamilyProblems;
    private $sex;

    private $acceptanceRejectionBall;
    private $acceptanceRejectionPercentage;
    private $acceptanceRejectionDescription;

    private $cooperationBall;
    private $cooperationPercentage;
    private $cooperationDescription;

    private $symbiosisBall;
    private $symbiosisPercentage;
    private $symbiosisDescription;

    private $authoritarianHyperSocializationBall;
    private $authoritarianHyperSocializationPercentage;
    private $authoritarianHyperSocializationDescription;

    private $littleLooserBall;
    private $littleLooserPercentage;
    private $littleLooserDescription;
    private $data;

    /**
     * ФИО	Возраст	Описание семьи	Есть сиблинги	Семейные проблемы	Пол	Принятие-отвержение			Кооперация			Симбиоз			Авторитарная гиперсоциализация			Маленький неудачник
     */

    function __construct($data)
    {
        if (count($data)<21) {
            dump($data);
        }

        $this->fio = $data[0];
        $this->age = $data[1];
        $this->familyDescription = $data[2];
        $this->hasSiblings = $data[3] == "Да";
        $this->hasFamilyProblems = $data[4] == "Да";
        $this->sex = $data[5] == "М" ? MALE : FEMALE;

        $this->acceptanceRejectionBall = $this->parseFloat($data[6]);
        $this->acceptanceRejectionPercentage = $this->parseFloat($data[7]);
        $this->acceptanceRejectionDescription = $data[8];

        $this->cooperationBall = $this->parseFloat($data[9]);
        $this->cooperationPercentage = $this->parseFloat($data[10]);
        $this->cooperationDescription = $data[11];

        $this->symbiosisBall = $this->parseFloat($data[12]);
        $this->symbiosisPercentage = $this->parseFloat($data[13]);
        $this->symbiosisDescription = $data[14];

        $this->authoritarianHyperSocializationBall = $this->parseFloat($data[15]);
        $this->authoritarianHyperSocializationPercentage = $this->parseFloat($data[16]);
        $this->authoritarianHyperSocializationDescription = $data[17];

        $this->littleLooserBall = $this->parseFloat($data[18]);
        $this->littleLooserPercentage = $this->parseFloat($data[19]);
        $this->littleLooserDescription = $data[20];

        $this->data = $data;
    }

    public static function getColumns() {
        return [
            "ФИО", "Возраст", "Описание семьи", "Есть сиблинги", "Семейные проблемы", "Пол",
            "1 Принятие-отвержение балл", "1 Персентиль", "1 Описание",
            "2 Кооперация", "2 Персентиль", "2 Описание",
            "3 Симбиоз", "3 Персентиль", "3 Описание",
            "4 Авторитарная гиперсоциализация", "4 Персентиль", "4 Описание",
            "5 Маленький неудачник", "5 Персентиль", "5 Описание"
        ];
    }

    private function parseFloat($num) {
        return trim(str_replace(",", ".", $num));
    }

    /**
     * @return String
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return String
     */
    public function getFamilyDescription()
    {
        return $this->familyDescription;
    }

    /**
     * @return bool
     */
    public function hasSiblings()
    {
        return $this->hasSiblings;
    }

    /**
     * @return bool
     */
    public function hasFamilyProblems()
    {
        return $this->hasFamilyProblems;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return int
     */
    public function getAcceptanceRejectionBall()
    {
        return $this->acceptanceRejectionBall;
    }

    /**
     * @return float
     */
    public function getAcceptanceRejectionPercentage()
    {
        return $this->acceptanceRejectionPercentage;
    }

    /**
     * @return String
     */
    public function getAcceptanceRejectionDescription()
    {
        return $this->acceptanceRejectionDescription;
    }

    /**
     * @return int
     */
    public function getCooperationBall()
    {
        return $this->cooperationBall;
    }

    /**
     * @return float
     */
    public function getCooperationPercentage()
    {
        return $this->cooperationPercentage;
    }

    /**
     * @return String
     */
    public function getCooperationDescription()
    {
        return $this->cooperationDescription;
    }

    /**
     * @return int
     */
    public function getSymbiosisBall()
    {
        return $this->symbiosisBall;
    }

    /**
     * @return float
     */
    public function getSymbiosisPercentage()
    {
        return $this->symbiosisPercentage;
    }

    /**
     * @return String
     */
    public function getSymbiosisDescription()
    {
        return $this->symbiosisDescription;
    }

    /**
     * @return int
     */
    public function getAuthoritarianHyperSocializationBall()
    {
        return $this->authoritarianHyperSocializationBall;
    }

    /**
     * @return float
     */
    public function getAuthoritarianHyperSocializationPercentage()
    {
        return $this->authoritarianHyperSocializationPercentage;
    }

    /**
     * @return String
     */
    public function getAuthoritarianHyperSocializationDescription()
    {
        return $this->authoritarianHyperSocializationDescription;
    }

    /**
     * @return int
     */
    public function getLittleLooserBall()
    {
        return $this->littleLooserBall;
    }

    /**
     * @return float
     */
    public function getLittleLooserPercentage()
    {
        return $this->littleLooserPercentage;
    }

    /**
     * @return String
     */
    public function getLittleLooserDescription()
    {
        return $this->littleLooserDescription;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}