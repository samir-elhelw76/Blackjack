<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';


class Game
{
    private $playerHand;
    private $gameStatus;
    public $dealerHand;
    public $Shoe;

    public function __construct()
    {
        if ($this->Intro() == False) {
            exit;
        } else {
            $this->Shoe = new Shoe($this->constructShoe());
            $this->playerHand = new Hand($this->DealHand());
            $this->dealerHand = new Hand($this->DealHand());
            echo "\n";
            echo "Game will now begin ...\n" . "\n";
            $this->gameStatus = True;
            $this->gameLoop();
        }
    }


    private function constructShoe()
    {
        $responseDecks = (int)$this->message("How many decks would you like to play with? ");
        return $responseDecks;
    }


    private function Intro()
    {
        $responseIntro = $this->message("Would you like to play a game of blackjack? Type 'yes' or 'no':" . " ");
        if (substr(strtolower($responseIntro), 0, 1) != 'y') {
            echo "Okay maybe next time";
            return False;
        } elseif (substr(strtolower($responseIntro), 0, 1) != 'n') {
            return True;
        } else {
            echo "enter a valid response";
        }
    }


    public function gameLoop()
    {
        while ($this->gameStatus == True) {
            $this->ShowPlayerHand();
            $this->checkHand($this->playerHand);
            echo $this->ShowDealerHand() . " " . "\n";
            echo "Your current value is " . $this->playerHand->getHandValue()."\n";
            $playerHitResponse = $this->message("Will you hit or stay? Type 'hit' or 'stay': ");
            if (strtolower($playerHitResponse) != 'hit') {
                $this->dealerTurn();
            } elseif (substr(strtolower($playerHitResponse), 0, 1) == 'h') {
                $this->Hit($this->playerHand);
            }
        }
    }


    private function checkHand(Hand $hand)
    {
        if ($hand->getHandValue() == 21) {
            $this->endgame();
        } elseif ($hand->getHandValue() > 21) {
            $this->Bust($hand);
        } elseif ($hand === $this->dealerHand && $hand->getHandValue() < 17) {
            $this->Hit($hand);
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
        for ($i = 1; $i <= count($this->dealerHand->getHandString()); $i++) {
            echo " " . $this->dealerHand->getHandString()[$i];
        }

    }

    private function Bust($hand)
    {
        if ($hand == $this->playerHand) {
            echo "You Bust!" . "\n";
            exit;
        } else {
            echo "The dealer has bust \n" . $this->ShowDealerHand();
            echo "\n You Win";
            exit;
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


    public function Hit(Hand $hand)
    {
        $hand->getCard($this->Shoe->dealCard());
    }


    private function dealerTurn()
    {
        while ($this->dealerHand->getHandValue() < 17) {
            echo ($this->dealerHand->getHandValue());
            $this->checkHand($this->dealerHand);
            if ($this->dealerHand->getHandValue() > 21) {
                $this->Bust($this->dealerHand);
            } else {
                $this->endGame();
            }
        }
    }

    private function endGame()
    {
        if ($this->dealerHand->getHandValue() > $this->playerHand->getHandValue() && $this->dealerHand <= 21) {
            echo "\n";
            echo $this->ShowDealerHand() . "\n";
            echo "You Lose \n";
        } else {
            echo "\n";
            echo $this->ShowDealerHand() . "\n";
            echo "You win \n";
        }
        exit;
    }
}