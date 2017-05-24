<?php


namespace Blackjack;

include_once 'Shoe.php';

include_once 'Cards.php';


class Dealer
{
    private $handDealer;
    private $numDecks;
    public $Shoe;



    public function __construct($numDecks)
    {
        $this->Shoe = new Shoe($numDecks);
        $this->shuffleShoe();
        $this->handDealer = $this->DealHand();

    }



    private function shuffleShoe()
    {
        shuffle($this->Shoe->getCards());
    }

    public function DealHand()
    {
       $cards = [];
       for($i = 0; $i<2; $i++){
           $cards [] = $this->DealCard();
       }
    return $cards;

    }

    public function DealCard()
    {
        $card = array_shift($this->Shoe->getCards());
        return $card;
    }

}