<?php
class Reader {
    private $handler;
    private $class;

    function __construct($fileName, $class)
    {
        $this->handler = fopen($fileName, "r");
        $this->class = $class;

        // skip first line
        fgets($this->handler, 1000000);
    }

    function readLine() {
        $line = fgets($this->handler, 1000000);
        if ($line) {
            $exploded = explode("\t", $line);
            $line = new $this->class($exploded);
        }

        return $line;
    }

    function readAll() {
        $all = [];

        while($line = $this->readLine()) {
            $all[] = $line;
        }

        return $all;
    }
}