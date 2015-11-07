<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\People;

use Doctrine\Common\Collections\Collection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface PlayerCollectionInterface extends Collection
{
    /**
     * Add player
     *
     * @param PlayerInterface $player
     * @return mixed
     */
    public function addPlayer(PlayerInterface $player);

    /**
     * Create player
     *
     * @return PlayerInterface
     */
    public function createPlayer();
}