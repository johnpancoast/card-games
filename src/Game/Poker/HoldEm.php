<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Game\Poker;

use Pancoast\CardGames\AbstractCardGame;
use Pancoast\CardGames\Card\Card;
use Pancoast\CardGames\Card\CardCollection;
use Pancoast\CardGames\Card\CardInterface;
use Pancoast\CardGames\Card\CardNumber;
use Pancoast\CardGames\Card\CardSuit;
use Pancoast\CardGames\Card\PokerHandInterface;
use Pancoast\CardGames\CardGameInterface;
use Pancoast\CardGames\Exception\GameLogicException;
use Pancoast\CardGames\Game\StepCollection;
use Pancoast\CardGames\People\PlayerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Texas Hold 'Em
 *
 * Well, actually it's just a short version of it but the structure is
 * here to build the actual game if you wanted. =)
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class HoldEm extends AbstractCardGame
{
    /**
     * @var CardCollection
     */
    private $communityCards;

    /**
     * @var CardCollection
     */
    private $deck;

    /**
     * Constructor
     *
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        parent::__construct($output);

        $this->deck = new CardCollection();
        $this->communityCards = new CardCollection();
    }

    /**
     * @inheritDoc
     */
    public function getStepCollection()
    {
        $collection = new StepCollection();
        $collection->add([$this, 'deal']);
        // example of what we could've done...
        // $collection->add([$this, 'dealFlop']);
        // $collection->add([$this, 'handleBets']);
        // $collection->add([$this, 'dealTurn']);
        // $collection->add([$this, 'handleBets']);
        // $collection->add([$this, 'dealRiver']);
        // $collection->add([$this, 'handleBets']);
        $collection->add([$this, 'outputWinner']);

        return $collection;
    }

    /**
     * Build and shuffle deck
     *
     * @throws GameLogicException If card count isn't right
     */
    private function buildAndShuffleDeck()
    {
        $orderedDeck = [];

        foreach (CardSuit::getAll() as $suit) {
            foreach (CardNumber::getAll() as $number) {
                $orderedDeck[] = new Card($number, $suit);
            }
        }

        // heh. name's appropriate.
        // Who knows how "random" this really is but it works to illustrate the point here.
        shuffle($orderedDeck);

        foreach ($orderedDeck as $card) {
            $this->deck->addCard($card);
        }

        if ($this->deck->count() != 52) {
            throw new GameLogicException('We created a deck but it does not have 52 cards...');
        }
    }

    /**
     * Deal a card to player from deck
     *
     * @param PlayerInterface $player
     * @param CardInterface $card
     * @throws \Exception
     */
    private function dealCardToPlayer(PlayerInterface $player, CardInterface $card)
    {
        // attempt to clean things as much as possible for now
        try {
            $this->deck->removeCard($card);
            $player->addToHand($card);
        } catch (\Exception $e) {
            $this->deck->addCard($card);
            $player->removeFromHand($card);

            throw $e;
        }
    }

    /**
     * Deal a card to community from deck
     *
     * @param CardInterface $card
     * @throws \Exception
     */
    private function dealCardToCommunity(CardInterface $card)
    {
        // attempt to clean things as much as possible for now
        try {
            $this->deck->removeCard($card);
            $this->communityCards->addCard($card);
        } catch (\Exception $e) {
            $this->deck->addCard($card);
            $this->communityCards->removeCard($card);

            throw $e;
        }
    }

    /**
     * Assert that the deck has a certain amount of cards
     *
     * @param int $expectedAmount
     * @throws GameLogicException If deck count is not the expected amount
     * @todo Obviously this (along with many other tests) would live in src/Tests/ but I didn't want to spend my time testing a test project!
     */
    private function assertDeckCount($expectedAmount)
    {
        if ($this->deck->count() != $expectedAmount) {
            throw new GameLogicException(sprintf("Should have %s cards in deck but have %s", $expectedAmount, $this->deck->count()));
        }
    }

    ###################################################################
    #### All below methods are steps in the StepCollection we define ##
    #### in self::getStepCollection()                                ##
    ###################################################################

    /**
     * Deal cards
     *
     * @internal
     * @param CardGameInterface $cardGame
     * @param OutputInterface $output
     * @throws GameLogicException
     * @throws \Exception
     */
    protected function deal(CardGameInterface $cardGame, OutputInterface $output)
    {
        $this->buildAndShuffleDeck();
        $deckCount = $this->deck->count();

        // practical's words:
        // "The program should deal 2 "hole" cards to each player and 5 "community" cards."
        $playerCardCount = 2;
        $communityCardCount = 5;

        // deal to players
        foreach ($cardGame->getPlayers() as $player) {
            for ($i = 1; $i <= $playerCardCount; $i++) {
                $card = $this->deck->current();
                $this->dealCardToPlayer($player, $card);
            }
        }

        // deal community cards
        $this->deck->first();
        for ($i = 1; $i <= $communityCardCount; $i++) {
            $card = $this->deck->current();
            $this->dealCardToCommunity($card);
        }

        $this->assertDeckCount($deckCount - ($cardGame->getPlayers()->count() * $playerCardCount) - $communityCardCount);
    }

    /**
     * Determine and output the winner
     *
     * @param CardGameInterface $cardGame
     * @param OutputInterface $output
     * @throws GameLogicException
     * @todo Complete logic for practical.
     */
    protected function outputWinner(CardGameInterface $cardGame, OutputInterface $output)
    {
        $players = [];

        // combine player hands with community cards to make actual hands
        foreach ($cardGame->getPlayers() as $player) {
            $hand = clone $player->getHand();

            foreach ($this->communityCards as $card) {
                $hand->addCard($card);
            }

            if ($hand->count() != 7) {
                throw new GameLogicException(sprintf('Players hand should have 7 cards but it has %s', $hand->count()));
            }

            $players[$player->getId()] = $hand;
        }

        // examine hands
        // @todo Note here is where we would compare hands. Since {@see Card\Hand} is presently
        // incomplete, this is just outputting hands at the moment.
        foreach ($players as $playerId => $hand) {
            $pokerHand = $hand->getPokerHand();

            if (!$pokerHand instanceof PokerHandInterface) {
                throw new GameLogicException('Expecting a poker hand');
            }

            $output->writeln(sprintf("Player %s has a %s with cards [%s]", $playerId, $pokerHand->getType(), (string)$pokerHand));
        }
    }
}