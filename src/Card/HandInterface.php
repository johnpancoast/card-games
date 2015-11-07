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
interface HandInterface extends CardCollectionInterface
{
    /**
     * Get the type of this hand (e.g., royal flush)
     *
     * @return string One of the {@see HandType} constants
     */
    public function getType();
}