<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';
include_once 'Dealer.php';


class Game
{
    private $gameStatus;
    public $dealer;
    public $player;

    public function __construct()
    {
        if ($this->Intro() == False) {
            exit;
        } else {
            $this->dealer = new Dealer($this->constructShoe());
            $this->player = new Player($this->dealer->DealHand());
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


    private function gameLoop()
    {
        while ($this->gameStatus == True) {
            $this->ShowDealerHand(1);
            $this->playerTurn();


        }

    }

    private function playerTurn()
    {

        if ($this->checkSoftHand($this->player->getPlayerHand()) == True) {
            echo "Your hand has two values ";
            foreach ($this->player->getPlayerHand()->getHandValue() as $value) {
                echo "\n" . $value;
            }
            if (substr(strtolower($this->player->wantHit()), 0, 1) != 'h') {
                $this->dealer->bestHand();
            } else {
                $this->dealer->Hit($this->player->playerHand);
                $this->checkHandValue($this->player->playerHand, True);
            }
        }


    }


    private function checkSoftHand(Hand $hand)
    {
        if (!is_array($hand->getHandValue())) {
            return False;
        } else {
            return True;
        }
    }


    private function checkHandValue(Hand $hand, $softHand = False)
    {
        if ($softHand != False) {
            if (max($hand->getHandValue()) > 21 && min($hand->getHandValue() > 21)) {
                $this->Bust();
            } elseif (max($hand->getHandValue()) == 21 || min($hand->getHandValue() == 21)) {
                $this->Blackjack();
            } else {
                return null;
            }

        }
    }


    private function Bust(Hand $hand)
    {
        if($hand !== $this->dealer->getDealerHand()){
            echo "You lost!\n"."The house wins with a hand of\n".print_r($this->dealer->getDealerHand()->getHandString());
        }
        else{
            echo "You win!\n"."Your hand was\n".$this->ShowPlayerHand();
        }
    }
    private function ShowPlayerHand()
    {
        echo "Your hand is";
        foreach ($this->handString($this->player->getPlayerHand()) as $card) {
            echo " " . $card;
        }
    }


    private function ShowDealerHand($start)
    {
        echo "\nDealer is showing ";
        for ($i = $start; $i <= count($this->dealer->getDealerHand()->getHandString()); $i++) {
            echo " " . $this->dealer->getDealerHand()->getHandString()[$i];
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







    //maybe make a softhand class

}

