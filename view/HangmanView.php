<?php
namespace view;

/**
	 * This class is the class for the whole hangman game. It is not great and I would have wanted to 
     * refactor it quite a lot. It works, but it is not clean code.
     * 
	 * The class contains a lot of functions to display, check and run the game.
	 *
	 */
class HangmanView {

    private $hangmanStates;
    private $hangmanWords;
    private $highscore;
    private $wordsArray;
    private $randomNumber;
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
        $this->wordsArray = [];
        $this->wordsArray = $this->hangmanWords->getWords();
    }

    /**
	 * Main display function that returns all the collected html strings that should be presented on the website. 
     * 
	 * Is called when a user the hangman part of the page should be displayed
	 *
	 * @return string html string to display when page is rendered
     * This function takes 4 varibles that holds different values that should either be displayed
     * or hidden to be able to post later on.
	 */
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
    
    private function guessForm($guessedLetter, $wrong, $currentWordAsIndex) {
        
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

    /**
	 * Function to check to current guessed letter and depending on the outcome
     * display and record different views and variables. 
     * 
	 * Is called when the player has entered a letter and presses the guess button
	 *
	 * @return string containing what to display next depending on the guessed letter
	 */

    private function checkGuess() {

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(isset($_SESSION["wordsArray"])) {

                $this->wordsArray = $_SESSION["wordsArray"];
            }

            $currentGuess = $_POST["letter"];
            $letter = strtoupper($currentGuess);

            $amountOfWrongGuesses = $_POST["wrong"];

            $this->guessedLetters = $_POST["lettersGuessed"];
            $this->guessedLetters = $this->guessedLetters . $letter;

            $this->randomNumber = $_POST["word"];
            $currentWordAsIndex = $_POST["word"];
            
            $currentWordInGame =  $this->wordsArray[$currentWordAsIndex];
            $currentWordInGame = strtoupper($currentWordInGame);
            
            $wordAsUnderscore = $this->checkGuessedLetter($this->guessedLetters, $currentWordInGame);

            if(!strstr($currentWordInGame, $letter)) {

               $amountOfWrongGuesses++;
            }
            if(!strstr($wordAsUnderscore, "_")) {

                if(isset($_SESSION["isLoggedIn"])) {

                    if(isset($_SESSION["solvedWords"]) && isset($_SESSION["totalAmountOfTries"])) {

                        $_SESSION["solvedWords"] += 1;
                        $_SESSION["totalAmountOfTries"] += $amountOfWrongGuesses;
                    } else {

                        $_SESSION["solvedWords"] = 1;
                        $_SESSION["totalAmountOfTries"] = $amountOfWrongGuesses;
                    }
                    $_SESSION["playerHasWon"] = true;
                    if(isset($_SESSION["wordsArray"])) {

                        array_splice($_SESSION["wordsArray"], $this->randomNumber, 1);  
                    } else {

                        array_splice($this->wordsArray, $this->randomNumber, 1);
                        $_SESSION["wordsArray"] = $this->wordsArray;
                    }
                    if(count($_SESSION["wordsArray"]) == 0) {

                        $this->gameHasEndedAddHighscore();
                        return $this->playerHasWonAndNoMoreWords($currentWordInGame, $amountOfWrongGuesses);
                    }
                }
                return $this->playerHasWon($currentWordInGame, $amountOfWrongGuesses);
            } else if($amountOfWrongGuesses == 6) {
                if(isset($_SESSION["totalAmountOfTries"]) && isset($_SESSION["solvedWords"])) {

                    $_SESSION["totalAmountOfTries"] += $amountOfWrongGuesses;
                } else {

                    $_SESSION["totalAmountOfTries"] = $amountOfWrongGuesses;
                    $_SESSION["solvedWords"] = 0;
                }
                $this->gameHasEndedAddHighscore();
                return $this->playerHasLost($currentWordInGame, $letter);
            } else {

                unset($_SESSION["playerHasWon"]);
                return $this->show($this->guessedLetters, $wordAsUnderscore, $amountOfWrongGuesses, $currentWordAsIndex );
            }
        }
    }

    private function checkGuessedLetter($guessedLetters, $currentWordInGame) {

        $lengthOfTheWord = strlen($currentWordInGame);
        $currentGuess = str_repeat("_ ", $lengthOfTheWord );

        for($i = 0; $i < $lengthOfTheWord ; $i++) {

            $ch = $currentWordInGame[$i];
            if(strstr($guessedLetters, $ch)) {

                $pos = 2 * $i;
                $currentGuess[$pos] = $ch;
            }
        }
        return $currentGuess;
    }

    public function checkTheGame() {

        if(isset($_POST["Guess"])) {

            return $this->checkGuess();
        } else if(isset($_POST["playNext"])) {

            return $this->startGame();
        } else {

            $response = $this->startGame();
            return $response;
        }
    }

    /**
	 * Function that is called when a new game is going to start.
     * It calles the db to get all available words and then chooses 
     * the word for the current game and then returns the page to be displayed.
	 *
	 * @return string the page to be displayed after the game is initiated. 
	 */
    private function startGame() {
        if(isset($_SESSION["playerHasWon"])) {

            $this->wordsArray = $_SESSION["wordsArray"];
        } else {

            $this->wordsArray = $this->hangmanWords->getWords();
        }
        $this->guessedLetters = '';
        $amountOfWords = count($this->wordsArray);
        $this->randomNumber = rand(0, $amountOfWords -1);
        $randomWord =  $this->wordsArray[$this->randomNumber];
        $len = strlen($randomWord);
        
        $theWordtoGuess = str_repeat('_ ', $len);
        $this->wordToGuess = $theWordtoGuess;
    
        return $this->show("", $theWordtoGuess, 0, $this->randomNumber);
    }

    private function fetchCurrentWord() {

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            return $_POST["word"];
        } else {

            return "Hello";
        }
    }

    private function fetchGuessedLetters() {

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            return $_POST[$this->wordToGuess];
        } else {

            return "Hello";
        }
    }

    private function playerHasWon($word, $amountOfWrongGuesses) {

        return
        '
        <h2>You win!</h2>
        <p>You guessed the correct word <strong>' .$word. '</strong> with '.$amountOfWrongGuesses.' wrong guesses. Well done!!</p>
        <form method="post">
        <input type="submit" name="playNext" value="Next word" />
        </form>
        ';
    }

    private function playerHasLost($word, $letter) {

        return
        '
        <h2>You lost! :(</h2>
        <p>You were hung by the letter: '.$letter.'. The correct word was: '.$word.'. Better luck next time!</p>
        <form method="post">
        <input type="submit" name="playAgain" value="Restart" />
        </form>
        ';
    }

    private function playerHasWonAndNoMoreWords($word, $amountOfWrongGuesses) {

        return
        '
        <h2>You won the whole game!</h2>
        <p>You guessed the correct word <strong>' .$word. '</strong> with '.$amountOfWrongGuesses.' wrong guesses. Well done!!</p>
        <p>You have beaten the game, there are no more words!</p>
        <p>You can start the game over or go to your page to view your highscores.</p>
        <form method="post">
        <input type="submit" name="playAgain" value="Restart" />
        </form>
        ';
    }

    private function gameHasEndedAddHighscore() {

        $this->highscore->addHighscore($_SESSION["username"], $_SESSION["solvedWords"], $_SESSION["totalAmountOfTries"]);
        unset($_SESSION["solvedWords"]);
        unset($_SESSION["totalAmountOfTries"]);
        unset($_SESSION["playerHasWon"]);
        unset($_SESSION["wordsArray"]);
    }
}