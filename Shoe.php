<?php

namespace Blackjack;
include_once 'Cards.php';


//This class initializes a shoe based on the number of decks the player chooses to use


class Shoe
{
    private $cards = [];
    private $numDecks;

    //initializes empty array of cards and number of decks variable


    public function __construct($numDecks)
    {
        $this->numDecks = $numDecks;
        $this->fillShoe();
        $this->shuffleShoe();

        //sets number of decks equal to parameter, constructs the shoe
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
//fills the shoe by using the array suits in cards.php and the array keys of faces in cards.php, then creates a card by matching those values in the class

    private function shuffleShoe()
    {
        shuffle($this->cards);
    }

    public function rmvCard($card){
        if(in_array($card, $this->cards)) {
            array_splice($this->cards, array_search($card, $this->cards));
        }
        else{
            THROW new \Exception("That card is not in the shoe anymore");
        }
    }

    public function dealCard()
    {
        $card = array_shift($this->cards);
        return $card;
    }
//removes a dealt card from the array
    public function getCards()
    {
        return $this->cards;
    }
}