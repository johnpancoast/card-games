<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Card;

use Doctrine\Common\Collections\ArrayCollection;
use Pancoast\CardGames\Exception\GameLogicException;

/**
 * A hand is a collection of cards that can have a "type" (e.g., three of a kind etc)
 *
 * @todo Fix getPokerHand() method. It was the last piece to the puzzle and I unfortunately
 * didn't have time to get to it before deadline =/ In real world, I would think about this
 * class more and get a little more time.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Hand extends CardCollection implements HandInterface
{
    /**
     * @var array Hand types to be skipped (because we know the hand isn't this)
     */
    private $skipTypes = [];

    /**
     * @var array A grouping of cards by suit and by number for ease in hand determination
     */
    private $groups = [];

    /**
     * @inheritDoc
     */
    public function getPokerHand()
    {
        if ($this->count() < 5) {
            throw new GameLogicException('Must have at least 5 cards to make a poker hand');
        }

        // get hand as array
        $sortedHand = $this->toArray();

        // clear current hand
        $this->clear();

        // sort our array hand
        usort($sortedHand, (function($a, $b) {
            if ($a->getRank() == $b->getRank()) {
                return 0;
            }

            return $a->getRank() < $b->getRank() ? -1 : 1;
        }));

        // recreate our current hand from sorted array
        foreach ($sortedHand as $card) {
            $this->addCard($card);
        }

        // create groups which we can can help us in determining hands.
        foreach ($sortedHand as $index => $card) {
            $cardRank = $card->getRank();

            $this->groups['suits'][$card->getSuit()][$index] = $card;
            $this->groups['numbers'][$cardRank][] = $card;
        }

        $methods = [
            HandType::ROYAL_FLUSH => 'getRoyalFlush',
            HandType::STRAIGHT_FLUSH => 'getStraightFlush',
            HandType::FOUR_OF_A_KIND => 'getFourOfAKind',
            HandType::FULL_HOUSE => 'getFullHouse',
            HandType::FLUSH => 'getFlush',
            HandType::STRAIGHT => 'getStraight',
            HandType::THREE_OF_A_KIND => 'getThreeOfAKind',
            HandType::TWO_PAIR => 'getTwoPair',
            HandType::ONE_PAIR => 'getPair',
            HandType::HIGH_CARD => 'getHighCard'
        ];

        foreach ($methods as $type => $method) {
            $hand = $this->{$method}();

            if ($hand instanceof PokerHandInterface) {
                return $hand;
            }
        }
    }

    /**
     * Get royal flush in hand or false
     *
     * @return PokerHand|false
     */
    private function getRoyalFlush()
    {
        if (isset($this->skipTypes['royal_flush'])) {
            return false;
        }

        // if we have a straight flush and the last (highest) card is an ace, we have a royal.
        $sFlush = $this->getStraightFlush();
        if ($sFlush instanceof PokerHand && $this->last()->getRank() == CardNumber::getRank(CardNumber::ACE)) {
            return new PokerHand(HandType::ROYAL_FLUSH, $sFlush);
        }

        $this->skipTypes['royal_flush'] = true;
        return false;
    }

    /**
     * Get striaght flush in hand or false
     *
     * @return PokerHand|false
     */
    private function getStraightFlush()
    {
        if (isset($this->skipTypes['straight_flush'])) {
            return false;
        }

        // to have a straight flush we must at least have a straight and a flush
        $straight = $this->getStraight();
        $flush = $this->getFlush();

        if (!$straight instanceof PokerHandInterface || !$flush instanceof PokerHandInterface) {
            $this->skipTypes['straight_flush'] = true;
            return false;
        }

        // sort the straight
        $sortedStraight = $straight->getHand()->toArray();
        usort($sortedStraight, (function($a, $b) {
            if ($a->getRank() == $b->getRank()) {
                return 0;
            }

            return $a->getRank() < $b->getRank() ? -1 : 1;
        }));

        // sort the flush
        $sortedFlush = $flush->getHand()->toArray();
        usort($sortedFlush, (function($a, $b) {
            if ($a->getRank() == $b->getRank()) {
                return 0;
            }

            return $a->getRank() < $b->getRank() ? -1 : 1;
        }));

        // do a diff of the 2 arrays. if empty that means the straight and flush
        // are the same cards and we have a straight flush
        if (empty(array_diff($sortedStraight, $sortedFlush))) {
            return new PokerHand(HandType::STRAIGHT_FLUSH, $straight->getHand());
        }

        $this->skipTypes['straight_flush'] = true;
        return false;
    }

    /**
     * Get four of a kind or false
     *
     * @return PokerHand|false
     */
    private function getFourOfAKind()
    {
        if (isset($this->skipTypes['quads'])) {
            return false;
        }

        foreach ($this->groups['numbers'] as $cardRank => $cards) {
            // 4 grouped cards is quads
            if (count($cards) == 4) {
                // clone our collection to remove the 4 we found and get the next highest
                // rank as our 5'th card for the poker hand
                $clone = clone $this;
                $hand = new Hand();

                foreach ($cards as $card) {
                    $clone->removeCard($card);
                    $hand->addCard($card);
                }

                $hand->addCard($clone->last());

                unset($clone);
                return new PokerHand(HandType::FOUR_OF_A_KIND, $hand);
            }
        }

        $this->skipTypes['quads'] = true;
        return false;
    }

    /**
     * Get full house or false
     *
     * @return PokerHand|false
     */
    private function getFullHouse()
    {
        if (isset($this->skipTypes['full_house'])) {
            return false;
        }

        // copy the numbers since we'll be unsetting
        $numbers = $this->groups['numbers'];

        foreach ($numbers as $cardRank => $cards) {
            // if it's greater than 3 it's a quad
            if (count($cards) == 3) {
                $tripCards = $cards;
                unset($numbers[$cardRank]);

                foreach ($numbers as $cardRank2 => $cards2) {
                    // if here, we got 1 set of 3 and another of 2 or more
                    if (count($cards2) >= 2) {
                        $pairCards = $cards;

                        // if the pair cards are greater than 2, then see which ranks more
                        // and switch if need be
                        if (count($pairCards) > 2 && $cardRank2 > $cardRank) {
                            $oldPairCards = $pairCards;
                            $pairCards = $tripCards;
                            $tripCards = $oldPairCards;
                        }

                        return new PokerHand(HandType::FULL_HOUSE, new Hand(array_merge($tripCards, $pairCards)));
                    }
                }
            }
        }

        $this->skipTypes['full_house'] = true;
        return false;
    }

    /**
     * Get flush or false
     *
     * @return PokerHand|false
     */
    private function getFlush()
    {
        if (isset($this->skipTypes['flush'])) {
            return false;
        }

        foreach ($this->groups['suits'] as $suit => $cards) {
            if (count($cards) >= 5) {
                return new PokerHand(
                    HandType::FLUSH,
                    new Hand(array_splice(array_reverse($cards), 0, 5))
                );
            }
        }

        $this->skipTypes['flush'] = true;
        return false;
    }

    /**
     * Get straight or false
     *
     * @return PokerHand|false
     */
    private function getStraight()
    {
        if (isset($this->skipTypes['straight'])) {
            return false;
        }

        // straights are interesting because there can be many possibilities.
        $straightGroup = [];

        // loop cards by rank/number. if rank is sequential, we're building a straight.
        $loop = 0;
        foreach ($this->groups['numbers'] as $rank => $cards) {
            // grab the next 5 elements of array
            $subject = array_slice($this->groups['numbers'], $loop, 5, true);

            // grab first and last ranks if they exist
            $firstRank = array_keys(array_slice($subject, 0, 1, true));
            $lastRank = array_keys(array_slice($subject, 4, 1, true));

            // if we don't have 5 elements or ranks, then we never will in future
            // iterations either so quit
            if (count($subject) != 5 || empty($firstRank) || empty($lastRank)) {
                $this->skipTypes['straight'] = true;
                return false;
            }

            // if the difference between last and first rank in the set we're evaluating is 4,
            // then we have a straight.
            // e.g.,
            // 5, 6, 8, 9, 10
            // 10 - 5 == 5 # not straight
            //
            // 5, 6, 7, 8, 9
            // 9 - 5 == 4 # straight
            if ($lastRank[0] - $firstRank[0] == 4) {
                // @todo recursive logic to determine all straight permutations
            }

            $loop++;
        }


        $this->skipTypes['straight'] = true;
        return false;
    }

    /**
     * Get three of a kind or false
     *
     * @return PokerHand|false
     */
    private function getThreeOfAKind()
    {
        if (isset($this->skipTypes['trips'])) {
            return false;
        }

        foreach ($this->groups['numbers'] as $cardRank => $cards) {
            // 3 grouped cards is trips
            if (count($cards) == 3) {
                // clone our collection to remove the 3 we found and get the next highest
                // rank as our 4th and 5th card for the poker hand
                $clone = clone $this;
                $hand = new Hand();

                // add the 3 we found to our hand
                foreach ($cards as $card) {
                    $clone->removeCard($card);
                    $hand->addCard($card);
                }

                // add the next 2 highest ranked
                for ($i = 1; $i <= 2; $i++) {
                    $last = $clone->last();
                    $clone->removeCard($last);
                    $hand->addCard($last);
                }

                unset($clone);
                return new PokerHand(HandType::THREE_OF_A_KIND, $hand);
            }
        }

        $this->skipTypes['trips'] = true;
        return false;
    }

    /**
     * Get two pair or false
     *
     * @return PokerHand|false
     */
    private function getTwoPair()
    {
        if (isset($this->skipTypes['two_pair'])) {
            return false;
        }

        // copy the numbers since we'll be unsetting
        $numbers = $this->groups['numbers'];

        foreach ($numbers as $cardRank => $cards) {
            // find a pair
            if (count($cards) == 2) {
                $pairCards = $cards;
                unset($numbers[$cardRank]);

                foreach ($numbers as $cardRank2 => $cards2) {
                    // if here, we got 1 set of 3 and another of 2 or more
                    if (count($cards2) == 2) {
                        $pair2Cards = $cards;
                        $clone = clone $this;
                        $hand = new Hand();

                        // build up new hand, setting the highest leftover as 5th
                        foreach ([$pairCards, $pair2Cards] as $p) {
                            foreach ($p as $card) {
                                $clone->removeCard($card);
                                $hand->addCard($card);
                            }
                        }

                        $hand->addCard($clone->last());

                        return new PokerHand(HandType::FULL_HOUSE, $hand);
                    }
                }
            }
        }

        $this->skipTypes['two_pair'] = true;
        return false;
    }

    /**
     * Get pair or false
     *
     * @return PokerHand|false
     */
    private function getPair()
    {
        if (isset($this->skipTypes['pair'])) {
            return false;
        }

        foreach ($this->groups['numbers'] as $rank => $cards) {
            if (count($cards) === 2) {
                $clone = clone $this;
                $hand = new Hand();

                foreach ($cards as $card) {
                    $clone->removeCard($card);
                    $hand->addCard($card);
                }

                for ($i = 1; $i <= 3; $i++) {
                    $last = $clone->last();
                    $clone->removeCard($last);
                    $hand->addCard($last);
                }

                return new PokerHand(HandType::ONE_PAIR, $hand);
            }
        }

        $this->pair = false;
        return false;
    }

    /**
     * Get high card
     *
     * @return PokerHand
     */
    private function getHighCard()
    {
        $x = array_reverse($this->toArray());
        array_splice($x, 0, 5);
        return new PokerHand(HandType::HIGH_CARD, new Hand($x));
    }
}