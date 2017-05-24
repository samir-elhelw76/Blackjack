<?php

namespace Blackjack;
include_once 'Cards.php';


//This class initializes a shoe based on the number of decks the player chooses to use


class Shoe
{
    private $cards = [];
    private $numDecks;


    public function __construct($numDecks)
    {
        $this->numDecks = $numDecks;
        $this->fillShoe();
    }

    private function fillShoe()
    {
        $suits = Cards::getSuits();
        $cardValues = array_keys(Cards::getFaces());
        $tempDeck = [];
        for ($i = 0; $i < $this->numDecks; $i++) {
            foreach ($suits as $suit) {
                foreach ($cardValues as $cardValue) {
                    $tempCard = new Cards($suit, $cardValue);
                    $tempDeck[] = $tempCard;

                }
            }

        }
        $this->cards = $tempDeck;
    }




    public function rmvCard($card){
        if(in_array($card, $this->cards)) {
            array_splice($this->cards, array_search($card, $this->cards));
        }
        else{
            THROW new \Exception("That card is not in the shoe anymore");
        }
    }

    public function getCards()
    {
        return $this->cards;
    }
}