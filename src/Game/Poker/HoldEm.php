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
use Pancoast\CardGames\CardGameInterface;
use Pancoast\CardGames\Exception\GameLogicException;
use Pancoast\CardGames\Game\StepCollection;
use Pancoast\CardGames\People\PlayerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo Add description
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
        $collection->add([$this, '_deal']);
        return $collection;
        // @todo
        //$collection->add(<foo>);
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
    private function dealToCommunity(CardInterface $card)
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
    protected function _deal(CardGameInterface $cardGame, OutputInterface $output)
    {
        $this->buildAndShuffleDeck();

        // the practical never talked about order of deal (and i'm used to the normal hold 'em
        // where you deal the flop first etc).
        //
        // here are its words:
        // The program should deal 2 "hole" cards to each player and 5 "community" cards.
        //
        // so that's what we'll do!
        foreach ($cardGame->getPlayers() as $player) {
            for ($i = 1; $i <= 2; $i++) {
                $card = $this->deck->current();

                // attempt to clean things as much as possible for now
                try {
                    $this->deck->removeCard($card);
                    $player->addToHand($card);
                    $this->deck->next();
                } catch (\Exception $e) {
                    $this->deck->addCard($card);
                    $player->removeFromHand($card);

                    throw $e;
                }
            }
        }

        if ($this->deck->count() != 48) {
            throw new GameLogicException(sprintf("Should have 48 cards in deck but have %s", $this->deck->count()));
        }

        // deal community
        for ($i = 1; $i <= 5; $i++) {
            $card = $this->deck->current();

            // attempt to clean things as much as possible for now
            try {
                $this->deck->removeCard($card);
                $this->communityCards->addCard($card);
                $this->deck->next();
            } catch (\Exception $e) {
                $this->deck->addCard($card);
                $this->communityCards->removeCard($card);

                throw $e;
            }
        }

        if ($this->deck->count() != 43) {
            throw new GameLogicException(sprintf("Should have 43 cards in deck but have %s", $this->deck->count()));
        }
    }
}