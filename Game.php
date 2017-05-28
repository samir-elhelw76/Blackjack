<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';


class Game
{
    private $dealerHand;
    private $playerHand;
    private $gameStatus;
    public $Shoe;

    public function __construct()
    {
        $responseDecks = (int)$this->message("How many decks would you like in the shoe?: ");
        $this->Shoe = new Shoe($responseDecks);
        $this->playerHand = new Hand($this->DealHand());
        $this->dealerHand = new Hand($this->DealHand());
        $this->Intro();
    }



    private function handString(Hand $hand)
    {
        $handArray = $hand->getHandString();
        return $handArray;
    }

    private function Intro()
    {
        $responseIntro = $this->message("Would you like to play a game of blackjack? Type 'yes' or 'no':" . " ");
        if (substr(strtolower($responseIntro), 0, 1) != 'y') {
            echo "Okay maybe next time";
            exit;
        } else {

            echo "\n";
            echo "Game will now begin ...\n" . "\n";
            $this->gameStatus = True;
            $this->gameLoop();
        }

    }


    public function gameLoop()
    {
        while ($this->gameStatus == True) {
            $this->ShowPlayerHand();
            $this->checkHand($this->playerHand);
            echo "The dealer is showing" . " " . $this->handString($this->dealerHand)[0] . " " . "\n";
            $playerHitResponse = $this->message("Will you hit or stay? Type 'hit' or 'stay': ");
            if (strtolower($playerHitResponse) != 'hit') {
                $this->dealerTurn();
            } elseif (substr(strtolower($playerHitResponse), 0, 1) == 'h') {
                $this->Hit($this->playerHand);
                if ($this->checkHand($this->playerHand) == "Blackjack") {
                    echo "You win!";
                    $this->gameStatus = False;
                    $this->endGame();
                } elseif ($this->checkHand($this->playerHand) != "Bust") {
                    $this->dealerTurn();
                } else {
                    $this->endGame();
                }

            }
        }
    }


    private function checkHand(Hand $hand)
    {
        if ($hand->getHandValue() == 21) {
            return "Blackjack";
        } elseif ($hand->getHandValue() > 21) {
            return "Bust";
        } elseif ($hand->getHandValue() < 21) {
            return "Can hit again";
        }

    }

    private function ShowPlayerHand()
    {
        echo "Your hand is";
        foreach ($this->handString($this->playerHand) as $card) {
            echo " " . $card;
        }
        echo "\n";
    }

    private function message($message)
    {
        echo $message;
        $handle = fopen("php://stdin", "r");
        $savedHandle = fgets($handle);
        fclose($handle);
        $savedHandle = trim($savedHandle);
        return $savedHandle;
    }

    public function DealHand()
    {
        $cards = [];
        for ($i = 0; $i < 2; $i++) {
            $cards[] = $this->Shoe->dealCard();
        }
        return $cards;
    }

    //this method returns an array called 'cards' and removes the items in that array from the shoe

    public function Hit(Hand $hand)
    {
        $hand->getCard($this->Shoe->dealCard());
    }

    //a method that adds another card to the player's hand

    private function dealerTurn()
    {
        if ($this->dealerHand->getHandValue() == 21) {
            echo 'I win! Better luck next time.';
        } elseif ($this->dealerHand->getHandValue() < 17) {
            $this->Hit($this->dealerHand);
        }
    }

    private function endGame()
    {
        echo $this->ShowPlayerHand() ."You busted" . "\n";
        echo "See you next time!";
        die();
    }


    public function getDealerHand()
    {
        return $this->dealerHand;
    }

    public function getPlayerHand()
    {
        return $this->playerHand;
    }
}

