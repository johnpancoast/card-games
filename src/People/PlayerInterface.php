<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\People;

use Pancoast\CardGames\Card\CardInterface;
use Pancoast\CardGames\Card\HandInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface PlayerInterface
{
    /**
     * Get user's unique id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set card hand
     *
     * @param HandInterface $hand
     * @return mixed
     */
    public function setHand(HandInterface $hand);

    /**
     * Add to card hand
     *
     * @param CardInterface $card
     * @return mixed
     */
    public function addToHand(CardInterface $card);

    /**
     * Remove card from hand
     *
     * @param CardInterface $card
     * @return mixed
     */
    public function removeFromHand(CardInterface $card);

    /**
     * @return HandInterface
     */
    public function getHand();
}