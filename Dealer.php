<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 5/30/17
 * Time: 1:06 PM
 */

namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';

class Dealer
{
    private $dealerHand;
    public $Shoe;

    public function __construct($numDecks)
    {
        $this->Shoe = new Shoe($numDecks);
        $this->dealerHand = new Hand ($this->DealHand());
    }

    public function bestHand()
    {
        if(!is_array($this->dealerHand->getHandValue())){
            while ($this->dealerHand->getHandValue()<17){
                $this->Hit($this->dealerHand);
            }
        }
        else{
            while(max($this->dealerHand->getHandValue()) < 17){
                $this->Hit($this->dealerHand);
            }
        }
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
    }

    public function getDealerHand()
    {
        return $this->dealerHand;
    }

}