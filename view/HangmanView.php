<?php

namespace view;

class HangmanView {

    private $hangmanStates;
    private $hangmanWords;
    private $wordsArray;
    private $wordToGuess;
    private $wrong;
    private $guessedLetters;
    private $guessed;
    private $which;

    public function __construct(\model\HangmanStates $hangmanStates, \model\GetHangmanWords $hangmanWords)
    {
        $this->hangmanStates = $hangmanStates;
        $this->hangmanWords = $hangmanWords;
    }
	public function show($hangmanStateNumber, $guessedLetter) {
        // $this->hangmanWords->sendMessage();
        // $this->checkGuess();
        $guessForm = $this->guessForm($guessedLetter);
        return
        '<h1> Lets play Hangman!</h1>
         <pre>' 
         . $this->hangmanStates->hang[$hangmanStateNumber] . 
         '</pre>
         <br>
         <p id="'. $this->wordToGuess .'"><strong>Word to guess:'
         . $this->wordToGuess .
         '</strong></p>
         <p>Letters you have guessed already:' 
         . $this->guessedLetters
         .$guessForm;
    }
    
    public function guessForm($guessedLetter)
    {
        return '
        <form method="post" action="">
           <input type="hidden" name="wrong" value="'. $this->wrong .'"/>
           <input type="hidden" name="lettersGuessed" value="'. $guessedLetter .'" />
           <input type="hidden" name="word" value="' .$this->which . '"/>
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
            $this->which = $this->fetchCurrentWord();
            var_dump($this->which);

            $currentGuess = $_POST["letter"];
            $letter = strtoupper($currentGuess[0]);

            if(!strstr($this->wordToGuess, $letter))
            {
                if(isset($_SESSION["amountOfGuesses"])){
                    $_SESSION["amountOfGuesses"] += 1;
                } else {
                    $_SESSION["amountOfGuesses"] = 1;
                }
            }
            var_dump($_SESSION["amountOfGuesses"]);

            /* if(isset($_SESSION["guessedLetters"])) {
                $_SESSION["guessedLetters"] = $_SESSION["guessedLetters"] . $letter;
            } else {
                $_SESSION["guessedLetters"] = $letter;
            } */
            $this->guessedLetters = $_POST["lettersGuessed"];
            $this->guessedLetters = $this->guessedLetters . $letter;
            var_dump($this->guessedLetters);

            $this->wordToGuess = $this->checkGuessedLetter($letter);
            var_dump($this->wordToGuess);

            return $this->show(0, $this->guessedLetters);

        }
    }

    public function checkGuessedLetter($guessedLetter)
    {
        $len = strlen($this->wordToGuess);

        $currentGuess = str_repeat("_ ", $len);

        for($i = 0; $i < $len; $i++)
        {
            $ch = $this->wordToGuess[$i];
            if(strstr($guessedLetter, $ch))
            {
                $pos = 2 * $i;
                $currentGuess[$pos] = $ch;
            }
        }

        return $currentGuess;
    }

    public function checkTheGame()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return $this->checkGuess();
        } else {
            $response = $this->startGame();
            return $response;
        }
    }

    public function startGame()
    {
        $this->guessedLetters = '';
        // $this->wordsArray = $this->hangmanWords->sql();
        $words = $this->hangmanWords->sql();
        $amountOfWords = count($words);
        $randomNumber = rand(0, $amountOfWords -1);
        $randomWord = $words[$randomNumber];
        $len = strlen($randomWord);
        $theWordtoGuess = str_repeat('_ ', $len);
        $this->wordToGuess = $theWordtoGuess;
        // var_dump($this->wordToGuess);
        $response = $this->show(0, "", $randomNumber);
        return $response;
    }

    public function fetchCurrentWord()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return $_POST["word"];
        } else {
            return "Hello";
        }
    }
    public function fetchGuessedLetters()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return $_GET[$this->guessedLetters];
        } else {
            return "Hello";
        }
    }
}