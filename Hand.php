<?php

namespace Blackjack;
include_once 'Card.php';

class Hand
{
    private $handCards;

    //initializes a hand value and the cards in that hand


    public function __construct(array $handCards)
    {
        $this->handCards = $handCards;
    }


    public function getHandValue()
    {
        $value = 0;
        $aceFlag = $this->hasAce();
        foreach ($this->handCards as $card) {
            $value += $card->getCardValue();
        }
        if ($value == 21 || $value > 21) {
            return $value;
        }
         elseif ($aceFlag) {
            if ($value += 10 == 21) {
                return $value += 10;
            }
            elseif ($value += 10 < 21) {
               return [$value+=10, $value];
            }
            else{
                return $value;
            }

        }
        return $value;
    }

//sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php


    public function isBust()
    {
        $value = $this->getHandValue();
        return ($value > 21);
    }


    /**
     *
     */
    public function isBlackjack()
    {
        $value = $this->getHandValue();
        $cardCount = count($this->handCards);
        return ($value == 21 && $cardCount == 2);
    }

    public function getHandString()
    {
        $strHand = [];
        foreach ($this->handCards as $card) {
            $strHand [] = $card->getCardString();
        }
        return $strHand;
    }



    private function hasAce()
    {
        foreach ($this->handCards as $card) {
            if ($card->getCardFace() == 'A') {
                return True;
            }
        }
        return False;
    }

    public function getHandCards()
    {
        return $this->handCards;
    }

    public function getCard($card)
    {
        return $this->handCards[] = $card;
    }
}

