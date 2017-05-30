<?php

namespace Blackjack;
include_once 'Card.php';


//This class initializes a shoe based on the number of decks the player chooses to use


class Shoe
{
    public $cards = [];
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
        $suits = Card::getSuits();
        $cardValues = array_keys(Card::getFaces());
        $this->cards = [];
        for ($i = 0; $i < $this->numDecks; $i++) {
            foreach ($suits as $suit) {
                foreach ($cardValues as $cardValue) {
                    $tempCard = new Card($suit, $cardValue);
                    $this->cards[] = $tempCard;

                }
            }

        }
    }
//fills the shoe by using the array suits in cards.php and the array keys of faces in cards.php, then creates a card by matching those values in the class

    public function shuffleShoe()
    {
        shuffle($this->cards);
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