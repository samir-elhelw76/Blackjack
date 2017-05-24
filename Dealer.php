<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Cards.php';
include_once 'Hand.php';


class Dealer
{
    private $handDealer;
    private $dealerHandValue;
    public $Shoe;


    public function __construct($numDecks)
    {
        $this->Shoe = new Shoe($numDecks);
        $this->handDealer = (new Hand($this->DealHand()));
    }
//Hand should be incorporated into handDealer variable

    public function DealHand()
    {
        $cards = [];
        for ($i = 0; $i < 2; $i++) {
            $cards[] = $this->Shoe->dealCard();
        }
        return $cards;
    }
    //this method returns an array called 'cards' and removes the items in that array from the shoe




    public function getDealerBestHand()
    {
        if($this->dealerHandValue<21){
            while($this->dealerHandValue<17){

            }
        }
    }
    //this method determines whether the dealer will hit again or stay, also contains logic for whether the ace will be treated as a 1 or 11

    public function getDealerHand()
    {
        return $this->handDealer;
    }
}