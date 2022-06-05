<?php

class Generic
{
    //muutujad ehk omadused (properties)
    private $secret_value = 13;
    public $just_value = 7;
    private $sent_value;

    //funktsioonid ehk meetodid (methods)
    function __construct($received_value)
    {
        echo "Klass alustab!";
        $this->sent_value = $received_value;
        $this->multiply();
    }

    function __destruct()
    {
        echo "Klassiga on kõik!";
    }

    private function multiply()
    {
        echo "Salajaste arvude korrutis on: .$this->secret_value * $this->sent_value";
    }

    public function reveal()
    {
        echo "Salajased arvud on: " . $this->secret_value . " ja " . $this->sent_value;
    }
}
