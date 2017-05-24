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
    private $value;
    private $handCards;

    //initializes a hand value and the cards in that hand


    public function __construct(array $handCards)
    {
        $this->handCards = $handCards;
        $this->setHandValue($handCards);
    }


    private function setHandValue(array $handCards)
    {
        $handValue = 0;
        foreach ($handCards as $card) {
            $tempCard = new Cards($card[0], $card[1]);
            $handValue = $handValue + $tempCard->getCardValue($card[1]);
        }

        $this->value = $handValue;

        //sets the value in the hand equal to sum the value of the cards as they match with the cardValues array in Cards.php
    }

    public function getHandValue()
    {
        return $this->value;

        //getter for the value of a hand
    }

}