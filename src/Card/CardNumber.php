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
    public static function getRank($number)
    {
        if (!in_array($number, self::getAll())) {
            throw new \LogicException('Trying to get value of non-existent card');
        }

        return self::getRanks()[$number];
    }

    /**
     * Get all card number values
     *
     * Return values *must* be sequential
     *
     * @return array Sequential values
     */
    public static function getRanks()
    {
        return [
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
    }

    /**
     * Get all card numbers
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::TWO,
            self::THREE,
            self::FOUR,
            self::FIVE,
            self::SIX,
            self::SEVEN,
            self::EIGHT,
            self::NINE,
            self::TEN,
            self::JACK,
            self::QUEEN,
            self::KING,
            self::ACE,
        ];
    }
}