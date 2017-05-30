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
        $softHand = array();
        foreach ($this->handCards as $card) {
            if (is_array($card->getCardValue())) {
                foreach($card->getCardValue() as $ace){
                    $softHand[] = $ace;
                }
                continue;
            } elseif(count($softHand) > 0) {
                $i = 0;
                foreach ($softHand as $value) {
                    $value += $card->getCardValue();
                    $softHand[$i]  = $value;
                    $i++;
                }
            }
            else{
                $handValue += $card->getCardValue();
            }
        }

        if(count($softHand)>0){
            return $softHand;
        }
        else{
            return $handValue;
        }
        //sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php
    }


    public function getHandString()
    {
        $strHand = [];
        foreach ($this->handCards as $card) {
            $strHand [] = $card->getCardString();
        }
        return $strHand;
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

