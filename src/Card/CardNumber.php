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
class CardNumber
{
    const TWO = 'two';
    const THREE = 'three';
    const FOUR = 'four';
    const FIVE = 'five';
    const SIX = 'six';
    const SEVEN = 'seven';
    const EIGHT = 'eight';
    const NINE = 'nine';
    const TEN = 'ten';
    const JACK = 'jack';
    const QUEEN = 'queen';
    const KING = 'king';
    const ACE = 'ace';

    /**
     * Get value of a card number (as in, what's the higher card)
     *
     * @param $number One of the class constants
     * @return int
     */
    public static function getValue($number)
    {
        if (!isset(CardNumber::$number)) {
            throw new \LogicException('Trying to get value of non-existent card');
        }

        $values = [
            self::TWO => 0,
            self::THREE => 1,
            self::FOUR => 2,
            self::FIVE => 3,
            self::SIX => 4,
            self::SEVEN => 5,
            self::EIGHT => 6,
            self::NINE => 7,
            self::TEN => 8,
            self::JACK => 9,
            self::QUEEN => 10,
            self::KING => 11,
            self::ACE => 12
        ];

        return $values[$number];
    }
}