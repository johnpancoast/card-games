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
class HandType
{
    const HIGH_CARD = 'high card';
    const ONE_PAIR = 'one pair';
    const TWO_PAIR = 'two pair';
    const THREE_OF_A_KIND = 'three of a kind';
    const STRAIGHT = 'straight';
    const FLUSH = 'flush';
    const FULL_HOUSE = 'full house';
    const FOUR_OF_A_KIND = 'four of a kind';
    const STRAIGHT_FLUSH = 'straight flush';
    const ROYAL_FLUSH = 'royal flush';

    /**
     * Get all type constants
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::HIGH_CARD,
            self::ONE_PAIR,
            self::TWO_PAIR,
            self::THREE_OF_A_KIND,
            self::STRAIGHT,
            self::FLUSH,
            self::FULL_HOUSE,
            self::FOUR_OF_A_KIND,
            self::STRAIGHT_FLUSH,
            self::ROYAL_FLUSH,
        ];
    }

    /**
     * Get all values
     *
     * @return array
     */
    public static function getValues()
    {
        return [
            self::HIGH_CARD => 0,
            self::ONE_PAIR => 1,
            self::TWO_PAIR => 2,
            self::THREE_OF_A_KIND => 3,
            self::STRAIGHT => 4,
            self::FLUSH => 5,
            self::FULL_HOUSE => 6,
            self::FOUR_OF_A_KIND => 7,
            self::STRAIGHT_FLUSH => 8,
            self::ROYAL_FLUSH => 9,
        ];
    }

    /**
     * Get value of a type
     *
     * @param $type
     * @return mixed
     */
    public static function getValue($type)
    {
        return self::getValues()[$type];
    }
}