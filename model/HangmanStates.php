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
        '        -------
        |/    | 
        |     o
        |
        |
        |
        | 
       /|\
        -------------',
        '        -------
        |/    | 
        |     o
        |     |
        |     |
        |    /
        | 
       /|\
        -------------',
        '        -------
        |/    | 
        |     o
        |     |
        |     |
        |    / \
        | 
       /|\
        -------------',
        '        -------
        |/    | 
        |     o
        |   --|
        |     |
        |    / \
        | 
       /|\
        -------------',
        '        -------
        |/    | 
        |     o
        |   --|--
        |     |
        |    / \
        | 
       /|\
        -------------');
    }
    
    
    /**
	 * Returns the array containing the different hangman states that is created in the __construct.
	 *
	 * Is called when a game is initiated.
	 *
	 * @return  array to be used in the game to display how hung the player is. 
	 */
    public function returnHangmanStates()
    {
        return $this->hang;
    }
}

