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
	private function show($guessedLetter, $wordAsUnderscore, $wrong, $theWordAsIndexNumber) {

        $guessForm = $this->guessForm($guessedLetter, $wrong, $theWordAsIndexNumber);
        return
        '<pre>' 
         . $this->hangmanStates->hang[$wrong] . 
         '</pre>
         <br>
         <p><strong>Word to guess:'
         . $wordAsUnderscore .
         '</strong></p>
         <p>Letters you have guessed already:' 
         . $this->guessedLetters
         .$guessForm;
    }
    
    private function guessForm($guessedLetter, $wrong, $theWordAsIndexNumber)
    {
        return '
        <form method="post" action="">
           <input type="hidden" name="wrong" value="'. $wrong .'"/>
           <input type="hidden" name="lettersGuessed" value="'. $guessedLetter .'" />
           <input type="hidden" name="word" value="' .$theWordAsIndexNumber . '"/>
           <fieldset>
             <legend>Guess a word</legend>
             <input type="text" name="letter" autofocus />
             <input type="submit" value="Guess" /> 
            </fieldset>
        </form>';
    }

    private function checkGuess()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $currentGuess = $_POST["letter"];
            $letter = strtoupper($currentGuess[0]);
            $amountOfWrongGuesses = $_POST["wrong"];

            $this->guessedLetters = $_POST["lettersGuessed"];
            $this->guessedLetters = $this->guessedLetters . $letter;

            $words = $this->hangmanWords->sql();

            $theWordAsIndexNumber = $_POST["word"];
            $theWord = $words[$theWordAsIndexNumber];
            $theWord = strtoupper($theWord);
            $wordAsUnderscore = $this->checkGuessedLetter($this->guessedLetters, $theWord);

            if(!strstr($theWord, $letter))
            {
               $amountOfWrongGuesses++;
            }

            if(!strstr($wordAsUnderscore, "_"))
            {
                return $this->playerHasWon($theWord, $amountOfWrongGuesses);
            } 
            else if($amountOfWrongGuesses == 6)
            {
                return $this->playerHasLost($theWord, $letter);
            }
            else
            {
                return $this->show($this->guessedLetters, $wordAsUnderscore, $amountOfWrongGuesses, $theWordAsIndexNumber );
            }
        }
    }

    private function checkGuessedLetter($guessedLetters, $theWord)
    {
        $lengthOfTheWord = strlen($theWord);
        $currentGuess = str_repeat("_ ", $lengthOfTheWord );

        for($i = 0; $i < $lengthOfTheWord ; $i++)
        {
            $ch = $theWord[$i];
            if(strstr($guessedLetters, $ch))
            {
                $pos = 2 * $i;
                $currentGuess[$pos] = $ch;
            }
        }

        return $currentGuess;
    }

    public function checkTheGame()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            return $this->checkGuess();
        } else {
            $response = $this->startGame();
            return $response;
        }
    }

    private function startGame()
    {
        $this->guessedLetters = '';
        $words = $this->hangmanWords->sql();
       
        $amountOfWords = count($words);
        $randomNumber = rand(0, $amountOfWords -1);
        $randomWord = $words[$randomNumber];
        $len = strlen($randomWord);
        $theWordtoGuess = str_repeat('_ ', $len);
        
        $this->wordToGuess = $theWordtoGuess;
        
        $response = $this->show("", $theWordtoGuess, 0, $randomNumber);
        return $response;
    }

    private function fetchCurrentWord()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return $_POST["word"];
        } else {
            return "Hello";
        }
    }
    private function fetchGuessedLetters()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return $_POST[$this->wordToGuess];
        } else {
            return "Hello";
        }
    }

    private function playerHasWon($word, $amountOfWrongGuesses)
    {
        return
        '
        <h2>You win!</h2>
        <p>You guessed the correct word <strong>' .$word. '</strong> with '.$amountOfWrongGuesses.' wrong guesses. Well done!!</p>
        ';
    }

    private function playerHasLost($word, $letter)
    {
        return
        '
        <h2>You lost! :(</h2>
        <p>You were hung by the letter: '.$letter.'. The correct word was: '.$word.'. Better luck next time!</p>
        ';
    }
}