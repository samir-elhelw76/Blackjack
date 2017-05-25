<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Cards.php';
include_once 'Hand.php';


class Dealer
{
    private $dealerHand;
    public $Shoe;


    public function __construct($numDecks)
    {
        $this->Shoe = new Shoe($numDecks);
        $this->dealerHand = new Hand($this->DealHand());
        $this->DealerBestHand();

    }
//Hand should be incorporated into dealerHand variable

    public function DealHand()
    {
        $cards = [];
        for ($i = 0; $i < 2; $i++) {
            $cards[] = $this->Shoe->dealCard();
        }
        return $cards;
    }
    //this method returns an array called 'cards' and removes the items in that array from the shoe





    private function DealerBestHand()
    {
        if($this->dealerHand->getHandValue() == 21){
            echo 'I win! Better luck next time.';
        }
        elseif ($this->dealerHand->getHandValue()<17){
            $this->Hit($this->dealerHand);

        }
    }
    //determines whether or not the dealer wants to hit

    public function Hit(Hand $hand)
    {
        $hand->getCard($this->Shoe->dealCard());
    }
    //a method that adds another card to the player's hand


    public function getDealerHand()
    {
        return $this->dealerHand;
    }
}