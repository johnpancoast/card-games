<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\People;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class PlayerCollection extends ArrayCollection implements PlayerCollectionInterface
{
    /**
     * @inheritDoc
     */
    public function addPlayer(PlayerInterface $player)
    {
        return parent::set($player->getId(), $player);
    }

    /**
     * @inheritDoc
     */
    public function createPlayer()
    {
        $player = new Player();
        parent::set($player->getId(), $player);
        return $player;
    }
}