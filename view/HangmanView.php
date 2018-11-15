<?php

namespace view;

class HangmanView {

    private $hangmanStates;
    private $hangmanWords;
    private $highscore;

    private $wordsArray;
    private $wordToGuess;
    private $wrong;
    private $guessedLetters;
    private $guessed;
    private $which;

    public function __construct(\model\HangmanStates $hangmanStates, \model\GetHangmanWords $hangmanWords, \model\Highscore $highscore)
    {
        $this->hangmanStates = $hangmanStates;
        $this->hangmanWords = $hangmanWords;
        $this->highscore = $highscore;
    }
	private function show($guessedLetter, $wordAsUnderscore, $wrong, $currentWordAsIndex) {

        $guessForm = $this->guessForm($guessedLetter, $wrong, $currentWordAsIndex);
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
    
    private function guessForm($guessedLetter, $wrong, $currentWordAsIndex)
    {
        return '
        <form method="post" action="">
           <input type="hidden" name="wrong" value="'. $wrong .'"/>
           <input type="hidden" name="lettersGuessed" value="'. $guessedLetter .'" />
           <input type="hidden" name="word" value="' .$currentWordAsIndex . '"/>
           <fieldset>
             <legend>Guess a word</legend>
             <input type="text" name="letter" autofocus />
             <input type="submit" name="Guess" value="Guess" /> 
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

            $currentWordAsIndex = $_POST["word"];
            $currentWordInGame = $words[$currentWordAsIndex];
            $currentWordInGame = strtoupper($currentWordInGame);
            $wordAsUnderscore = $this->checkGuessedLetter($this->guessedLetters, $currentWordInGame);

            if(!strstr($currentWordInGame, $letter))
            {
               $amountOfWrongGuesses++;
            }

            if(!strstr($wordAsUnderscore, "_"))
            {
                $this->highscore->addHighscore($_SESSION["username"], 1, $amountOfWrongGuesses);
                return $this->playerHasWon($currentWordInGame, $amountOfWrongGuesses);
            } 
            else if($amountOfWrongGuesses == 6)
            {
                return $this->playerHasLost($currentWordInGame, $letter);
            }
            else
            {
                return $this->show($this->guessedLetters, $wordAsUnderscore, $amountOfWrongGuesses, $currentWordAsIndex );
            }
        }
    }

    private function checkGuessedLetter($guessedLetters, $currentWordInGame)
    {
        $lengthOfTheWord = strlen($currentWordInGame);
        $currentGuess = str_repeat("_ ", $lengthOfTheWord );

        for($i = 0; $i < $lengthOfTheWord ; $i++)
        {
            $ch = $currentWordInGame[$i];
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
        if(isset($_POST["Guess"]))
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