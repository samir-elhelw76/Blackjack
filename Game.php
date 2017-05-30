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
        if ($this->Intro() == False){
            exit;
        }
        else{
            $this->Shoe = new Shoe($this->constructShoe());
            $this->playerHand = new Hand($this->DealHand());
            $this->dealerHand = new Hand($this->DealHand());
            $this->dealerShowedCards = [];
            echo "\n";
            echo "Game will now begin ...\n" . "\n";
            $this->gameStatus = True;
            $this->gameLoop();
        }
    }



    private function constructShoe()
    {
        $responseDecks = (int)$this->message("How many decks would you like to play with?");
        return $responseDecks;
    }


    private function Intro()
    {
        $responseIntro = $this->message("Would you like to play a game of blackjack? Type 'yes' or 'no':" . " ");
        if (substr(strtolower($responseIntro), 0, 1) != 'y') {
            echo "Okay maybe next time";
            return False;
        } else {
            return True;
        }

    }


    public function gameLoop()
    {
        while ($this->gameStatus == True) {
            $this->ShowPlayerHand();
            $this->checkHand($this->playerHand);
            echo $this->ShowDealerHand(). " " . "\n";
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

    private function ShowDealerHand()
    {
        echo "Dealer is showing";
        for($i = 1; $i<=count($this->dealerHand->getHandString());$i++ ){
            echo " ".$this->dealerHand->getHandString()[$i];
        }

    }


    private function handString(Hand $hand)
    {
        $handArray = $hand->getHandString();
        return $handArray;
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
        if ($this->checkHand($this->dealerHand) == "Blackjack") {
            echo 'I win! Better luck next time.';
            $this->endGame();
        } elseif ($this->checkHand($this->dealerHand) == "Can hit again" && $this->dealerHand->getHandValue()<17) {
            $this->Hit($this->dealerHand);
            if($this->checkHand($this->dealerHand) == "Bust"){
                echo "I bust, you win!";
                $this->endGame();
            }
        }
        elseif($this->checkHand($this->dealerHand) == "Bust"){
            echo "\n"."I bust, you win!";
        }
        else{
            echo "Your move"."\n";
        }
    }

    private function endGame()
    {
        echo $this->ShowPlayerHand() ."Good Game!". "\n";
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