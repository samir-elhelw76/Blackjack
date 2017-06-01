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
        do  {
            if (!is_array($this->dealerHand->getHandValue())) {
                    $this->Hit($this->dealerHand);
                }

             elseif (is_array($this->dealerHand->getHandValue())) {
                    $this->Hit($this->dealerHand);
                }

            }
        while($this->dealerWantHit());
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

    private function dealerWantHit()
    {
        echo count($this->dealerHand->getHandValue());
    if ($this->dealerHand->isBust()){
            return false;
        }
        elseif(count($this->dealerHand->getHandValue()) == 0 && is_array($this->dealerHand->getHandValue())){
        return false;
        }

        elseif($this->dealerHand->getHandValue()<17){
            return True;
        }
        elseif(is_array($this->dealerHand->getHandValue()) && max($this->dealerHand->getHandValue())<17){
            return true;
        }
        return False;
    }

}