<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Card;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class PokerHand implements PokerHandInterface
{
    /**
     * @var string One of the {@see HandType} constants
     */
    private $type;

    /**
     * @var HandInterface
     */
    private $hand;

    /**
     * Constructor
     *
     * @param $type
     * @param HandInterface $hand
     */
    public function __construct($type, HandInterface $hand)
    {
        $this->type = $type;
        $this->hand = $hand;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $cards = [];

        foreach ($this->hand as $card) {
            $cards[] = $card->getId();
        }

        return implode(', ', $cards);
    }

}
