<?php

namespace model;

class HangmanStates{

    public $hang;

    public function __construct()
    {
        $this->hang = array(
        '        -------
        |/    
        |
        |
        |
        |
        | 
       /|\
       -------------',);
    }
    public function returnHangmanStates()
    {
        return $this->hang;
    }
}

