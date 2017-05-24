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


    public function __construct(array $handCards)
{
    $this->handCards = $handCards;
    $this->setHandValue($handCards);
}


private function setHandValue(array $handCards)
{
    $handValue = 0;
    foreach($handCards as $card){
        $tempCard = new Cards($card[0], $card[1]);
        $handValue = $handValue + $tempCard->getCardValue($card[1]);
    }

    $this->value = $handValue;
}

public function getHandValue(){
        return $this->value;
}

}