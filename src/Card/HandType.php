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
}