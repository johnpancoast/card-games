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
class Card implements CardInterface
{
    /**
     * @var string One of the {@see CardNumber} constants.
     */
    private $number;

    /**
     * @var string One of the {@see CardSuit} constants
     */
    private $suit;

    /**
     * Constructor
     *
     * @param string $number One of the {@see CardNumber} constants
     * @param string $suit One of the {@see CardSuit} constants
     */
    public function __construct($number, $suit)
    {
        if (!isset(CardNumber::$number) || !isset(CardSuit::$suit)) {
            throw new \LogicException('Unknown card number or suit');
        }

        $this->number = $number;
        $this->suit = $suit;
    }

    /**
     * @inheritDoc
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @inheritDoc
     */
    public function getSuit()
    {
        return $this->getSuit();
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return sprintf('%s-%s', $this->getSuit(), $this->getNumber());
    }
}