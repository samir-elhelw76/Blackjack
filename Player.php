<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 5/25/17
 * Time: 3:41 PM
 */

namespace Blackjack;
include_once 'Hand.php';
include_once 'Dealer.php';

class Player
{
    private $money;
    private $playerHand;
    public $playerName;


    public function __construct($cards)
    {
        $this->playerHand = new Hand($cards);
        $this->setPlayerName();
        $this->money = 100;
    }


   public function getPlayerHand()
   {
       return $this->playerHand;
   }


   public function wantHit()
   {
       return $this->message( "Would you like to 'hit' or 'stay' ".$this->playerName. "?: ");
   }

    /**
     * @return bool|string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    public function setPlayerName()
    {
        $this->playerName = $this->message("What is your name?: ");
    }


    private function message($message)
    {
        echo $message;
        $handle = fopen("php://stdin", "r");
        $savedHandle = fgets($handle);
        fclose($handle);
        $savedHandle = trim($savedHandle);
        return $savedHandle;
    }
}