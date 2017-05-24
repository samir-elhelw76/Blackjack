<?php


namespace Blackjack;

include_once 'Shoe.php';

include_once 'Cards.php';


class Dealer
{
    private $handDealer;
    private $handDealerValue;
    public $Shoe;


    public function __construct($numDecks)
    {
        $this->Shoe = new Shoe($numDecks);
        $this->handDealer = $this->DealHand();
    }

//    private function shuffleShoe()
  //  {
      //  shuffle($this->Shoe->getCards());
    //}
    //shuffles the shoe

    public function DealHand()
    {
        $cards = [];
        for ($i = 0; $i < 2; $i++) {
            $cards[] = $this->DealCard();
        }
        return $cards;
    }
    //this method returns an array called 'cards' and removes the items in that array from the shoe


    public function DealCard()
    {
        $card =  array_pop($this->Shoe->getCards());
        return $card;
    }
    //this method deals a single card

    public function dealerBestHand()
    {
        if (array_key_exists('A', $this->handDealer)) {
            $tempHand = new Hand($this->handDealer);
            if ($tempHand->getHandValue() > 21) {
                $tempHand['A'] = '1';
            } elseif ($this->handDealerValue >= 17) {
                echo 'I am staying';
            }

            else{
                echo "I'll hit again";
            }
            $this->handDealerValue = $tempHand->getHandValue();
        }
    }
    //this method determines whether the dealer will hit again or stay, also contains logic for whether the ace will be treated as a 1 or 11

    public function getDealerHand()
    {
        return $this->handDealer;
    }
}