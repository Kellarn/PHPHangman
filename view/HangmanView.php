<?php

namespace view;

class HangmanView {

    private $hangmanStates;
    private $hangmanWords;
    private $wordsArray;
    private $wordToGuess;

    public function __construct(\model\HangmanStates $hangmanStates, \model\GetHangmanWords $hangmanWords)
    {
        $this->hangmanStates = $hangmanStates;
        $this->hangmanWords = $hangmanWords;
    }
	public function show() {
        $this->hangmanWords->sendMessage();
        $this->wordsArray = $this->hangmanWords->sql();
        return 
        '<h1> Lets play Hangman!</h1>
         <pre>' 
         . $this->hangmanStates->hang[0] . 
         '</pre>
         <br>
         <p><strong>Word to guess:'
         . $this->wordToGuess .
         '</strong></p>';
	}
}