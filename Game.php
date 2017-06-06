<?php


namespace Blackjack;

include_once 'Shoe.php';
include_once 'Card.php';
include_once 'Hand.php';
include_once 'Dealer.php';
include_once 'Player.php';


class Game
{
    public $dealer;
    public $player;
    private $moveCount;
    private $gameStatus;
    private $db;

    public function __construct()
    {
        if ($this->Intro() == False) {
            exit;
        } else {
            $this->dealer = new Dealer($this->constructShoe());
            $this->player = new Player($this->dealer->DealHand());
            $this->moveCount = 0;
            $this->db = new \PDO("mysql:host=localhost;dbname=Blackjack", "root", null);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "\n";
            echo "Game will now begin ...\n\n";
            $this->gameStatus = True;
            $this->gameLoop();
        }
    }

    private function Intro()
    {
        $responseIntro = $this->message("Hello, would you like to play a game of blackjack? Type 'yes' or 'no':" . " ");
        if (substr(strtolower($responseIntro), 0, 1) != 'y') {
            echo "Okay maybe next time";
            return False;
        } elseif (substr(strtolower($responseIntro), 0, 1) != 'n') {
            return True;
        } else {
            echo "enter a valid response";
        }
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

    private function constructShoe()
    {
        $responseDecks = (int)$this->message("How many decks would you like to play with? ");
        return $responseDecks;
    }

    private function gameLoop()
    {
        while ($this->gameStatus == True) {
            echo "Dealer is showing ";
            $this->showDealerHand(1);
            $this->showPlayerHand();
            $this->playerTurn();
        }
        $this->endGame();
        $this->writePlayerData();
        $this->writeGameData();
        exit;
    }

    private function showDealerHand($start)
    {
        for ($i = $start; $i < count($this->handString($this->dealer->getDealerHand())); $i++) {
            echo $this->handString($this->dealer->getDealerHand())[$i] . " ";
        }
    }

    private function handString(Hand $hand)
    {
        $handArray = $hand->getHandString();
        return $handArray;
    }

    private function showPlayerHand()
    {
        echo "\nYour hand is ";
        foreach ($this->handString($this->player->getPlayerHand()) as $card) {
            echo $card . " ";
        }
    }

    private function playerTurn()
    {
        $playerHand = $this->player->getPlayerHand();
        $playerHandValue = $this->player->getPlayerHand()->getHandValue();
        if ($playerHand->isBlackjack()) {
            $this->Blackjack($playerHand);
        } elseif ($this->dealer->getDealerHand()->isBlackjack()) {
            $this->Blackjack($this->dealer->getDealerHand());
        } elseif (is_array($playerHandValue)) {
            echo "\nYour hand's value is ";
            foreach ($playerHandValue as $value) {
                echo $value . "\n";
            }
        } else {
            echo "\nYour hand's value is " . $playerHandValue . "\n";
        }
        if (substr(strtolower($this->player->wantHit()), 0, 1) != 'h') {
            $this->dealer->bestHand();
            $this->gameStatus = False;
        } else {
            $this->dealer->Hit($playerHand);
            if ($playerHand->isBust()) {
                $this->Bust($playerHand);
            }
        }
        $this->moveCount++;
    }


    private function Blackjack(Hand $hand)
    {
        if ($hand !== $this->dealer->getDealerHand()) {
            $this->showPlayerHand();
            echo "\nYou have Blackjack, Congratulations\n";
        } else {
            echo "\n The dealer has ";
            $this->showDealerHand(0);
            echo "\nThe dealer has Blackjack, you lost\n";
        }
        echo "Have a nice day " . $this->player->getPlayerName() . "\n";
        $this->writeGameData();
        $this->writePlayerData();
        exit;
    }

    private function Bust(Hand $hand)
    {
        if ($hand !== $this->dealer->getDealerHand()) {
            echo "You lost!\n" . "The house wins with a hand of ";
            $this->showDealerHand(0);
            $this->showPlayerHand();
            echo "\nBetter luck next time\n";
        } else {
            echo "You win!\n" . "Your hand was " . $this->showPlayerHand();
        }
        $this->writePlayerData();
        $this->writeGameData();
        exit;
    }

    private function endGame()
    {
        if ($this->getWinner() == 'dealer') {
            echo "\nThe dealer wins with a hand of ";
            $this->showDealerHand(0);
            echo "\nBetter luck next time\n";

        } elseif ($this->getWinner() == 'player') {
            $this->playerWin();
        }

    }

    private function getWinner()
    {
        $dealerValue = $this->dealer->getDealerHand()->getHandValue();
        $playerValue = $this->player->getPlayerHand()->getHandValue();
        if ($this->dealer->getDealerHand()->isBust()) {
            return "player";
        } elseif ($dealerValue > $playerValue) {
            return "dealer";
        } elseif (is_array($dealerValue)) {
            if (max($dealerValue) > $playerValue) {
                return true;
            }
        } else {
            return "player";
        }
    }

    private function playerWin()
    {
        $this->showPlayerHand();
        echo "\nCongratulations! You win!";
        echo "\nThe dealer had ";
        $this->showDealerHand(0);
    }

    private function writePlayerData()
    {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO players(player_first_name) VALUE (:playerName)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':playerName' => $this->player->getPlayerName()]);
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    private function writeGameData()
    {
        try {
            $this->db->beginTransaction();
            $sql = ("INSERT INTO game(
player_moves,
number_of_decks,
dealer_hand_value,
player_hand_value,
VALUES
(:moveCount,
:numberOfDecks,
:dealerHandValue,
:playerHandValue
)");
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':moveCount' => $this->moveCount,
                ':numberOfDecks' => $this->dealer->getNumberDecks(),
                ':dealerHandValue' => $this->dealer->getDealerHand()->getHandValue(),
                ':playerHandValue' => $this->player->getPlayerHand()->getHandValue()]);
            $this->db->commit();


        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }

    }

}


//TODO integrate push

new Game(1);