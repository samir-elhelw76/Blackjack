<?php

namespace Blackjack;

include_once 'Hand.php';


$cards = [new Card('S', 'A'), new Card('D', '2'), new Card('D', '4'),];
$hand = new Hand($cards);

print_r($hand->getHandValue());


