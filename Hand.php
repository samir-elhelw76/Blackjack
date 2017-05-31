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
        $handValue = 0;
        $handValues = [];
        if ($this->hasAce()) {
            foreach ($this->handCards as $card) {
                if ($card->getCardFace() != 'A') {
                    $handValue += $card->getCardValue();
                }
            }
            for ($i = 0; $i < 2; $i++) {
                $handValues[$i] = $handValue + 1;
            }
            $handValues[0] += 10;
            foreach ($handValues as $handValue) {
                if ($this->isBust($handValue)) {
                    unset($handValues[array_search($handValue, $handValues)]);
                }
                elseif($this->isBlackjack($handValue)){
                    return true;
                }
            }

            if (count($handValues) == 0 || $this->isBust($handValues)) {
                return False; //returns true, implying busted hand
            } elseif (!$this->isBust($handValues)) {
                return $handValues;
            }
        } else {
            foreach ($this->handCards as $card) {
                $handValue += $card->getCardValue();
            }
            if($this->isBlackjack($handValue)){
                return true;
            }
             elseif($this->isBust($handValue)) {
                return !$this->isBust($handValue);
            }
            elseif (!$this->isBust($handValue)) {
                return $handValue;
            }
        }
    }

    //sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php


    public
    function isBust($value)
    {
        if (!is_array($value)) {
            if ($value > 21) {
                return True;
            } else {
                return False;
            }
        } elseif(is_array($value)) {
            $i = 0;
            if ($value[$i] > 21 && $value[$i++] > 21) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function isBlackjack($value)
    {
        if (!is_array($value)) {
            if ($value == 21) {
                return True;
            } else {
                return False;
            }
        } else {
            $i = 0;
            if ($value[$i] == 21 || $value[$i++] == 21) {
                return true;
            } else {
                return false;
            }
        }
    }

    public
    function getHandString()
    {
        $strHand = [];
        foreach ($this->handCards as $card) {
            $strHand [] = $card->getCardString();
        }
        return $strHand;
    }

    private
    function hasAce()
    {
        foreach ($this->handCards as $card) {
            if ($card->getCardFace() == 'A') {
                return True;
            }
        }
        return False;
    }

    public
    function getHandCards()
    {
        return $this->handCards;
    }

    public
    function getCard($card)
    {
        return $this->handCards[] = $card;
    }
}

