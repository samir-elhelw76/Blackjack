<?php

namespace Blackjack;


//This class initializes an array of faces and suits and returns and object card based off these values

class Cards
{
    private $cardFace;
    private $cardSuit;
    private $card;

    private static $faces = [
        '2'=>2,
        '3'=>3,
        '4'=>4,
        '5'=>5,
        '6'=>6,
        '7'=>7,
        '8'=>8,
        '9'=>9,
        '10'=>10,
        'K'=>10,
        'Q'=>10,
        'J'=>10,
        'A'=>11
    ];
    private static $suits = ['D','S','H','C'];


    public function __construct($suit, $face)
    {
        $this->cardCheck($suit,$face);
        $this->card = $this->getCardString();

    }

    private function cardCheck($suit, $face){
        if(in_array($face, self::$faces) && in_array($suit, self::$suits) || array_key_exists($face, self::$faces)){
            $this->cardFace = $face;
            $this->cardSuit = $suit;
        }
        else{
            THROW new \Exception("This card value is not valid");
        }
    }

    /**
     * @return string
     */
    public function getCardString()
    {
        return $this->cardSuit.$this->cardFace;
    }

    public static function getFaces(){
        return self::$faces;
    }

    public static function getSuits(){
        return self::$suits;
    }

    public function getCardValue($face){
        return self::$faces[$face];
    }


}

