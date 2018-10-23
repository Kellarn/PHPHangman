<?php

namespace view;

class HangmanView {

    private $hangmanStates;
    private $hangmanWords;
    private $wordsArray;
    private $wordToGuess;
    private $wrong;
    private $guessedLetters;

    public function __construct(\model\HangmanStates $hangmanStates, \model\GetHangmanWords $hangmanWords)
    {
        $this->hangmanStates = $hangmanStates;
        $this->hangmanWords = $hangmanWords;
    }
	public function show() {
        // $this->hangmanWords->sendMessage();
        $this->wordsArray = $this->hangmanWords->sql();
        $this->wordToGuess = $this->hangmanWords->setCurrentGameWord();
        $this->checkGuess();
        return 
        '<h1> Lets play Hangman!</h1>
         <pre>' 
         . $this->hangmanStates->hang[0] . 
         '</pre>
         <br>
         <p><strong>Word to guess:'
         . $this->wordToGuess .
         '</strong></p>
         <p>Letters you have guessed already:' 
         . $_SESSION["guessedLetters"]
         .$this->guessForm();
    }
    
    public function guessForm()
    {
        return '
        <form method="post" action="">
           <input type="hidden" name="wrong" value='. $this->wrong .'/>
           <fieldset>
             <legend>Guess a word</legend>
             <input type="text" name="letter" autofocus />
             <input type="submit" value="Guess" /> 
            </fieldset>
        </form>';
    }

    public function checkGuess()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $word = $this->wordToGuess;

            $currentGuess = $_POST["letter"];
            $letter = strtoupper($currentGuess[0]);

            if(!strstr($word, $letter))
            {
                if(isset($_SESSION["amountOfGuesses"])){
                    $_SESSION["amountOfGuesses"] += 1;
                } else {
                    $_SESSION["amountOfGuesses"] = 1;
                }
            }

            if(isset($_SESSION["guessedLetters"])) {
                $_SESSION["guessedLetters"] = $_SESSION["guessedLetters"] . $letter;
            } else {
                $_SESSION["guessedLetters"] = $letter;
            }
            //$this->guessedLetters = $this->guessedLetters .= $letter;

        }
    }

    public function checkGuessedLetter($guessedLetter)
    {
        $len = strlen($this->wordToGuess);
    }
}