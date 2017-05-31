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
                if ($this->bustedAce($handValue)) {
                    unset($handValues[array_search($handValue, $handValues)]);
                }
            }
            return $handValues;
        } else {
            foreach ($this->handCards as $card) {
                $handValue += $card->getCardValue();
            }
        }
        return $handValue;
    }

//sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php


    public
    function isBust()
    {
        $value = $this->getHandValue();
        if (!is_array($value)) {
            if ($value > 21) {
                return True;
            } else {
                return False;
            }
        } elseif (is_array($value)) {
            $i = 0;
            if ($value[$i] > 21 && $value[$i+1] > 21) {
                return true;
            } elseif(count($value) == 0) {
                return false;
            }
        }
        return false;
    }


    public
    function isBlackjack()
    {
        $value = $this->getHandValue();

        if (!is_array($value)) {
            if ($value == 21) {
                return True;
            } else {
                return False;
            }
        } else {
            $i = 0;
            if ($value[$i] == 21 || $value[$i+1] == 21) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function bustedAce($value)
    {
        if (!is_array($value)) {
            if ($value > 21) {
                return True;
            } else {
                return False;
            }
        } elseif (is_array($value)) {
            $i = 0;
            if ($value[$i] > 21 && $value[$i+1] > 21) {
                return true;
            } elseif(count($value) == 0) {
                return false;
            }
        }
        return false;
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

