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
       -------------',
       '       -------
       |/    | 
       |     o
       |
       |
       |
       | 
      /|\
      -------------',
      '     -------
      |/    | 
      |     o
      |     |
      |     |
      |    /
      | 
     /|\
     -------------',
     '     -------
     |/    | 
     |     o
     |     |
     |     |
     |    / \
     | 
    /|\
    -------------',
    '     -------
    |/    | 
    |     o
    |   --|
    |     |
    |    / \
    | 
   /|\
   -------------',
   '     -------
   |/    | 
   |     o
   |   --|--
   |     |
   |    / \
   | 
  /|\
  -------------');
    }
    
    public function returnHangmanStates()
    {
        return $this->hang;
    }
}

