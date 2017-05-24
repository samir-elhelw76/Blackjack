<?php

namespace Blackjack;

include_once 'Cards.php';

//This class will initialize and randomize the decks for blackjack
class Deck
{
    private $deck = [
        "hearts" => array(),
        "clubs" => array(),
        "spades" => array(),
        "diamonds" => array(),
    ];

    public function __construct($number_of_Decks)
    {

        $this->deck["hearts"] = $this->fillSuit($this->deck["hearts"], "H", $number_of_Decks);
        $this->deck["clubs"] = $this->fillSuit($this->deck["clubs"], "C", $number_of_Decks);
        $this->deck["spades"] = $this->fillSuit($this->deck["spades"], "S", $number_of_Decks);
        $this->deck["diamonds"] = $this->fillSuit($this->deck["diamonds"], "D", $number_of_Decks);


    }

    private function fillSuit(array $suit, $name, $number_of_decks)
    {
        $value = 2;
        for ($i = 0; $i < 8 * $number_of_decks; $i++)
        {
             if ($value <= 10 && $value >= 2)
            {
                $suit[$i] = new Cards($value, $name);
            }
            else
            {
                 $value = 1;
            }
            $value++;
        }

        return $suit;
    }


    public function getDeck()
    {
        return $this->deck;
    }
}
