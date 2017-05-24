<?php
namespace Blackjack;

include_once 'Shoe.php';
include_once 'Cards.php';


$deck = new Shoe(3);

print_r($deck->getCards());