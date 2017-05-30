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
            $dealerHandCards = [new Card('D', 'A'), new Card('H', '4')];
            $this->dealerHand = new Hand($dealerHandCards);
            $this->playerHand = new Hand($dealerHandCards);

            //$this->dealerHand = new Hand($this->DealHand());
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
            $this->checkHand($this->playerHand);
            echo "\n" . $this->ShowDealerHand(1) . " " . "\n";
            $playerHitResponse = $this->message("Will you hit or stay? Type 'hit' or 'stay': ");
            if (strtolower($playerHitResponse) != 'hit') {
                $this->dealerTurn();
            } elseif (substr(strtolower($playerHitResponse), 0, 1) == 'h') {
                $this->Hit($this->playerHand);
            }
        }
        $this->endGame();
    }


    private function checkHand(Hand $hand)
    {
        if ($hand->getHandValue() >= 21 && !is_array($hand->getHandValue())) {
            $this->gameStatus = False;
        } elseif (is_array($hand->getHandValue()) && $hand === $this->dealerHand) {
            if (max($hand->getHandValue()) > 21 && min($hand->getHandValue()) > 21) {
                $this->gameStatus = False;
            } elseif (max($hand->getHandValue()) < 17) {
                while (max($hand->getHandValue()) < 17) {
                    $this->Hit($hand);
                }
                print_r($hand->getHandValue());
                die();
                $this->gameStatus = False;
            }
        } elseif ($hand === $this->dealerHand && $hand->getHandValue() < 17) {
            $this->Hit($hand);
        } elseif (is_array($hand->getHandValue()) && $hand === $this->playerHand) {
            $this->ShowPlayerHand(True);
        } else {
            $this->ShowPlayerHand();
        }

    }

    private function ShowPlayerHand($softHand = False)
    {
        echo "Your hand is";
        foreach ($this->handString($this->playerHand) as $card) {
            echo " " . $card;
        }
        echo "\n";
        if ($softHand == True) {
            echo "Your hand has a value of \n";
            foreach ($this->playerHand->getHandValue() as $value) {
                if ($value < 21) {
                    echo $value . "\n";
                }
            }
        } else {
            echo "Your current value is " . $this->playerHand->getHandValue() . "\n";
        }
    }


    private function ShowDealerHand($start)
    {
        echo "\nDealer is showing ";
        for ($i = $start; $i <= count($this->dealerHand->getHandString()); $i++) {
            echo " " . $this->dealerHand->getHandString()[$i];
        }

    }

    private function Bust($hand)
    {
        if ($hand == $this->playerHand) {
            echo "\n You Bust!" . "\n";
            exit;
        } else {
            echo "\n";
            echo "The dealer has bust\n";
            print_r($this->dealerHand->getHandString());
            echo "\nYou Win\n";
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
        $this->checkHand($hand);
    }


    private function dealerTurn()
    {
        $this->checkHand($this->dealerHand);
    }

    private function endGame()
    {
        if (is_array($this->dealerHand->getHandValue()) || is_array($this->playerHand->getHandValue())) {
            $this->softHandEndGame();
        } elseif ($this->dealerHand->getHandValue() > $this->playerHand->getHandValue() && $this->dealerHand->getHandValue() <= 21) {
            echo "\n";
            echo $this->ShowDealerHand(0) . "\n";
            $this->ShowPlayerHand();
            echo "You Lose \n";
        } elseif ($this->playerHand->getHandValue() > $this->playerHand->getHandValue() && $this->playerHand->getHandValue() <= 21) {
            echo "\n";
            echo $this->ShowDealerHand(0) . "\n";
            echo "You win \n";
        } elseif ($this->dealerHand->getHandValue() > 21) {
            $this->Bust($this->dealerHand);
        } elseif ($this->playerHand->getHandValue() > 21) {
            $this->Bust($this->playerHand);
        }
        exit;
    }

    private function softHandEndGame()
    {
        if (!is_array($this->playerHand->getHandValue())) {
            $dealerMax = max($this->dealerHand->getHandValue());
            $dealerMin = min($this->dealerHand->getHandValue());
            $playerValue = $this->playerHand->getHandValue();
            if ($playerValue < $dealerMax || $dealerMin > $playerValue) {
                echo "Dealer Wins with hand of \n";
                $this->ShowDealerHand(0);
            }
        }
    }



}

