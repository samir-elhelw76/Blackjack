<?php

namespace Blackjack;


//This class initializes an array of faces and suits and returns an object card based off these values

class Card
{
    private $cardFace;
    private $cardSuit;

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
        'A'=>[11,1]
    ];
    private static $suits = ['D','S','H','C'];


    public function __construct($suit, $face)
    {
        $this->setCard($suit,$face);

    }

    private function setCard($suit, $face){
        if(in_array($suit, self::$suits) && array_key_exists($face, self::$faces)){
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
        return $this->cardFace.$this->cardSuit;
    }

    public static function getFaces(){
        return self::$faces;
    }

    public static function getSuits(){
        return self::$suits;
    }

    public function getCardValue(){
        return self::$faces[$this->cardFace];
    }

    public function getCardFace()
    {
        return $this->cardFace;
    }



}

