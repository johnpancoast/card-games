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
interface CardInterface
{
    /**
     * Get card number
     *
     * @return string
     */
    public function getNumber();

    /**
     * Get card suit
     *
     * @return string
     */
    public function getSuit();

    /**
     * Get unique id for card
     *
     * @return string
     */
    public function getId();
}