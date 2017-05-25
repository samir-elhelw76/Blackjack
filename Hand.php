<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 5/24/17
 * Time: 9:47 AM
 */

namespace Blackjack;
include_once 'Cards.php';


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
        foreach ($this->handCards as $card) {
            $handValue += $card->getCardValue();
        }

        return $handValue;
        //sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php
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

