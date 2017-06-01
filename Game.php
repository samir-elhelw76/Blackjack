<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';
include_once 'Dealer.php';
include_once 'Player.php';


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
            echo "Game will now begin ...\n\n";
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
            echo "Dealer is showing ";
            $this->ShowDealerHand(1);
            $this->ShowPlayerHand();
            $this->playerTurn();
        }
        $this->endGame();
        exit;
    }

    private function playerTurn()
    {
        $playerHand = $this->player->getPlayerHand();
        $playerHandValue = $this->player->getPlayerHand()->getHandValue();
        if (is_array($playerHandValue)) {
            echo "\nYour hand's value is ";
            foreach ($playerHandValue as $value) {
                echo $value . "\n";
            }
        } else {
            echo "\nYour hand's value is " . $playerHandValue . "\n";
        }
        if (substr(strtolower($this->player->wantHit()), 0, 1) != 'h') {
                $this->dealer->bestHand();
                $this->gameStatus = False;
            } else {
                $this->dealer->Hit($playerHand);
                if ($playerHand->isBust()) {
                    $this->Bust($playerHand);
                } elseif ($playerHand->isBlackjack()) {
                    $this->playerWin();
                }
            }
        }


    private function Bust(Hand $hand)
    {
        if ($hand !== $this->dealer->getDealerHand()) {
            echo "You lost!\n" . "The house wins with a hand of ";
            $this->ShowDealerHand(0);
            $this->ShowPlayerHand();
            echo "\nBetter luck next time\n";
        } else {
            echo "You win!\n" . "Your hand was " . $this->ShowPlayerHand();
        }
        exit;
    }

    private function ShowPlayerHand()
    {
        echo "\nYour hand is ";
        foreach ($this->handString($this->player->getPlayerHand()) as $card) {
            echo $card . " ";
        }
    }

    private function playerWin()
    {
        $this->ShowPlayerHand();
        echo "\nCongratulations! You win!";
        echo "\nThe dealer had ";
        $this->ShowDealerHand(0);
        exit;
    }


    private function ShowDealerHand($start)
    {
        for($i = $start; $i < count($this->handString($this->dealer->getDealerHand())); $i++){
            echo $this->handString($this->dealer->getDealerHand())[$i]. " ";
        }
    }


    private function endGame()
    {
        if ($this->getWinner() == 'dealer') {
            echo "\nThe dealer wins with a hand of ";
            $this->ShowDealerHand(0);
            echo "\nBetter luck next time\n";

        } elseif ($this->getWinner() == 'player') {
            $this->playerWin();
        }

    }


    private function getWinner()
    {
        $dealerValue = $this->dealer->getDealerHand()->getHandValue();
        $playerValue = $this->player->getPlayerHand()->getHandValue();
        if ($this->dealer->getDealerHand()->isBust()) {
            return "player";
        } elseif($dealerValue > $playerValue || max($dealerValue) > $playerValue) {
            return "dealer";
        }
        else{
            return "player";
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

}

new Game(1);