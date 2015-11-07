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
class CardSuit
{
    /* Card suits */
    const SPADES = 'spades';
    const CLUBS = 'clubs';
    const DIAMONDS = 'diamonds';
    const HEARTS = 'hearts';

    /**
     * Get all card suits
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::SPADES,
            self::CLUBS,
            self::DIAMONDS,
            self::HEARTS,
        ];
    }
}