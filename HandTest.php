<?php

namespace Blackjack;

include_once 'Hand.php';


$cards = [new Card('S', 'A'), new Card('D', '10'), new Card('D', '10'),new Card('S', '10'),];
$hand = new Hand($cards);

print_r($hand->getHandValue());


