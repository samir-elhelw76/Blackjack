<?php

namespace Blackjack;

include_once 'Hand.php';
$hand = ['H3', 'H4'];

$newHand = new \Blackjack\Hand($hand);

echo $newHand->getHandValue();