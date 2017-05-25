<?php

namespace Blackjack;

include_once 'Dealer.php';

$newDealer = new Dealer(1);
print_r($newDealer->getDealerHand());


